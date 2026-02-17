<?php 
session_start();
$_SESSION['authorised'] = "no";
if ($_SESSION['authorised'] != "yes") {
    header("<location:templates>login.html.php");
}