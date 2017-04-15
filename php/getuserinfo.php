<?php
session_start(); 
// include("passwords.php"); 
function getinfo($phone)
{
	$link = mysqli_connect('localhost', 'root', 'gotham', 'test_db');

    if ($link === false) {
        die('ERROR: Could not connect. '.mysqli_connect_error());
    }
    // $sql = "SELECT * FROM omitratest WHERE edes ='".$edes."'; ";
    
    $sql = "SELECT * FROM omitrausers WHERE phone ='".$phone."'; ";

    $result = $link->query($sql);

    $num_rows = mysqli_num_rows($result);

    mysqli_close($link);

    $row = mysqli_fetch_assoc($result);

    $details = array();
    $details['name'] = $row['name'];
    $details['phone'] = $row['phone'];
    $details['email'] = $row['email'];
    
    echo json_encode($details, JSON_PRETTY_PRINT);
}
getinfo($_SESSION['logged']);

?>