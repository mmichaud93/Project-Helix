<html>

    <head>
        <title>Project Helix</title>
        <meta name="viewport" content="width=device-width, minimum-scale=1.0, initial-scale=1.0, user-scalable=yes">
        <link href='http://fonts.googleapis.com/css?family=Lato|Montserrat+Alternates|Roboto' rel='stylesheet' type='text/css'>
        <link rel="stylesheet" href="./styles.css">
        <link rel="stylesheet" href="./bootstrap-3.2.0-dist/css/bootstrap.css">
        <style>
            .helix-index-description {
                font-size: 32px;
                color: #4e495b;
                font-family: 'Lato', sans-serif;
            }
            .helix-index-item {
                background-color:#e3ecef;
                padding: 8px;
                margin-right: 4px;
                margin-left:4px;
                border-radius: 4px;
            }
            .helix-index-item:hover {
                background-color:#ccd4d7;
                cursor: pointer;
            }
            .helix-index-message {
                font-size: 24px;
                color: #4e495b;
                font-family: 'Lato', sans-serif;
            }
            .helix-index-item-image {
                width: 64px;
            }
            .helix-index-item-title {
                font-size: 18px;
            }
            .helix-index-item-artist {
                font-size: 14px;
            }
            .helix-index-get-started {
                font-size: 18px;
            }
        </style>
    </head>
    <?php 
date_default_timezone_set("America/New_York");
require_once('../includes/helix_common.php');
session_start();
if(!isset($_SESSION['user_id'])){
    error_log('session not found');
    header('Location: login.php');
    exit();
}
$user_id = $_SESSION['user_id'];
$new_song_row = get_new_songs_table();
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
            <div class="row" style="margin-top:48px;">
                <div class="col-md-12 helix-index-description"  style="text-align: center;">
                    Project Helix is the leading platform for hip-hop fans and fanatics.
                </div>
            </div>
            <div class="row" style="margin-top:64px; background-color:#d3d1aa; padding:8px;">
                <?php echo $new_song_row; ?>
            </div>
            <div class="row" style="margin-top:196px;">
                <div class="col-md-12 helix-index-message"  style="text-align: center;">
                    Be among the billions that have already started to use this website
                </div>
            </div>
            <div class="row" style="margin-top:48px;">
                <div class="col-md-12" style="text-align: center;">
                    <button class="btn btn-helix helix-index-get-started">Get Started</button>
                </div>
            </div>
        </div>

        <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js"></script>
        <script type="text/javascript" src="./bootstrap-3.2.0-dist/js/bootstrap.min.js"></script>
        <script type="text/javascript" src="./functionality.js"></script>
    </body>

</html>