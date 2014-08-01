<?php
////////////////////////////////////////////////////////////////////////////////////////////////////////////
//Notes:
//
//get_log_level(): returns log level, 1=all logs, 0=errors only
//log($user_id, $activity): returns log_id from the log insert
//create_user($email, $password): returns user_id, also stores user session
//create_album($artist_id, $url, $title, $release_date): returns album_id
//function create_artist($artist_name, $banner_url): returns artist_id
//add_song($album_id, $title, $url): returns song_id
//get_artist_table($artist_id): returns full html table for that artist
//get_album_table($album_id): returns full html table for that album
//get_songs(): returns array containing: song_id, song_title, song_url, artist_name, album_title, create_date, click_count for all songs
//get_song_by_id($song_id): returns array containing: song_id, song_title, song_url, artist_name, album_title, create_date, downloads for provided song_id
//get_songs_table(): returns full html table for all songs
//get_popular_songs_table(): returns full html table for top 11 songs in database (by click_count)
//get_new_songs_table(): returns full html table for most recent 11 songs in database (by create_date)
//get_banner_art_url($artist_id): returns url for artist banner art
//get_album_art_url($album_id): returns url for album art
//
////////////////////////////////////////////////////////////////////////////////////////////////////////////
function get_log_level(){
    // 1 = all logs, 0 = errors only
    $log_level = 1;
    return($log_level);
}
function db_connect(){
    $dbhost = "localhost"; $dbuser = "root"; $dbpw = ""; $db = "helix_inventory";
    $mysqli = new mysqli($dbhost,$dbuser,$dbpw,$db);
    if ($mysqli->connect_errno) {
        echo "Failed to connect to MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
        error_log( "Failed to connect to MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error);
        exit(false); // will need to be more graceful in the future
        //return(false);
    }
    return($mysqli);
}
function e_log($user_id, $activity){
    $mysqli=db_connect();
    $query = "INSERT INTO helix_logs.activity_log(`activity`, `date`, `user_id`) VALUES('$activity', NOW(), '$user_id')";
    $result = $mysqli->query($query);
    $return = $mysqli->insert_id;
    return($return);
}
function create_user($email, $password){
    require_once('encrypt_decrypt.php');
    $log_level = get_log_level();
    $mysqli=db_connect();
    $encrypted_password = encrypt_decrypt($password, 1, 'helix.pem');
    $query = "INSERT INTO helix_users.users(`email`, `password`, `last_action`, `last_action_date`) VALUES('".$email."', '".$encrypted_password."', 'create', NOW())";
    $result = $mysqli->query($query);
    if($result === false){
        error_log('Mysqli query failed to create user');
        return(false);
    }
    else{
        if($log_level === 1){
            error_log('Successfully inserted user into the database');
        }
        $return = $mysqli->insert_id;
        e_log($return, 'User Created', $return);
        return($return);
    }

    if(session_start()){
        $_SESSION['user_id']=$return;
        $_SESSION['email']=$email;
        if($log_level === 1){
            error_log('Started user session and inserted their user_id and email');
        }
        return(true);
    }else{
        error_log('Could not start user session');
        return(false);
    }
}
function create_album($artist_id, $url, $title){
    $mysqli=db_connect();
    $log_level = get_log_level();
    if(isset($_SESSION['user_id'])){
        error_log('User id was found in session storage when creating album');
        $query = "INSERT INTO helix_inventory.albums(`artist_id_fk`, `artwork_url`, `title`, `create_date`, `create_by`, `last_action`, `last_action_date`) VALUES('".$artist_id."', '".$url."', '".$title."', NOW(), '".$_SESSION['user_id']."', 'create', NOW())";
        $result = $mysqli->query($query);
        if($result === false){
            error_log('Mysqli query failed to insert album into the database');
            return(false);
        }else{
            $return = $mysqli->insert_id;
            if($log_level === 1){
                error_log('Successfully created album');
            }
            log($_SESSION['user_id'],  $return);
            return($return);
        }
    }else{
        error_log('User id not found in session. Redirecting to login.');
        header("Location: login.php");
        return(false);
    }
}
function create_artist($artist_name, $banner_url){
    $mysqli=db_connect();
    $log_level = get_log_level();
    if(isset($_SESSION['user_id'])){
        if($log_level === 1){
            error_log('User id was found in session storage when creating artist');
        }
        $query = "INSERT INTO helix_inventory.artists(`artist_name`, `banner_url`, `create_date`, `create_by`, `last_action`, `last_action_date`) VALUES('".$artist_name."', '".$banner_url."', NOW(), '".$_SESSION['user_id']."', 'create', NOW())";
        $result = $mysqli->query($query);
        if($result === false){
            error_log('Mysqli query failed to insert artist into the database');
            return(false);
        }else{
            $return = $mysqli->insert_id;
            if($log_level === 1){
                error_log('Successfully created artist');
            }
            log($_SESSION['user_id'], 'Created Artist');
            return($return);
        }
    }else{
        error_log('User id not found in session. Redirecting to login.');
        header("Location: login.php");
        return(false);
    }
}
function add_song($album_id, $title, $url){
    $mysqli=db_connect();
    $log_level = get_log_level();
    if(isset($_SESSION['user_id'])){
        if($log_level === 1){
            error_log('User id was found in session storage when creating song');
        }
        $query = "INSERT INTO helix_inventory.songs(`album_id_fk`, `title`, `song_url`, `create_date`, `create_by`, `last_action`, `last_action_date`) VALUES('".$album_id."', '".$title."', '".$url."', NOW(), '".$_SESSION['user_id']."', 'create', NOW())";
        $result = $mysqli->query($query);
        if($result === false){
            error_log('Mysqli query failed to insert song into the database');
            return(false);
        }else{
            $return = $mysqli->insert_id;
            if($log_level === 1){
                error_log('Successfully added song to the database');
            }
            e_log($_SESSION['user_id'], 'Added Song', $return);
            return($return);
        }
    }else{
        error_log('User id not found in session. Redirecting to login.');
        header("Location: login.php");
        return(false);
    }
}
function get_artist_table($artist_id){
    $mysqli=db_connect();
    $query = "SELECT songs.`song_id`, songs.`title` AS song_title, songs.`song_url`, artists.`artist_name`, albums.`title` AS album_title, songs.`create_date`, songs.`click_count` FROM helix_inventory.songs JOIN helix_inventory.albums ON songs.`album_id_fk` = albums.`album_id` JOIN helix_inventory.artists ON albums.`artist_id_fk` = artists.`artist_id` WHERE artists.`artist_id` = '$artist_id'";
    $return = $mysqli->query($query);
    if($return === false){
        error_log('Failed to get artist table');
        return(false);
    }else{
        $artist_table = "<table class = 'table table-striped table-bordered'><thead><tr><th>&nbsp;</th><th>Song Name</th><th>Artist</th><th>Album</th><th>Date Added</th></tr></thead><tbody>";
        $i=0;
        while($row = $return->fetch_assoc()){
            $artist_table .= "<tr data-href='".$row['song_url']."'><td>$i</td><td>'".$row['song_title']."'</td><td>'".$row['artist_name']."'</td><td>'".$row['album_title']."'</td><td>'".$row['create_date']."'</td><td>'".$row['click_count']."'</td></tr>";
        }
        $artist_table .= "</tbody></table>";
        return($artist_table);
    }
}
function get_album_table($album_id){
    $mysqli=db_connect();
    $query = "SELECT songs.`song_id`, songs.`title` AS song_title, songs.`song_url`, artists.`artist_name`, albums.`title` AS album_title, songs.`create_date`, songs.`click_count` FROM helix_inventory.songs JOIN helix_inventory.albums ON songs.`album_id_fk` = albums.`album_id` JOIN helix_inventory.artists ON albums.`artist_id_fk` = artists.`artist_id` WHERE albums.`album_id` = '$album_id'";
    $return = $mysqli->query($query);
    if($return === false){
        error_log('Failed to get artist table');
        return(false);
    }else{
        $album_table = "<table class = 'table table-striped table-bordered'><thead><tr><th>&nbsp;</th><th>Song Name</th><th>Artist</th><th>Album</th><th>Date Added</th></tr></thead><tbody>";
        $i=0;
        while($row = $return->fetch_assoc()){
            $album_table .= "<tr data-href='".$row['song_url']."'><td>$i</td><td>'".$row['song_title']."'</td><td>'".$row['artist_name']."'</td><td>'".$row['album_title']."'</td><td>'".$row['create_date']."'</td><td>'".$row['click_count']."'</td></tr>";
        }
        $album_table .= "</tbody></table>";
        return($album_table);
    }
}
function get_songs(){
    $mysqli=db_connect();
    $query = "SELECT songs.`song_id`, songs.`title` AS song_title, songs.`song_url`, artists.`artist_name`, albums.`title` AS album_title, songs.`create_date`, songs.`click_count` FROM helix_inventory.songs JOIN helix_inventory.albums ON songs.`album_id_fk` = albums.`album_id` JOIN helix_inventory.artists ON albums.`artist_id_fk` = artists.`artist_id` WHERE 1";
    $return = $mysqli->query($query);
    if($return === false){
        error_log('Failed to get songs');
        return(false);
    }else{
        while($row = $return->fetch_assoc()){
            $song['song_id'] = $row['song_id'];
            $song['song_name'] = $row['song_title'];
            $song['song_url'] = $row['song_url'];
            $song['artist_name'] = $row['artist_name'];
            $song['album_name'] = $row['album_title'];
            $song['create_date'] = $row['create_date'];
            $song['downloads'] = $row['click_count'];
        }
        return($song);
    }
}
function get_song_by_id($song_id){
    $mysqli=db_connect();
    $query = "SELECT songs.`song_id`, songs.`title` AS song_title, songs.`song_url`, artists.`artist_name`, albums.`title` AS album_title, songs.`create_date`, songs.`click_count` FROM helix_inventory.songs JOIN helix_inventory.albums ON songs.`album_id_fk` = albums.`album_id` JOIN helix_inventory.artists ON albums.`artist_id_fk` = artists.`artist_id` WHERE songs.`song_id` = '$song_id'";
    $return = $mysqli->query($query);
    if($return === false){
        error_log('Failed to fetch song');
        return(false);
    }else{
        while($row = $return->fetch_assoc()){
            $song['song_id'] = $row['song_id'];
            $song['song_name'] = $row['song_title'];
            $song['song_url'] = $row['song_url'];
            $song['artist_name'] = $row['artist_name'];
            $song['album_name'] = $row['album_title'];
            $song['create_date'] = $row['create_date'];
            $song['downloads'] = $row['click_count'];
        }
        return($song);
    }
}
function get_songs_table(){
    $mysqli=db_connect();
    $query = "SELECT songs.`song_id`, songs.`title` AS song_title, songs.`song_url`, artists.`artist_name`, albums.`artwork_url`, albums.`title` AS album_title, songs.`create_date`, songs.`click_count` FROM helix_inventory.songs JOIN helix_inventory.albums ON songs.`album_id_fk` = albums.`album_id` JOIN helix_inventory.artists ON albums.`artist_id_fk` = artists.`artist_id` WHERE 1";
    $return = $mysqli->query($query);
    $songs_table='<div class="row " data="song_3">';
    if($return === false){
        error_log('Failed to get songs table');
        return(false);
    }else{
        $i=1;
        while($row = $return->fetch_assoc()){
            if($i % 11 === 0){
                 $songs_table .='</div>';
                $songs_table .='<div class="row " data="song">';
            }
           $songs_table.="<div class='col-md-1 helix-index-item' data='song' style='text-align: center;' onclick='goTo('".$row['song_url']."')'>
                    <div class='row'>
                        <img src='".$row['artwork_url']."' class='img-rounded helix-index-item-image'>
                    </div>
                    <div class='row helix-index-item-title'>
                        ".$row['song_title']."
                    </div>
                    <div class='row helix-index-item-artist'>
                        ".$row['artist_name']."
                    </div>
                </div>";
            $i++;
        }
        $songs_table .="</div>";
        return($songs_table);
    }
}
function get_popular_songs_table(){
    $mysqli=db_connect();
    $query = "SELECT songs.`song_id`, songs.`title` AS song_title, songs.`song_url`, artists.`artist_name`, albums.`title` AS album_title, songs.`create_date`, songs.`click_count` FROM helix_inventory.songs JOIN helix_inventory.albums ON songs.`album_id_fk` = albums.`album_id` JOIN helix_inventory.artists ON albums.`artist_id_fk` = artists.`artist_id` WHERE ORDER BY `click_count` DESC LIMIT 11";
    $return = $mysqli->query($query);
    $songs_table="";
    if($return === false){
        error_log('Failed to get popular songs table');
        return(false);
    }else{
        while($row = $return->fetch_assoc()){
            $songs_table.="<div class='col-md-1 helix-index-item' data='song' style='text-align: center;' onclick='goTo('".$row['song_url']."')'>
                    <div class='row'>
                        <img src='".$row['artwork_url']."' class='img-rounded helix-index-item-image'>
                    </div>
                    <div class='row helix-index-item-title'>
                        ".$row['song_title']."
                    </div>
                    <div class='row helix-index-item-artist'>
                        ".$row['artist_name']."
                    </div>
                </div>";
        }
        return($songs_table);
    }
}
function get_new_songs_table(){
    $mysqli=db_connect();
    $query = "SELECT songs.`song_id`, songs.`title` AS song_title, songs.`song_url`, artists.`artist_name`, albums.`artwork_url`, albums.`title` AS album_title, songs.`create_date`, songs.`click_count` FROM helix_inventory.songs JOIN helix_inventory.albums ON songs.`album_id_fk` = albums.`album_id` JOIN helix_inventory.artists ON albums.`artist_id_fk` = artists.`artist_id` WHERE 1 ORDER BY songs.`create_date` LIMIT 11";
    $return = $mysqli->query($query);
    $songs_table="";
    if($return === false){
        error_log('Failed to get new songs table');
        return(false);
    }else{
        while($row = $return->fetch_assoc()){
            
            $songs_table.="<div class='col-md-1 helix-index-item' data='song' style='text-align: center;' onclick='location.href=&quot;".$row['artwork_url']."&quot;;'>
                    <div class='row'>
                        <img src='".$row['artwork_url']."' class='img-rounded helix-index-item-image'>
                    </div>
                    <div class='row helix-index-item-title'>
                        ".$row['song_title']."
                    </div>
                    <div class='row helix-index-item-artist'>
                        ".$row['artist_name']."
                    </div>
                </div>";
            
        }
        return($songs_table);
    }
}
function get_banner_art_url($artist_id){
    $mysqli=db_connect();
    $query ="SELECT artists.`banner_url` FROM helix_inventory.`artists` WHERE `artist_id` = '$artist_id'";
    $return = $mysqli->query($query);
    if($return === false){
        error_log('Mysqli failed to get banner art');
        return(false);
    }else{
        $row = $return->fetch_assoc();
        return($row['banner_url']);
    }
}
function get_album_art_url($album_id){
    $mysqli=db_connect();
    $query ="SELECT albums.`artwork_url` FROM helix_inventory.`albums` WHERE `album_id` = '$album_id'";
    $return = $mysqli->query($query);
    if($return === false){
        error_log('Mysqli failed to get album art');
        return(false);
    }else{
        $row = $return->fetch_assoc();
        return($row['artwork_url']);
    }
}
?>