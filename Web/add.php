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

	if(isset($_POST['newLink'])){
		add();
	}
		function add(){

		$artist_name = $_REQUEST["newArtist"];
		$album_name = $_REQUEST["newAlbum"];
		$album_art = $_REQUEST["newAlbumArt"];
		$song_title = $_REQUEST["newTitle"];
		$song_link = $_REQUEST["newLink"];

		$artistID = create_artist($artist_name,$album_art);
		$album_ID = create_album($artistID, $song_link, $song_title);
		$song_ID  = add_song($album_art, $song_title, $song_link);

		header('Location: add.html');

		}

?>