<?php
// Configuration
$server = "yourserveradress"; // the adress of your mysql server (e.g. localhost if mysql was at localhost:3306)
$username = "yourmysqluser"; // the name of the mysql user (must have SELECT, INSERT, UPDATE and DELETE privileges on the database)
$password = "yourmysqluser'spassword"; // the password of the user specified in $username
$db = "yourmysqldatabase"; // the name of your mysql database 
$datadrive = "C:"; // the drive that contains mysqls 'data' folder (this is used for displaying available space to users), usally C:
$connect = new mysqli($server,$username,$password,$db);
$logLevel = 2; // What will be logged, 2: most actions, 1: developer actions, 0: only log errors, -1: nothing. recommended: 1 or 2
// Secret string that when its value is set as a cookie called "devTool" in your browser will allow you to do remove,rename and more to files. WARNING: Do not EVER tell anyone the value of this (e.g. if you set the cookie 'devTool' to 'yoursecretdevkey' it would let you use developer tools)
$devToolString="yoursecretdevkey"; // also PLEASE change this before you make the installation public
?>
