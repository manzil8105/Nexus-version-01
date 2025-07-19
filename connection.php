<?php
$dbname = "Nexus";
$dbhost = "localhost";
$dbuser =  "root";
$dbpass =   "";
$conn   = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname);
if (!$conn) {
    die("Something went wrong");
}
