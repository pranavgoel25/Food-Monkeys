<!-- Traveller Form fill page -->

<?php 
session_start(); /// initialize session 
include("passwords.php"); 
check_logged(); /// function checks if visitor is logged. 
// If user is not logged the user is redirected to login.php page 
?> 

<!DOCTYPE html>
<html>

<head>
    <title>Submit Request</title>

    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="css/icon.css" rel="stylesheet">
    <script src="css_js/bootstrap.min.js"></script>
    <link type="text/css" rel="stylesheet" href="css/materialize.min.css">
    <script type="text/javascript" src="js/jquery-2.1.1.min.js"></script>
    <script type="text/javascript" src="js/materialize.js"></script>

    <script>
        $(document).ready(function() {
            data = {};
            ids = [
                "train",
                "sdes",
                "edes", 
                "sdate",
                "edate"
            ];
            errors = {};
            errors["sdesErr"]="";
            errors["edesErr"]="";
            for (id = 0; id < ids.length; id++) {
                data[ids[id]] = $("#".concat(ids[id])).val();
            }
        });

        function validate(id) {
            data[id] = $("#".concat(id)).val();
            data["which"] = id.concat("Err");
            data["id"] = "<?php echo $_SESSION['logged']; ?>";
            $.post("./php/travellerformaction.php", data, function(dat, status) {
                $("#".concat(id.concat("Err"))).html(dat);
                errors[id.concat("Err")] = dat;
            });
        }

        function submission() {
            for (id = 0; id < ids.length; id++) {
                validate(ids[id]);
            }
            for (id = 0; id < ids.length; id++) {
                if (errors[ids[id].concat("Err")] != "") {
                    alert("Please input correct details before submitting.");
                    return;
                }
            }
            data["which"] = "correct";
            $.post("./php/travellerformaction.php", data, function(data, status) {
                document.write(data);
                setTimeout(function() {
                    window.location.href = 'home.html'
                }, 5000);
            });
        }
    </script>

    <style type="text/css">
        span {
            color: red;
        }
    </style>

</head>

<body>


    <div id="navbar"></div>

    <div class="container">

        <div class="center">
            <h3>Let Others Know</h3></div><br><br>


        <div class="row">
            <div class="col s12">
                <ul class="tabs">
                    <li class="tab col s3"><a class="active blue-text" href="#test1">Fulfillment ranges</a></li>
                </ul>
            </div>

            <div id="test1" class="col s12">

                <div class="row">
                    <div class="input-field col s12">
                        <input type="text" id="train" name="train" onblur="validate('train');buildstart();" />
                        <label for="train">Train No. *</label>
                        <span id="trainErr"></span>
                    </div>
                </div>

                <div class="row">
                    <div class="input-field col s12">
                        <select id="sdes" onchange="buildend();">
                                <option value="" disabled selected>Choose your option</option>
                            </select>
                        <label>Start Destination</label>
                        <span id="sdesErr"></span>
                    </div>
                </div>

                <div class="row">
                    <div class="input-field col s12">
                        <select id="edes">
                                <option value="" disabled selected>Choose your option</option>
                            </select>
                        <label>End Destination</label>
                        <span id="edesErr"></span>
                    </div>
                </div>

                <div class="row">
                    <div class="input-field col s12">
                        <label for="sdate">Start Date *</label>
                        <input type="text" class="datepicker" id="sdate" name="sdate" onchange="validate('sdate')" />
                        <span id="sdateErr"></span>
                    </div>
                </div>

                <div class="row">
                    <div class="input-field col s12">
                        <label for="edate">End Date *</label>
                        <input type="text" class="datepicker" id="edate" name="edate" onchange="validate('edate')" />
                        <span id="edateErr"></span>
                    </div>
                </div>

                <div class="right">
                    <button type="submit" onclick="submission();" class="waves-effect waves-light btn-large green">Submit</button>
                </div>

            </div>

        </div>

    </div>
    <br>

    <div id="footer"></div>

</body>
<script type="text/javascript">
    function buildend() {

        $flag = 0;
        $('#edes').empty();
        $.ajax({
            type: 'POST',
            url: './php/gettrainroute.php',
            data: {
                train_no: $('#train').val()
            },
            dataType: 'json',
            success: function(data) {

                $('#edes').append($('<option value="NULL" >').text("Select"));
                $('#edes').material_select();
                $.each(data, function(k, v) {

                    if (v == $('#sdes').val())
                        $flag = 1;

                    if ($flag == 1) {
                        $('#edes').append($('<option value="' + v + '" >').text(v));
                        $('#edes').material_select();
                    }

                });

            }

        });

    }
    $(function() {
        $('#footer').load('foot.html');

            $('.datepicker').pickadate({
        selectMonths: true, // Creates a dropdown to control month
        selectYears: 15, // Creates a dropdown of 15 years to control year
        format: 'dd-mm-yyyy'
    });
    });
</script>

<script>
    $(function() {
        $('#navbar').load('nav.php');
    });

    $(document).ready(function() {
        $('ul.tabs').tabs();
    });

</script>


<style type="text/css">
    .tabs .indicator {
        background-color: blue;
    }
</style>
<script>
    function buildstart() {
        $('#sdes').empty();
        $.ajax({
            type: 'POST',
            url: './php/gettrainroute.php',
            data: {
                train_no: $('#train').val()
            },
            dataType: 'json',
            success: function(data) {

                $('#sdes').append($('<option value="NULL" >').text("Select"));
                $('#sdes').material_select();
                $.each(data, function(k, v) {
                    $('#sdes').append($('<option value="' + v + '" >').text(v));
                    $('#sdes').material_select();
                });
                $('#edes').material_select();
            }
        });

    }
</script>

</html>
