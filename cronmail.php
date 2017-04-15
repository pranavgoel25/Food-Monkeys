<?php

$link = new mysqli('localhost', 'root', 'gotham', 'test_db');

$message = '
<h4>Requests in Next 7 days:</h4>
<table class="bordered highlight centered responsive-table">
<tr>
	<th>From</th>
	<th>To</th>
	<th>Package Type</th>
	<th>Package Weight</th>
	<th>Start Date</th>
	<th>End Date</th>
	<th>Status</th>
</tr>';

$datetoday = date("Y-m-d");
$sql = "select * from omitratest where sdate > '". $datetoday. "' order by sdate limit 7 ;";
$result = $link->query($sql);

while ($r = mysqli_fetch_assoc($result)) {

	$sql1 = "select * from omitraresponse where requestid = " . $r['id'] . " ;";
	$result1 = $link->query($sql1);
	$numrows = mysqli_num_rows($result1);
	if ($numrows)
		$r["status"] = "Ongoing";
	else
		$r["status"] = "Idle";

	$toadd = '<tr>

	<td>'.$r["sdes"].'</td>
	<td>'.$r["edes"].'</td>
	<td>'.$r["type"].'</td>
	<td>'.$r["weight"].'</td>
	<td>'.$r["sdate"].'</td>
	<td>'.$r["edate"].'</td>
	<td>'.$r["status"].'</td>
	</tr>';

	$message .= $toadd ; 

}

$message1=
	'
    </table>
    <h4>Requests in Past 7 days:</h4>
<table class="bordered highlight centered responsive-table">
<tr>
	<th>From</th>
	<th>To</th>
	<th>Package Type</th>
	<th>Package Weight</th>
	<th>Start Date</th>
	<th>End Date</th>
	<th>Status</th>
</tr>';

$message .= $message1 ;

$sql = "select * from omitratest where edate < '". $datetoday. "' order by edate DESC limit 7 ;";
$result = $link->query($sql);

while ($r = mysqli_fetch_assoc($result)) {

	$sql1 = "select * from omitraresponse where requestid = " . $r['id'] . " ;";
	$result1 = $link->query($sql1);
	$numrows = mysqli_num_rows($result1);
	if ($numrows)
		$r["status"] = "Ongoing";
	else
		$r["status"] = "Idle";

	$toadd = '<tr>

	<td>'.$r["sdes"].'</td>
	<td>'.$r["edes"].'</td>
	<td>'.$r["type"].'</td>
	<td>'.$r["weight"].'</td>
	<td>'.$r["sdate"].'</td>
	<td>'.$r["edate"].'</td>
	<td>'.$r["status"].'</td>
	</tr>';

	$message .= $toadd ; 

}

 $message2 =
    '
    </table>
    <h4>Travellers who want to help:</h4>
<table class="bordered highlight centered responsive-table">
<tr>
	<th>From</th>
	<th>To</th>
	<th>Start Date</th>
	<th>End Date</th>
</tr>';

$message .= $message2 ;


$sql = "select * from omitratravellertest where sdate > '". $datetoday. "' order by sdate limit 7 ;";
$result = $link->query($sql);

while ($r = mysqli_fetch_assoc($result)) {

	$toadd = '<tr>

	<td>'.$r["sdes"].'</td>
	<td>'.$r["edes"].'</td>
	<td>'.$r["sdate"].'</td>
	<td>'.$r["edate"].'</td>
	</tr>';

	$message .= $toadd ; 

}

$message3 = '
	</table>
	<br>
    <p>You see that many people are interested in Peer Parcelling through OMitra.</p>
    <p>Thank you for using OMitra .</p>
    </div>
    </body>
    </html>
    ';

$message .= $message3 ;



	$sql = 'SELECT * FROM omitrausers ; ';
	$result = $link->query($sql);
while (	$myrow = mysqli_fetch_assoc($result) )
{
	$rname = $myrow['name'];
	$rphone = $myrow['phone'];
	$remail = $myrow['email'];


	$image = 'https://image4.owler.com/logo/omitra_owler_20160228_133224_original.png';

	$to = $remail;
	$subject = 'OMitra Peer Parcelling - Digest';
	$topmessage = '<html>
	<head>
	<title>OMitra Digest</title>

	<!-- Compiled and minified CSS -->
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/0.97.8/css/materialize.min.css">

	<!-- Compiled and minified JavaScript -->
	<script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/0.97.8/js/materialize.min.js"></script>
	        
	</head>
	<body>
	<div class="container">
	<img src=' .$image.'>
	<p>Hello '.$rname.', Greetings from OMitra.</p>
	';


    // Always set content-type when sending HTML email
    $headers = 'MIME-Version: 1.0'."\r\n";
    $headers .= 'Content-type:text/html;charset=UTF-8'."\r\n";
    mail($to, $subject, $topmessage . $message, $headers);
    echo 'Mail Sent To - ' . $remail;
}

mysqli_close($link);

?>