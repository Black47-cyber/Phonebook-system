<?php
$conn = mysqli_connect("localhost", "root", "", "phonebook");
if(!$conn){
    die("Connection failed: ".mysqli_connect_error());
}
?>