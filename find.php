<?php
// file handler
header("Access-Control-Allow-Origin: *");
header("Accept-Ranges: bytes");
header("X-Content-Type-Options: nosniff");
include "config.php";
$getData = $connect->execute_query("SELECT fileBlob,mtype FROM `files` WHERE `name`=?",[explode(".",$_GET['filename'])[0]]);
if ($logLevel>=2) $connect->execute_query("INSERT INTO `logs` (`action`,`account`) VALUES(CONCAT('Viewed file ',?),?)",[explode(".",$_GET['filename'])[0],$_COOKIE['user']]);
$data = $getData->fetch_row();
$getSize = $connect->execute_query("SELECT `size` FROM `filesizecache` WHERE `name`= ?",[explode(".",$_GET['filename'])[0]]);
$size = $getSize->fetch_row()[0];
if (!$data) {
    header("Location: uploadui.php?error=notfound");
    die();
}

if ($_GET['download']) {
header("Content-Disposition: attachment; filename={$_GET['filename']}");
}
header("Content-Type: {$data[1]}");
echo $data[0]; // no im really not bothered to fuck with byte ranges
?>