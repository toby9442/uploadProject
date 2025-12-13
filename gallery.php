<!-- Gallery UI
<style>
    img {
        max-width: 5% !important;
        border-radius: 5px;
    }
    fieldset {
        max-width:80% !important;
    }
</style>
<?php
include "settings.php";
include "config.php";
if ($_GET['tag']) {
    echo "<a href='searchTag.php?tag=".htmlspecialchars(urldecode($_GET['tag']))."'>Back</a><br>";
    $data = $connect->execute_query("SELECT `name`, `mtype` FROM `files` WHERE `tag`= ? ORDER BY `goldenFile` DESC",[urldecode($_GET['tag'])]);
    if ($logLevel>=2) $connect->execute_query("INSERT INTO `logs` (`action`) VALUES(CONCAT('Viewed gallery ',?))",[urldecode($_GET['tag'])]);
    echo "<fieldset><legend>Images Tagged With <b>".htmlspecialchars(urldecode($_GET['tag']))."</b></legend>";
} else {
    echo "<a href='uploadui.php' >Back</a><br>";
    $data = $connect->execute_query("SELECT `name`, `mtype` FROM `files` ORDER BY `goldenFile` DESC");
    if ($logLevel>=2) $connect->execute_query("INSERT INTO `logs` (`action`) VALUES('Viewed gallery')");
    echo "<fieldset><legend>All images</legend>";
}

    while($item = $data->fetch_assoc()) {
        if (str_starts_with($item["mtype"],"image"))
echo "<a href='findui.php?filename=".htmlspecialchars($item["name"])."'><img src='find.php?filename=".htmlspecialchars($item["name"])."'></a>";
    }
    echo "</fieldset>";
?>