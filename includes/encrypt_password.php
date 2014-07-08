<?php
if($argc < 3){echo "proper use - encrypt_password.php password 1 vesta.pem";}
require_once('encrypt_decrypt.php');
$encrypted=encrypt_decrypt($argv[1], $argv[2], $argv[3]);
echo "encrypted password\n".$encrypted;
?>
