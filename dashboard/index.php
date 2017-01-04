<?php
require_once($_SERVER["DOCUMENT_ROOT"] . '/../Support/configMISProjectRequest.php');
require_once($_SERVER["DOCUMENT_ROOT"] . '/../Support/basicLib.php');

if (isset($_GET['search'])) {
    try {
        $sql = 'SELECT submitter_uniqname,submitter_first_name,submitter_last_name, contact_uniqname, contact_first_name, contact_last_name, priority,full_description,short_description,created
                FROM responses
                WHERE submitter_last_name LIKE ? AND short_description LIKE ? AND contact_last_name LIKE ?
                ORDER BY created DESC, contact_last_name';
        $stmt = $db->stmt_init();
        if (!$stmt->prepare($sql)) {
            $error = $stmt->error;
        } else {
            $stmt->bind_param('sss', $last_name, $short_description, $contact_last_name);
            $last_name = '%' . $_GET['submitter_last_name'] . '%';
            $contact_last_name = '%' . $_GET['contact_last_name'] . '%';
            $short_description = '%' . $_GET['short_description'] . '%';
            $stmt->execute();
            $stmt->bind_result($uniqname, $first_name, $last_name, $contact_uniqname, $contact_first_name, $contact_last_name, $priority, $full_description, $short_description, $date_entered);
        }
    } catch (Exception $e) {
        $error = $e->getMessage();
    }
}
?>

<!doctype html>
<html class="no-js" lang="">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="x-ua-compatible" content="ie=edge">
        <title>LSA-<?php echo "$appTitle";?></title>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="description" content="<?php echo "$appTitle";?>">
        <meta name="keywords" content="LSA,<?php echo $deptLngName;?>,<?php echo "$appTitle";?>,University of Michigan">
        <meta name="author" content="LSA-MIS_rsmoke">
        <link type="text/plain" rel="author" href="../humans.txt" />

        <link rel="apple-touch-icon" href="../apple-touch-icon.png">
        <link rel="icon" href="../favicon.ico">
        <!-- Place favicon.ico in the root directory -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha256-916EbMg70RQy9LHiGkXzG8hSg9EdNy97GazNG/aiY1w=" crossorigin="anonymous">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha256-ZT4HPpdCOt2lvDkXokHuhJfdOKSPFLzeAJik5U/Q+l4=" crossorigin="anonymous">

        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.0/jquery-ui.min.css" integrity="sha256-NRYg+xSNb5bHzrFEddJ0wL3YDp6YNt2dGNI+T5rOb2c=" crossorigin="anonymous">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.0/jquery-ui.structure.min.css" integrity="sha256-BqNqkUORr/AcpXU3ploO0dTrvb0PPjhDEi3q7PiM8ng=" crossorigin="anonymous">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.0/jquery-ui.theme.min.css" integrity="sha256-HQ93J0nrYQ3eaKvwWaffUshLBHZW+nrgxFLvay4Hzf8=" crossorigin="anonymous">


        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-formhelpers/2.3.0/css/bootstrap-formhelpers.min.css" integrity="sha256-v8+xOYOnVjQoSDMOqD0bqGEifiFCcuYleWkx2pCYsVU=" crossorigin="anonymous" media="screen">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/normalize/4.2.0/normalize.min.css" integrity="sha256-K3Njjl2oe0gjRteXwX01fQD5fkk9JFFBdUHy/h38ggY=" crossorigin="anonymous">

<!--        <link rel="stylesheet" href="css/normalize.css">-->
        <link rel="stylesheet" href="../css/main.css">
        <script src="../js/vendor/modernizr-2.8.3.min.js"></script>
