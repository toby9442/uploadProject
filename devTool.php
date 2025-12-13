<?php
// Developer tools
header("Cache-Control: no-store");
include "config.php";
if ($_COOKIE['devTool']!=$devToolString) {
    header("Location: uploadui.php?error=no.");
    die();
}
$fname = urldecode($_GET['filename']);
if ($_GET['action']=="delete") {
    $connect->execute_query("DELETE FROM `files` WHERE `name`=?",[$fname]); //yes i dont even trust admins/devs to not sql inject lol
    $connect->execute_query("DELETE FROM `filesizecache` WHERE `name`=?",[$fname]);
    if ($logLevel>=1) $connect->execute_query("INSERT INTO `logs` (`action`,`type`,`account`) VALUES(CONCAT('Deleted file ',?),1,?)",[$fname,$_COOKIE['user']]);
    header("Location: uploadui.php");
}
if ($_GET['tag']) {
    $connect->execute_query("UPDATE `files` SET `tag`=? WHERE `name`=?",[urldecode($_GET['tag']),$fname]);
    if ($logLevel>=1) $connect->execute_query("INSERT INTO `logs` (`action`,`type`,`account`) VALUES(CONCAT('Set ',?,'s tag to ',?),1,?)",[$fname,urldecode($_GET['tag']),$_COOKIE['user']]);
    header("Location: uploadui.php");
}
if ($_GET['filenewname']) {
    $connect->execute_query("UPDATE `files` SET `name`=? WHERE `name`=?",[urldecode($_GET['filenewname']),$fname]);
    $connect->execute_query("UPDATE `filesizecache` SET `name`=? WHERE `name`=?",[urldecode($_GET['filenewname']),$fname]);
    if ($logLevel>=1) $connect->execute_query("INSERT INTO `logs` (`action`,`type`,`account`) VALUES(CONCAT('Set ',?,'s name to ',?),1,?)",[$fname,urldecode($_GET['filenewname']),$_COOKIE['user']]);
    header("Location: uploadui.php");
}
if ($_GET['action']=="setGolden") {
   switch ($connect->execute_query("SELECT `goldenFile` FROM `files` WHERE `name`=?",[$fname])->fetch_row()[0]) {
    case 2:
        $connect->execute_query("UPDATE `files` SET `goldenFile`=0 WHERE `name`=?",[$fname]);
        if ($logLevel>=1) $connect->execute_query("INSERT INTO `logs` (`action`,`type`,`account`) VALUES(CONCAT('Set file ',?,' to normal'),1,?)",[$fname,$_COOKIE['user']]);
        break;
    case 1:
        $connect->execute_query("UPDATE `files` SET `goldenFile`=2 WHERE `name`=?",[$fname]);
        if ($logLevel>=1) $connect->execute_query("INSERT INTO `logs` (`action`,`type`,`account`) VALUES(CONCAT('Set file ',?,' to diamond'),1,?)",[$fname,$_COOKIE['user']]);
        break;
    case 0:
        $connect->execute_query("UPDATE `files` SET `goldenFile`=1 WHERE `name`=?",[$fname]);
        if ($logLevel>=1) $connect->execute_query("INSERT INTO `logs` (`action`,`type`,`account`) VALUES(CONCAT('Set file ',?,' to golden'),1,?)",[$fname,$_COOKIE['user']]);
        break;
   };
    header("Location: devToolsMenu.php?file={$fname}");
}
?>