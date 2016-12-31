<?php
require_once($_SERVER["DOCUMENT_ROOT"] . '/../Support/basicLib.php');
$uniqName = $_POST['lookup_uniq'];
$ldapDetails = [];

$ds=ldap_connect("ldap.umich.edu");  // must be a valid LDAP server!
if ($ds) { // this is an "anonymous" bind, typically read-only access
    // Search surname entry
    $sr=ldap_search($ds, "ou=People,dc=umich,dc=edu", "uid=$uniqName");
    $info = ldap_get_entries($ds, $sr);
    if (count($info) > 1 ){
        if (array_key_exists('cn', $info[0])) {
            if (strlen($info[0]["cn"][0]) > 0) {
                $str = explode(" ", $info[0]["cn"][0]);
                $firstName = $str[0];
                $lastName = $str[count($str) - 1];
            }
        } else {
            $firstName = "----";
            $lastName = "----";
        }
        if (array_key_exists('umichpostaladdress', $info[0])) {
            if (strlen($info[0]["umichpostaladdress"][0]) > 0) {
                $str = explode(" $ ", $info[0]["umichpostaladdress"][0]);
                $department = $str[0];
            }
        } else {
            $department = "----";
        }
        ldap_close($ds);

        $ldapDetails["first_name"] = $firstName;
        $ldapDetails += ["last_name" =>  $lastName, "department" => $department ];
        echo (json_encode($ldapDetails));
    } else {
      echo (json_encode(array("empty")));
    }
}
