<html>

    <head>
        <title>Project Helix</title>
        <meta name="viewport" content="width=device-width, minimum-scale=1.0, initial-scale=1.0, user-scalable=yes">
        <link href='http://fonts.googleapis.com/css?family=Lato|Montserrat+Alternates|Roboto' rel='stylesheet' type='text/css'>
        <link rel="stylesheet" href="./styles.css">
        <link rel="stylesheet" href="./bootstrap-3.2.0-dist/css/bootstrap.css">
        <script src="//code.jquery.com/jquery-1.11.0.min.js"></script>
        <script type="text/javascript" src="./bootstrap-3.2.0-dist/js/bootstrap.min.js"></script>
        <script type="text/javascript" src="./functionality.js"></script>
        <script src="../js/Parsley.js-2.0.3/dist/parsley.min.js"></script>
        <?php
date_default_timezone_set("America/New_York");
require_once('../includes/helix_common.php');
session_start();
$mysqli=db_connect();
if (isset($_POST["Submit"])){
    $user_name=$_POST['email'];
    if (!filter_var($user_name, FILTER_VALIDATE_EMAIL)){
        $mymessage="Malformed email address.";
        $_SESSION['user_note']='login_error';
        header('Location: login.php');
        exit();
    }
    // To protect MySQL injection
    $user_name = stripslashes($user_name);
    $user_name = mysqli_real_escape_string($mysqli, $user_name);
    $password = $_POST['password'];
    $login_query = "SELECT `password`, `user_id` FROM helix_users.`users` WHERE `email` = '".$user_name."'";
    $query_result = $mysqli->query($login_query);
    $login_array = $query_result->fetch_assoc();
    if($query_result === false || $login_array['user_id'] === '' || !isset($login_array['user_id'])){
        error_log('didnt find user in database');
    }else{
        error_log('we found this user, just need to authenticate them');
        if ($login_array['password'] != hash('sha256', $password)){
            error_log('user password incorrect');
            $_SESSION['user_note']='login_error';
            header('Location: login.php');
            exit();
        }
    }


    error_log('Session Started');
    if(isset($login_array['user_id'])){
        $_SESSION['user_id'] = $login_array['user_id'];
        error_log('USER_ID:'.$_SESSION['user_id']);
        $_SESSION['user_note'] = "";
        header('Location: index.php');
        exit();
    }else{
        header('Location: login.php');
        exit();
    }

}
if (isset($_POST["Create"])){
    //encrypt password
    $encrypted_password = hash('sha256', $_POST['password']);
    //Put info into users table
    $insert = $mysqli->query("INSERT INTO helix_users.`users`(`email`, `password`, `last_action`, `last_action_date`) VALUES ('".$_POST['user_name']."', '$encrypted_password', 'User Created', NOW())");
    //redirect to index
    $_SESSION['user_id'] = $_POST['user_name'];
    echo '<meta http-equiv="refresh" content="0;URL=index.php" />';
}
        ?>

        <body>
            <div class="container">
                <div class="row">
                    <div class="span12">
                        <div class="" id="loginModal">
                            <div class="modal-header">
                                <h3>Project Helix</h3>
                            </div>
                            <div class="modal-body">
                                <div class="well">
                                    <ul class="nav nav-tabs">
                                        <li class="active"><a href="#login" data-target="#login" data-toggle="tab">Login</a></li>
                                        <li><a href="#create" data-target="#create" data-toggle="tab">Create Account</a></li>
                                    </ul>
                                    <div id="myTabContent" class="tab-content">

                                        <div class="tab-pane active in" id="login">
                                            <form name="form1" class="form-horizontal" action='' method="POST" data-parsley-validate>
                                                <fieldset>
                                                    <div id="legend" style="padding-top:10px">
                                                        <legend class="">Login</legend>
                                                    </div>
                                                    <?php if(isset($_SESSION['user_note']) && $_SESSION['user_note'] == 'login_error'){ ?>
                                                    <div class="alert alert-danger alert-dismissible" role="alert">
                                                        <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                                        <strong>Error!</strong> Incorrect user email or password.
                                                    </div>
                                                    <?php } 
if(isset($_SESSION['user_note'])){
$_SESSION['user_note'] == '';
}?>
                                                    <div class="control-group">
                                                        <!-- Username -->
                                                        <label class="control-label"  for="username">Email Address</label>
                                                        <div class="controls">
                                                            <input type="email" id="username" name="email" placeholder="" class="form-control" required>
                                                        </div>
                                                    </div>

                                                    <div class="control-group">
                                                        <!-- Password-->
                                                        <label class="control-label" for="password">Password</label>
                                                        <div class="controls">
                                                            <input type="password" id="password" name="password" placeholder="" class="form-control" required>
                                                        </div>
                                                    </div>


                                                    <div class="control-group" style="margin-top:10px;">
                                                        <!-- Button -->
                                                        <div class="controls" style="text-align:center">
                                                            <button name="Submit" class="btn btn-success">Login</button>
                                                        </div>
                                                    </div>
                                                </fieldset>
                                            </form>
                                        </div>
                                        <div class="tab-pane fade" id="create">
                                            <form id="tab" action='' method="POST" data-parsley-validate>
                                                <div id="legend" style="padding-top:10px">
                                                    <legend class="">Create Account</legend>
                                                </div>
                                                <label>Email Address*</label>
                                                <input id="email" name="user_name" type="email" value="" class="form-control" required>
                                                <label>Password*</label>
                                                <input id="password" name="password" type="password" value="" class="form-control" required>


                                                <div style="margin-top:10px;text-align:center">
                                                    <button class="btn btn-primary" name="Create">Create Account</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </body>
    </html>
