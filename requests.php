<!-- Requests search page -->

<?php 
session_start(); /// initialize session 
#include("passwords.php"); 
#check_logged(); /// function checks if visitor is logged. 
// If user is not logged the user is redirected to login.php page 
?> 
<!DOCTYPE html>
<html>
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="css/icon.css" rel="stylesheet">
    <link type="text/css" rel="stylesheet" href="css/materialize.min.css">
    <script type="text/javascript" src="js/jquery-2.1.1.min.js"></script>
    <script type="text/javascript" src="js/materialize.js"></script>
    <title>Requests</title>
    <script>
        $(function() {
            $('#navbar').load('nav.php');
        });
    </script>
    <script>
        $(document).ready(function() {
            $("#showall").click(function() {
                $.ajax({
                    type: 'GET',
                    url: './php/allrequestsjson.php',
                    data: {
                        get_param: 'value'
                    },
                    dataType: 'json',
                    success: function(data) {
                        $("#data").css("display", "unset");
                        $("#alltag").css("display", "unset");
                        $("#normaltag").css("display", "none");
                        $('#display').empty();
                        $.each(data, function(index, element) {
                            if (element.status == "Ongoing")
                            $status = '<td><div class="chip orange">' + element.status + '</div></td>' ;
                        else
                            $status = '<td><div class="chip yellow">' + element.status + '</div></td>' ;
                            $('#display').append($('<tr><td>' + element.train + '</td>' + '<td>' + element.name + '</td>' + '<td>' + element.reason + '</td>' + '<td>' + element.sdes + '</td>' + '<td>' + element.edes + '</td>' + '<td>' + element.sdate + '</td>' +'<td>' + element.edate + '</td>' +
                            '<td><form action="respond.php" method="GET"><input type="hidden" name="id" value=' + element.id + '><input class="waves-effect waves-light btn" type="submit" value="respond"></form></td>' +
                            '<td><div class="chip">' + element.status + '</div></td>' + '</tr>'));
                        });
                    }
                });
            });
            $("#specificinfo").click(function() {
                $.ajax({
                    type: 'POST',
                    url: './php/allrequestsjson.php',
                    data: {
                        tname: $('#tname').val()
                    },
                    dataType: 'json',
                    success: function(data) {
                        $("#data").css("display", "unset");
                        $("#alltag").css("display", "none");
                        $("#normaltag").css("display", "unset");
                        $('#trainnos').empty();
                        $('#trainnos').html('Searching for partner no :' + $('#tname').val());
                        $('#display').empty();
                        if (data.length == 0)
                        {   
                            $("#data").css("display", "none");
                            $('#trainnos').html('No Available requests on this Train No.');
                        }
                        $.each(data, function(index, element) {
                            $('#display').append($('<tr><td>' + element.train + '</td>' + '<td>' + element.reason + '</td>' + '</tr>'));
                        });
                    }
                });
            });
        });
        function getttrain()
        {
                $.ajax({
                    type: 'POST',
                    url: './php/pnrtrain.php',
                    data: {
                        pnr_no: $('#pnr_no').val()
                    },
                    dataType: 'json',
                    success: function(data) {
                        $("#data1").css("display", "unset");
                        $("#normaltag1").css("display", "unset");
                        $('#trainnos1').empty();
                        $('#trainnos1').html('Searching with PNR no :' + $('#pnr_no').val());
                        $('#display2').empty();
                        if (data.length == 0)
                        {   
                            $("#data1").css("display", "none");
                            $('#trainnos1').html('No Available requests in your route');
                        }
                        $.each(data, function(index, element) {
                            $('#display2').append($('<tr><td>' + element.train + '</td>' + '<td>' + element.name + '</td>' + '<td>' + element.reason + '</td>' + '<td>' + element.sdes + '</td>' + '<td>' + element.edes + '</td>' + '<td>' + element.sdate + '</td>' +'<td>' + element.edate + '</td>' +
                            '<td><form action="respond.php" method="GET"><input type="hidden" name="id" value=' + element.id + '><input class="waves-effect waves-light btn" type="submit" value="respond"></form></td>' +
                            '<td><div class="chip">' + element.status + '</div></td>' + '</tr>'));
                        });
                    }
                });
        }
        function checkcase(a,b)
        {
            as = a.toUpperCase();
            bs = b.toUpperCase();
            return (as == bs);
        }
        function stationsearch() {
            $.ajax({
                type: 'POST',
                url: './php/stationsearch.php',
                data: {
                    sdes: $('#sstation').val(),
                    edes: $('#estation').val()
                },
                dataType: 'json',
                success: function(data) {
                        $("#data2").css("display", "unset");
                        $("#normaltag2").css("display", "unset");
                        $('#trainnos2').empty();
                        $('#trainnos2').html('Searching with given stations ');
                        $('#display3').empty();
                        if (data.length == 0)
                        {   
                            $("#data2").css("display", "none");
                            $('#trainnos2').html('No Available requests with these stations');
                        }
                    $.each(data, function(index, element) {
                            $('#display3').append($('<tr><td>' + element.train + '</td>' + '<td>' + element.name + '</td>' + '<td>' + element.reason + '</td>' + '<td>' + element.sdes + '</td>' + '<td>' + element.edes + '</td>' + '<td>' + element.sdate + '</td>' +'<td>' + element.edate + '</td>' +
                            '<td><form action="respond.php" method="GET"><input type="hidden" name="id" value=' + element.id + '><input class="waves-effect waves-light btn" type="submit" value="respond"></form></td>' +
                            '<td><div class="chip">' + element.status + '</div></td>' + '</tr>'));
                    });
                }
            });
        }
    </script>
</head>
<body>
    <div id="navbar"></div>
    <div class="center">
        <h1>Adv. Search</h1></div>
    <br>
    <div class="row">
        <div class="col s12">
            <ul class="tabs">
                <li class="tab col s3"><a href="#inbox" class="active blue-text">Partner No.</a></li>
            </ul>
        </div>
    </div>
    <div class="container">
        <div id="inbox" class="col s12">
            <br>
            <center>
                <input type="text" id="tname" name="tname" placeholder="Enter Partner Number">
                <input type="submit" id="specificinfo" class="waves-effect waves-light btn">
                <br>
                <br>
            </center>
            <div id="alltag" class="center" style="display:none;">
                <h3>Showing all requests</h3></div>
            <div id="normaltag" class="center" style="display:none;">
                <h3 id="trainnos"></h3></div>
            <div id="data" style="display:none;">
                <table class="responsive-table bordered highlight">
                    <thead>
                        <tr>
                            <th>Partner Number</th>
                            
                            <th>Reason</th>
                        </tr>
                    </thead>
                    <tbody id="display">
                    </tbody>
                </table>
            </div>
            <br>
            <br>
        </div>
    </div>
    <div id="footer"></div>
</body>
<script type="text/javascript">
    $(function() {
        $('#footer').load('foot.html');
    });
</script>
<style type="text/css">
    .tabs .indicator {
        background-color: blue;
    }
</style>
<script>
    $(document).ready(function() {
        var docHeight = $(window).height();
        var footerHeight = $('#footer').height();
        var footerTop = $('#footer').position().top + footerHeight;
        if (footerTop < docHeight) {
            $('#footer').css('margin-top', 10 + (docHeight - footerTop) + 'px');
        }
    });
</script>
</html>
