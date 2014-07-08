<?php
include('/includes/helix_common.php');
$mysqli = db_connect();
require_once('nav.php');
if(isset($_POST['username'])){
    $query = "SELECT `user_id`, `email`, `password` FROM helix_users.`users` WHERE `email` = '".$_POST['username']."'";
    $result = $mysqli->query($query);
    if($result->fetch_assoc() == null || $result->fetch_assoc() == ''){
        $insert_query = "INSERT INTO helix_users.`users` SET `email` = '".$_POST['username']."' `password` = '".$_POST['password']."' `last_action` = 'Create Account' `last_action_date` = NOW()";
        $insert_result = $mysqli->query($insert_query); //if we didn't find this user, create it
        $_SESSION['username'] = $_POST['username'];
        $_SESSION['user_id'] = $mysqli->insert_id;
    }else{
        $row = $result->fetch_assoc();
        if($row['password'] == $_POST['password']){
            $_SESSION['username'] = $_POST['username'];
            $_SESSION['user_id'] = $_POST['user_id'];
        }else{
           echo'<script>window.location="login.php";</script>';
        }
    }
}else{
   echo'<script>window.location="login.php";</script>';
}
?>
<table class="table table-striped table-bordered">
    <thead><tr><th>Title</th><th>Artist</th><th>Album</th><th>Genre</th><th>Downloads</th></tr></thead>
    <tbody>
        <tr>
            <td>Song Name</td><td>Song Artist</td><td>Song Album</td><td>Song Genre</td><td>21983</td>
        </tr>
        <tr>
            <td>Song Name2</td><td>Song Artist2</td><td>Song Album2</td><td>Song Genre2</td><td>2983</td>
        </tr>
        <tr>
            <td>Song Name3</td><td>Song Artist3</td><td>Song Album3</td><td>Song Genre3</td><td>21993</td>
        </tr>
    </tbody>
</table>
<?php
require_once('footer.html');
?>