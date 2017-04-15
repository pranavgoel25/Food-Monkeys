<!-- Respond to a request page -->

<?php 
session_start(); /// initialize session 
include("passwords.php"); 
check_logged(); /// function checks if visitor is logged. 
// If user is not logged the user is redirected to login.php page 
?> 


<!DOCTYPE html>
<html>

<head>
    <title>Respond to Request</title>

    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="css/icon.css" rel="stylesheet">
    <script src="css_js/bootstrap.min.js"></script>
    <link type="text/css" rel="stylesheet" href="css/materialize.min.css">
    <script type="text/javascript" src="js/jquery-2.1.1.min.js"></script>
    <script type="text/javascript" src="js/materialize.js"></script>

    <script>
        data = {};
        ids = [];

        var QueryString = function() {
            // This function is anonymous, is executed immediately and
            // the return value is assigned to QueryString!
            var query_string = {};
            var query = window.location.search.substring(1);
            var vars = query.split("&");
            for (var i = 0; i < vars.length; i++) {
                var pair = vars[i].split("=");
                // If first entry with this name
                if (typeof query_string[pair[0]] === "undefined") {
                    query_string[pair[0]] = decodeURIComponent(pair[1]);
                    // If second entry with this name
                } else if (typeof query_string[pair[0]] === "string") {
                    var arr = [query_string[pair[0]], decodeURIComponent(pair[1])];
                    query_string[pair[0]] = arr;
                    // If third or later entry with this name
                } else {
                    query_string[pair[0]].push(decodeURIComponent(pair[1]));
                }
            }
            return query_string;
        }();

        $(function() {
            $("#requestid").val(QueryString.id);
        });

        $(document).ready(function() {

            data['requestid'] = $("#requestid").val();
        });


        function submission() {

            data["id"] = "<?php echo $_SESSION['logged']; ?>";
            $.post("./php/respondaction.php", data, function(data, status) {
                document.write(data);
                setTimeout(function() {
                    window.location.href = 'home.html'
                }, 5000);
            });
        }
    </script>

</head>


<body>

    <div id="navbar"></div>

    <div class="container">

        <h1 class="center">Respond</h1>


        <h3> Confirm Response : </h3>

        <div class="row center" style="display:none">
            <div class="input-field col s12">
                <label for="requestid">Request ID </label>
                <input type="number" class="form-control" id="requestid" name="requestid" />
            </div>
        </div>

        <button type="submit" class="btn btn-default" onclick="submission()">Submit</button>

    </div>
    <br><br>
    <div id="footer" style="position:absolute;width:100vw;bottom:0vh;"></div>

</body>

<script>
    $(function() {
        $('#navbar').load('nav.php');
    });
     $(function() {
        $('#footer').load('foot.html');
    });
</script>

</html>
