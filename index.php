<?php
require_once($_SERVER["DOCUMENT_ROOT"] . '/../Support/configMISProjectRequest.php');
require_once($_SERVER["DOCUMENT_ROOT"] . '/../Support/basicLib.php');

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
        <link type="text/plain" rel="author" href="humans.txt" />

        <link rel="apple-touch-icon" href="apple-touch-icon.png">
        <link rel="icon" href="favicon.ico">
        <!-- Place favicon.ico in the root directory -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha256-916EbMg70RQy9LHiGkXzG8hSg9EdNy97GazNG/aiY1w=" crossorigin="anonymous">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha256-ZT4HPpdCOt2lvDkXokHuhJfdOKSPFLzeAJik5U/Q+l4=" crossorigin="anonymous">

        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.0/jquery-ui.min.css" integrity="sha256-NRYg+xSNb5bHzrFEddJ0wL3YDp6YNt2dGNI+T5rOb2c=" crossorigin="anonymous">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.0/jquery-ui.structure.min.css" integrity="sha256-BqNqkUORr/AcpXU3ploO0dTrvb0PPjhDEi3q7PiM8ng=" crossorigin="anonymous">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.0/jquery-ui.theme.min.css" integrity="sha256-HQ93J0nrYQ3eaKvwWaffUshLBHZW+nrgxFLvay4Hzf8=" crossorigin="anonymous">


        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-formhelpers/2.3.0/css/bootstrap-formhelpers.min.css" integrity="sha256-v8+xOYOnVjQoSDMOqD0bqGEifiFCcuYleWkx2pCYsVU=" crossorigin="anonymous" media="screen">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/normalize/4.2.0/normalize.min.css" integrity="sha256-K3Njjl2oe0gjRteXwX01fQD5fkk9JFFBdUHy/h38ggY=" crossorigin="anonymous">

