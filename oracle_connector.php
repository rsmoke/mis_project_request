<?php

// Connects to the MYDB database described in tnsnames.ora file,
// One example tnsnames.ora entry for MYDB could be:
//   MYDB =
//     (DESCRIPTION =
//       (ADDRESS = (PROTOCOL = TCP)(HOST = mymachine.oracle.com)(PORT = 1521))
//       (CONNECT_DATA =
//         (SERVER = DEDICATED)
//         (SERVICE_NAME = XE)
//       )
//     )

$conn = oci_connect('USERNAME', 'PASSWORD', 'dwprod.world');
if (!$conn) {
    $e = oci_error();
    trigger_error(htmlentities($e['message'], ENT_QUOTES), E_USER_ERROR);
}

$mcomm_user_query = "
      SELECT  p.name, p.first_name, p.last_name, j.appt_dept_descr, j.job_indicator, j.appt_dept_grp, lower(u.campus_id) AS uniqname
      FROM
        m_hrdw1.personal_data p
        inner join m_hrdw1.job j
         on p.emplid = j.emplid
        inner join m_hrdw1.work_address u
         on j.emplid = u.emplid
      WHERE
        sysdate between j.job_effdt and j.job_end_dt
        and j.empl_status in ('A', 'L', 'P', 'W')
        and j.emplid = (select emplid from m_hrdw1.work_address where lower(campus_id) = ?)
      --  and j.appt_dept_grp = 'COLLEGE_OF_LSA'
        and  j.per_org = 'EMP' and j.poi_type = ' ' and  j.reg_temp = 'R'
      ORDER BY
        j.job_indicator, j.appt_dept_descr";

$stid = oci_parse($conn, $mcomm_user_query);
oci_execute($stid);

echo "<table border='1'>\n";
while ($row = oci_fetch_array($stid, OCI_ASSOC+OCI_RETURN_NULLS)) {
    echo "<tr>\n";
    foreach ($row as $item) {
        echo "    <td>" . ($item !== null ? htmlentities($item, ENT_QUOTES) : "&nbsp;") . "</td>\n";
    }
    echo "</tr>\n";
}
echo "</table>\n";

?>