<!--        <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/modernizr/2.8.3/modernizr.min.js" integrity="sha256-0rguYS0qgS6L4qVzANq4kjxPLtvnp5nn2nB5G1lWRv4=" crossorigin="anonymous"></script>-->
    </head>
    <body>
        <!--[if lt IE 8]>
            <p class="browserupgrade">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> to improve your experience.</p>
        <![endif]-->

        <!-- Add your site or application content here -->
        <nav class="navbar navbar-default navbar-fixed-top navbar-inverse" role="navigation">
            <div class="container">
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button> <a class="navbar-brand" href="../index.php">
                        <?php echo "$appTitle";?> - Dashboard</a>
                </div>
                <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                    <ul class="nav navbar-nav navbar-right">
                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown">Signed in as <?php echo $login_name;?><strong class="caret"></strong></a>
                            <ul class="dropdown-menu">
                                <li>
                                    <a href="https://weblogin.umich.edu/cgi-bin/logout">logout</a>
                                </li>
                            </ul>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>


        <div class="container"><!--Container of all things -->
            <div class="row clearfix">
                <h1>&nbsp;</h1>
                <div class="col-md-10 col-md-offset-1 page-header">
                    <?php if (isset($error)) {
                        echo "<p>$error</p>";
                    } ?>
                    <form class="form-inline" method="get" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                        <div class="form-group">
                            <label for="last_name">Last name: </label>
                            <input type="text" name="last_name" id="last_name">
                        </div>
                        <div class="form-group">
                            <label for="contact_last_name">Contact Last name: </label>
                            <input type="text" name="contact_last_name" id="contact_last_name">
                        </div>
                        <div class="form-group">
                            <label for="short_description">Short_description: </label>
                            <input type="text" name="short_description" id="short_description">
                        </div>

                        <div class="form-group">
                            <input type="submit" name="search" value="Search">
                        </div>
                    </form>
                    <em>NOTE: Leave search fields blank to find all records</em>
                </div>
            </div>
            <div class="row clearfix">
                    <?php
                    if (isset($_GET['search'])) {
                        $stmt->store_result();
                        $numrows = $stmt->num_rows;
                        if (!$numrows) {
                            echo '<p>No results found.</p>';
                        } else {
                            ?>
                            <table class="table table-striped">
                                <tr>
                                    <th>Uniqname</th>
                                    <th>Full Name</th>
                                    <th>Contact Uniqname</th>
                                    <th>Contact Full Name</th>
                                    <th>Short Description</th>
                                    <th>Priority</th>
                                    <th>Full Description</th>
                                    <th>Submitted</th>
                                </tr>
                                <?php while ($stmt->fetch()) { ?>
                                    <tr>
                                        <td><?php echo $uniqname; ?></td>
                                        <td><?php echo $first_name . " " . $last_name; ?></td>
                                        <td><?php echo $contact_uniqname; ?></td>
                                        <td><?php echo $contact_first_name . " " . $contact_last_name; ?></td>
                                        <td class="scrollable"><?php echo $short_description; ?></td>
                                        <td><?php echo $priority; ?></td>
                                        <td class="scrollable"><div><?php echo $full_description; ?></div></td>
                                        <td><?php echo date("n-j-Y g:iA", strtotime($date_entered)); ?></td>
                                    </tr>
                                <?php }  ?>
                            </table>
                        <?php }
                    }
                    if (isset($db)) {
                        $db->close();
                    }
                    ?>
            </div>
        </div> <!-- END of container of all things -->

        <?php
        include('../footer.php');
        ?>

<!--        <script src="https://code.jquery.com/jquery-1.12.0.min.js"></script>-->
        <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.1.0/jquery.min.js" integrity="sha256-cCueBR6CsyA4/9szpPfrX3s49M9vUU5BgtiJj06wt/s=" crossorigin="anonymous"></script>
        <script>window.jQuery || document.write('<script src="../js/vendor/jquery-1.12.0.min.js"><\/script>')</script>
        <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.0/jquery-ui.min.js" integrity="sha256-eGE6blurk5sHj+rmkfsGYeKyZx3M4bG+ZlFyA7Kns7E=" crossorigin="anonymous"></script>
        <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha256-U5ZEeKfGNOja007MMD3YBI0A3OSZOQbeG6z2f2Y0hu8=" crossorigin="anonymous"></script>
        <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-formhelpers/2.3.0/js/bootstrap-formhelpers.min.js" integrity="sha256-H7Mu9l17V/M6Q1gDKdv27je+tbS2QnKmoNcFypq/NIQ=" crossorigin="anonymous"></script>
        <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/velocity/1.2.2/velocity.min.js"></script>
        <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/velocity/1.2.2/velocity.ui.min.js"></script>
        <script src="../js/plugins.js"></script>
        <script src="../js/main.js"></script>

        <!-- Google Analytics: change UA-84157001-1 to be your site's ID. -->
        <?php include_once('../analyticstracking.php') ?>
    </body>
</html>