<!--        <link rel="stylesheet" href="css/normalize.css">-->
        <link rel="stylesheet" href="css/main.css">
        <script src="js/vendor/modernizr-2.8.3.min.js"></script>
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
                    </button> <a class="navbar-brand" href="index.php">
                        <?php echo "$appTitle";?></a>
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
                <div class="col-md-8 col-md-offset-2 jumbotron">

                    <?php if(isset($_POST['submit'])){
                        $to = "ahlgrenl+83pvnknn9nygoezumfop@boards.trello.com"; // this is your Email address
                        $from = htmlspecialchars($_POST['email']); // this is the sender's Email address
                        $first_name = htmlspecialchars($_POST['first_name']);
                        $last_name = htmlspecialchars($_POST['last_name']);
                        $contact_uniqname = htmlspecialchars($_POST['contact_uniqname']);
                        $contact_first_name = htmlspecialchars($_POST['contact_first_name']);
                        $contact_last_name = htmlspecialchars($_POST['contact_last_name']);
                        $contact_email = htmlspecialchars($_POST['contact_email']);
                        $contact_department = htmlspecialchars($_POST['contact_department']);
                        $short_description = htmlspecialchars($_POST['short_description']);
                        $full_description = htmlspecialchars($_POST['full_description']);
                        $priority = htmlspecialchars($_POST['priority']);
                        $subject = $short_description . " | From: " . $first_name . " " . $last_name ." | Date: " . date("m/d/Y");
                        $subject2 = "Copy of your Project Request form submission";
                        $messageFooter = "-- Please do not reply to this email. If you requested a reply or more information is required, you will be contacted at the email address you provided. --";
                        $addContactMessage = "";
                        if ($login_name != $contact_uniqname){
                            $addContactMessage = "\n\nThis project was submitted by proxy.\n\nProject Contact info:=>\n\nContact uniqname=> ". $contact_uniqname . "\n\nContact Full Name=> " . $contact_first_name . " " . $contact_last_name . "\n\nContact email=> " . $contact_email;
                        }
                        $message = "logged in as=> " . $login_name . "\n\nFull Name=> " . $first_name . " " . $last_name . "\n\nemail=> " . $from . $addContactMessage . "\n\nShort Description=> " . $short_description . "\n\nPriority=> " . $priority .  "\n\nFull Description:" . "\n\n" . $full_description;
                        $message2 = "Here is a copy of your project request " . $first_name . "\n\nShort Description=> " . $short_description . "\n\nPriority=> " . $priority . "\n\nFull Description:" . "\n\n" . $full_description;

                        $headers = "From:" . $from;
                        $headers2 = "From:" . $to;
                        mail($to,$subject,$message,$headers);
                        mail($from,$subject2,$message2, "From:lsamisprojectrequest@umich.edu"); // sends a copy of the message to the sender
                        echo "<h4>Mail Sent.</h4> <p>Thank you " . $first_name . " for sending your project request! We’ve sent you a copy of this message at the email address you provided.<br>
Have a great day!</p>";

                        // prepare and bind
                        $sqlInsert = <<<_SQL
    INSERT INTO `responses`
    (`submitter_uniqname`,
    `submitter_first_name`,
    `submitter_last_name`,
    `submitter_email`,
    `contact_uniqname`,
    `contact_first_name`,
    `contact_last_name`,
    `contact_email`,
    `contact_department`,
    `priority`,
    `full_description`,
    `short_description`)
    VALUES
    (?,?,?,?,?,?,?,?,?,?,?,?);
_SQL;

                        $stmt = $db->prepare($sqlInsert);
                        if( false === $stmt ) {
                            db_fatal_error('prepare() failed: ', htmlspecialchars($db->error), $stmt);
                        }
                        $rc = $stmt->bind_param("ssssssssssss", $login_name, $first_name, $last_name, $from, $contact_uniqname, $contact_first_name, $contact_last_name, $contact_email, $contact_department, $priority, $full_description, $short_description);
                        if ( false===$rc ) {
                            // again execute() is useless if you can't bind the parameters. Bail out somehow.
                            db_fatal_error('bind_param() failed: ',htmlspecialchars($stmt->error), $stmt);
                        }

                        // set parameters and execute
                        $rc = $stmt->execute();
                        // execute() can fail for various reasons. And may it be as stupid as someone tripping over the network cable
                        // 2006 "server gone away" is always an option
                        if ( false===$rc ) {
                            db_fatal_error('execute() failed: ',htmlspecialchars($stmt->error));
                        }

                        $stmt->close();

                        $login_name = $first_name = $last_name = $priority = $from = $full_description = $short_description = null;
                        $contact_uniqname = $contact_first_name = $contact_last_name = $contact_email = $contact_department = null;

                        echo "<a class='btn btn-success' href='index.php'>Add Another Request</a>&nbsp;<a class='btn btn-info' href='https://webapps.lsa.umich.edu/admindata'>Return to MIS admin page</a>";
                        // You can also use header('Location: thank_you.php'); to redirect to another page.
                        unset($_POST['submit']);
                    } else {
                        ?>
                        <h3>Fill out and submit this form for website or stand alone project requests</h3>
                        <h4 class='text-primary'>Include existing webpages or other resources associated with this request in the <em>Detailed Description</em> box below.</h4>
                        <small>If you would like to be contacted please specify that in your message.</small>
                        <?php $submitter_username = ldapGleaner($login_name);?>
                        <h5>Submitter Details</h5>
                        <div id="submitter_block">
                        <h6>Uniqname: <?php echo $login_name ?></h6>
                        <h6>First Name: <?php echo $submitter_username[0] ?></h6>
                        <h6>Last Name: <?php echo $submitter_username[1] ?></h6>
                        <h6>Email: <?php echo $login_name ?>@umich.edu</h6>
                        <h6>Department: <?php echo $submitter_username[2] ?></h6>
                        </div>

                        <?php $contact_username = ldapGleaner($login_name);?>
                        <h5>Project Contact</h5>

                        <form role="form" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post" >
                            <input type="hidden" name="first_name" value="<?php echo $submitter_username[0] ?>">
                            <input type="hidden" name="last_name" value="<?php echo $submitter_username[1] ?>">
                            <input type="hidden" name="email" value="<?php echo $login_name ?>@umich.edu">

                            <div class="form-group">
                                <label for="contact_uniqname">uniqname:</label><input id="contact_uniqname" required type="text" class="form-control" name="contact_uniqname" value="<?php echo $login_name ?>">
                            </div>
                            <div class="form-group">
                                <label for="contact_first_name">First Name:</label><input id="contact_first_name" required type="text" class="form-control" name="contact_first_name" value="<?php echo $contact_username[0] ?>">
                            </div>
                            <div class="form-group">
                                <label for="contact_last_name">Last Name:</label><input id="contact_last_name" required type="text" class="form-control" name="contact_last_name" value="<?php echo $contact_username[1] ?>">
                            </div>
                            <div class="form-group">
                                <label for="contact_email">Email:</label><input id="contact_email" required type="email" class="form-control" name="contact_email" value="<?php echo $login_name ?>@umich.edu">
                            </div>
                            <div class="form-group">
                                <label for="contact_department">Department:</label><input id="contact_department" required type="text" class="form-control" name="contact_department" value="<?php echo $contact_username[2] ?>">
                            </div>
                            <div class="form-group">
                                <label for="short_description">Short Description:</label><input required type="text" class="form-control" id="short_description" name="short_description">
                                <span id="statusArea"></span>
                            </div>

                                <div class="form-group">
                                    <label for="full_description">Detailed Description:</label><textarea rows="5" class="form-control" name="full_description" cols="30"></textarea>
                                </div>

                               <div class="form-group">
                                <label for="priority">Priority:</label>
                                <select required class="form-control" name="priority">
                                    <option value="">--- Select ---</option>
                                    <option value="high">High</option>
                                    <option value="medium">Medium</option>
                                    <option value="low">Low</option>
                                </select>
				</div>
                                <input type="submit" name="submit" value="Submit">
                        </form>

                        <?php
                    }
                    ?>
                </div>
            </div>
        </div> <!-- END of container of all things -->
        <?php
        include("footer.php");
        ?>

<!--        <script src="https://code.jquery.com/jquery-1.12.0.min.js"></script>-->
        <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.1.0/jquery.min.js" integrity="sha256-cCueBR6CsyA4/9szpPfrX3s49M9vUU5BgtiJj06wt/s=" crossorigin="anonymous"></script>
        <script>window.jQuery || document.write('<script src="js/vendor/jquery-1.12.0.min.js"><\/script>')</script>
        <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.0/jquery-ui.min.js" integrity="sha256-eGE6blurk5sHj+rmkfsGYeKyZx3M4bG+ZlFyA7Kns7E=" crossorigin="anonymous"></script>
        <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha256-U5ZEeKfGNOja007MMD3YBI0A3OSZOQbeG6z2f2Y0hu8=" crossorigin="anonymous"></script>
        <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-formhelpers/2.3.0/js/bootstrap-formhelpers.min.js" integrity="sha256-H7Mu9l17V/M6Q1gDKdv27je+tbS2QnKmoNcFypq/NIQ=" crossorigin="anonymous"></script>
        <script src="js/plugins.js"></script>
        <script src="js/main.js"></script>

        <!-- Google Analytics: change UA-84157001-1 to be your site's ID. -->
        <?php include_once("analyticstracking.php") ?>
    </body>
</html>
