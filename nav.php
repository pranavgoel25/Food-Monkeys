<!-- Common Nav Bar template for all pages -->

<?php 
session_start(); /// initialize session 
include("passwords.php"); 
/// function checks if visitor is logged. 
// If user is not logged the user is redirected to login.php page  
?>

<!DOCTYPE html>
<html>

<head>
    <title>Main</title>

    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="css/icon.css" rel="stylesheet">
    <link type="text/css" rel="stylesheet" href="css/materialize.min.css">
    <script type="text/javascript" src="js/jquery-2.1.1.min.js"></script>
    <script type="text/javascript" src="js/materialize.js"></script>

</head>

<body>

    <nav>
        <div class="nav-wrapper light-blue darken-4">

            <a href="home.html" class="brand-logo" style="padding-left:10px;">Food Monkeys</a>
            <a href="#" data-activates="mobile-demo" class="button-collapse"><i class="material-icons">menu</i></a>
            <ul class="right hide-on-med-and-down">
                <li><a href="home.html">Home</a></li>
                <li><a href="form.php">Submit a Request</a></li>
                <li><a href="requests.php">See Requests</a></li>
            </ul>
            <ul class="side-nav" id="mobile-demo">
                <li><a href="home.html">Home</a></li>
                <li><a href="form.php">Submit a Request</a></li>
                <li><a href="requests.php">See Requests</a></li>
                </ul>
        </div>
    </nav>
    
</body>

<script type="text/javascript">
    $(document).ready(function() {
        $(".button-collapse").sideNav();
    });

    function logout() {
    path = 'login.php';
    parameters = {ac:"logout"};
    var form = $('<form></form>');

    form.attr("method", "post");
    form.attr("action", path);

    $.each(parameters, function(key, value) {
        var field = $('<input></input>');

        field.attr("type", "hidden");
        field.attr("name", key);
        field.attr("value", value);

        form.append(field);
    });

    // The form needs to be a part of the document in
    // order for us to be able to submit it.
    $(document.body).append(form);
    form.submit();
    }

</script>

</html>
