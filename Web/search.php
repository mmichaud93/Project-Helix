<!doctype html>
<html>

    <head>
        <title>Project Helix</title>
        <meta name="viewport" content="width=device-width, minimum-scale=1.0, initial-scale=1.0, user-scalable=yes">
        <link href='http://fonts.googleapis.com/css?family=Lato|Montserrat+Alternates|Roboto' rel='stylesheet' type='text/css'>
        <link rel="stylesheet" href="./styles.css">
        <link rel="stylesheet" href="./bootstrap-3.2.0-dist/css/bootstrap.css">
        <style>
            .helix-search-description {
                font-size: 32px;
                color: #4e495b;
                font-family: 'Lato', sans-serif;
            }
            .helix-search-item {
                background-color:#e3ecef;
                padding: 8px;
                margin-right: 4px;
                margin-left:4px;
                margin-top: 8px;
                margin-bottom: 8px;
            }
            .helix-search-item:hover {
                background-color:#ccd4d7;
                cursor: pointer;
            }
            .helix-search-message {
                font-size: 24px;
                color: #4e495b;
                font-family: 'Lato', sans-serif;
            }
            .helix-search-item-image {
                width: 96px;
            }
            .helix-search-item-title {
                font-size: 18px;
            }
            .helix-search-item-artist {
                font-size: 14px;
            }
            .helix-search-get-started {
                font-size: 18px;
            }
        </style>
    </head>

<?php 
date_default_timezone_set("America/New_York");
require_once('../includes/helix_common.php');
$song_table = "";
session_start();
if(!isset($_SESSION['user_id'])){
    error_log('session not found');
    header('Location: login.php');
    exit();
}
$user_id = $_SESSION['user_id'];
if(isset($_POST['searchBox'])){
        $x = $_REQUEST['searchBox'];
        $song_table = get_songs_search_table($x);

    } else{
        $song_table = get_songs_search_table("");
    }
?>
    <body>
        <nav class="navbar navbar-default helix-nav" role="navigation">
            <div class="container">
                <div class="navbar-header">
                    <a class="navbar-brand helix-title" href="./index.php">Project Helix</a>
                </div>
                <ul class="nav navbar-nav">
                    <li><a href="./index.php">Home</a></li>
                    <li><a href="./search.php">Discover</a></li>
                    <li><a href="./add.html">Add</a></li>
                    <li style="text-align:right;"><a href="logout.php">Log Out</a></li>
                </ul>
            </div>
        </nav>
        <div class="container helix-card">

            <div class="row" style="margin-top:24px; margin-bottom:48px;">
            <form action = "search.php" method = "post">
                <div class="col-md-4 col-md-offset-3 helix-search-message">
                    <input type="text" name = "searchBox" class="form-control" placeholder="Search">
                </div>
                <div class="col-md-2 helix-search-message">
                    <button class="btn btn-helix">Search</button>
                </div>
            </form>
            </div>
            <div class="row" style="margin-top:64px; background-color:#d3d1aa; padding:8px;">
                <?php echo $song_table; ?>
            </div>

        </div>

        <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js"></script>
        <script type="text/javascript" src="./bootstrap-3.2.0-dist/js/bootstrap.min.js"></script>
        <script type="text/javascript" src="./functionality.js"></script>
    </body>

</html>