<a href='settingsui.php' >Settings</a><br>
<?php
try {
include "settings.php";
include "lib.php";

if (date('m')==12&&$connect->execute_query("SELECT `christmasSkinOwned` FROM `accounts` WHERE `id`=?",[$_COOKIE['user']])->fetch_row()[0]==0) {
    echo "<a href='claimSkin.php?skinID=1'>Claim Christmas Skin</a><br>";
}
echo "We currently have a total of <b id='fileCount'>-</b> files uploaded, which is <b id='fileSpaceUsed'>-</b> total, <b id='diskFree'>-</b> more is available";
} catch(Exception) {
    echo "<fieldset><legend>Critical Error</legend>A critical server error has occured,<br>hopefully the servers will be functioning again soon.</fieldset>";
    die();
}

?>
        <script>
            function update() {
                    var req1 = new XMLHttpRequest()
                    req1.onload = function() {
                    document.getElementById("diskFree").innerText = Math.round(this.responseXML.getElementsByTagName("freeSpace")[0].innerHTML/1000/1000/100)/10+"GB"
                    document.getElementById("fileSpaceUsed").innerText = Math.round(this.responseXML.getElementsByTagName("spaceUsed")[0].innerHTML/1000/1000/100)/10+"GB"
                    document.getElementById("fileCount").innerText =this.responseXML.getElementsByTagName("files")[0].innerHTML
            }
            req1.open("GET","/api.php?stats");
            req1.send();
            }
            update();
            setInterval(update,15000)
        </script>
    <fieldset style='width:16%;' >
        <legend>File Upload</legend><form method="post" action="upload.php" enctype="multipart/form-data">
    <input type="file" name="file" required><br>
    <input type="text" name="renameTo" placeholder="custom file name ( optional )"><br>
    <input type="text" name="tag" placeholder="tag ( optional )"><br>
    <input type="submit" value="Upload"></form>
    </fieldset>
    <fieldset style='width:10%' >
        <legend>Search Files</legend><form method="get" action="search.php">
            <input name="searchQuery" type="text" placeholder="name"><br>
    <input type="submit" value="Search"></form><form method="get" action="searchTag.php">
            <input name="tag" type="text" placeholder="tag name"><br>
    <input type="submit" value="Search by tag"></form>
</fieldset>
    <script>
    if (location.search.startsWith("?error=duplicate")) {
                var notif = document.createElement("fieldset")
        notif.setAttribute("class","fieldScale")
        notif.innerHTML = "<legend>Upload Failed</legend>A file with the same name has already been uploaded, try renaming it"
        document.body.append(notif)
    }
        if (location.search.startsWith("?error=no.")) {
                var notif = document.createElement("fieldset")
        notif.setAttribute("class","fieldScale")
        notif.innerHTML = "<legend>...</legend>This is not for you."
        document.body.append(notif)
    }
       if (location.search.startsWith("?error=notfound")) {
                var notif = document.createElement("fieldset")
        notif.setAttribute("class","fieldScale")
        notif.innerHTML = "<legend>No File</legend>The file you tried to find was not found"
        document.body.append(notif)
    }
           if (location.search.startsWith("?error=noitems")) {
                var notif = document.createElement("fieldset")
        notif.setAttribute("class","fieldScale")
        notif.innerHTML = "<legend>Tag Error</legend>No items were found inside the requested tag"
        document.body.append(notif)
    }
    if (location.search.startsWith("?miscNotif=christmasSkinClaimed")) {
        var notif = document.createElement("fieldset")
        notif.setAttribute("class","fieldScale")
        notif.innerHTML = "<legend>Skin Claimed</legend>Successfully claimed christmas skin"
        document.body.append(notif)
    }
    </script>
    
<?php
try {
$getData = "SELECT `name`, `goldenFile` FROM `files` ORDER BY `goldenFile` DESC";
$data = $connect->query($getData);
echo "<fieldset><legend>All Files <a href='gallery.php'>Visit The Gallery</a></legend>";
displayList($data);
echo "Version <b>1.3.1</b>";
} catch(Exception) {
    displayError($e);
}
?>