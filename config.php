<?php
$servername = "localhost";
$username = "root";
$password = "Gopi@123";
$dbname = "healthhub";

// Create connection
$conn =mysqli_connect($servername,$username,$password,$dbname);
if(!$conn)
{
    die("unable to connect");
}