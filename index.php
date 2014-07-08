<?php
include('/includes/helix_common.php');
$mysqli = db_connect();
require_once('nav.php');
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