<!-- New User php script  -->

<!-- Validation of form left -->

<?php

if ($_SERVER['REQUEST_METHOD'] == 'POST') 
{

	$uname = $_POST['name'];
	$phone = $_POST['phone'];
	$email = $_POST['email'];
	$password = md5($_POST['password']);

    $link = new mysqli('localhost', 'root', 'gotham', 'test_db');

    if ($link->connect_error) {
        die('ERROR: Could not connect. '.$link->connect_error);
    }

    $stmt = $link->prepare('INSERT INTO omitrausers (name, phone, email, password) VALUES (?, ?, ?, ?)');
    $stmt->bind_param('ssss', $uname, $phone, $email, $password);

    if ($stmt->execute()) {
        echo '<h1>Records added successfully.</h1><br/>';
    } else {
        echo '<h3>ERROR: Please TRY Again Later</h3>';
    }
    $stmt->close();
    $link->close();

}

?>