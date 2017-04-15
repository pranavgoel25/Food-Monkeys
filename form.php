<!-- Form for submitting a request  -->


<?php 
session_start(); /// initialize session 
#include("passwords.php"); 
#check_logged(); /// function checks if visitor is logged. 
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
                "sdate",
                "edate",
                "sdes",
                "edes",
                "reason"
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
            $.post("./php/formaction.php", data, function(dat, status) {
                $("#".concat(id.concat("Err"))).html(dat);
                errors[id.concat("Err")] = dat;
            });
        }

        function submission() {
            for (id = 0; id < ids.length; id++) {
                validate(ids[id]);
            }
            data["which"] = "correct";
            data['type'] = $("input[type='radio'][name='grp1']:checked").val();
            data['weight'] = $("input[type='radio'][name='grp2']:checked").val();
            data["id"] = "<?php echo $_SESSION['logged']; ?>";
            $.post("./php/formaction.php", data, function(data, status) {
                document.write(data);
                setTimeout(function() {
                    window.location.href = 'home.html'
                }, 5000);
            });
        }

        function gettravellers()
        {

                $('#travellers').empty();
                $.ajax({
                    type: 'POST',
                    url: './php/gettravellersinroute.php',
                    data: {
                        tname: $('#train').val(),
                        sdes: $('#sdes').val(),
                        edes: $('#edes').val()
                    },
                    dataType: 'json',
                    success: function(data) {

                        $('#travellers').empty();

                        if (data.length != 0)
                        {
                        $('#travellers').append($('<li class="collection-header"><h4>Already Going Travellers</h4>You can continue adding your request or contact any one of the travellers below</li>'));
                        }
                        else
                        {
                        $('#travellers').append($('<li class="collection-header"><h4>No Travellers in this route</h4>You can add your own request</li>'));
                        }

                        $.each(data, function(index, element) {

                            $('#travellers').append($('<li class="collection-item"><div>' + element.name + '<a onclick="sendmail('+ element.id +');" class="secondary-content"><i class="material-icons">send</i></a></div></li>'));

                        });

                    }
                });

        }

        function sendmail(num)
        {
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
            data["traid"] = num ;
            data["id"] = "<?php echo $_SESSION['logged']; ?>";
            $.post("./php/reqtotra.php", data, function(data, status) {
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
            <h3>Submit Request</h3></div><br><br>


        <div class="row">
            <div class="col s12">
                <ul class="tabs">
                    <li class="tab col s3"><a class="active blue-text" href="#test1">Fulfillment ranges</a></li>
                  <!--  <li class="tab col s3"><a class="blue-text" onclick="gettravellers();" href="#test2">Travellers</a></li>-->
                </ul>
            </div>

            <div id="test1" class="col s12">

                <div class="row">
                    <div class="input-field col s12">
                        <input type="text" id="train" name="train"/>
                        <label for="train">Partner No. *</label>
                        <span id="trainErr"></span>
                    </div>
                </div>

                <!--<div class="row">
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
-->
                <div class="row">
                    <div class="input-field col s12">
                        <i class="material-icons prefix">mode_edit</i>
                        <textarea id="reason" name="reason" onblur="validate('reason')" class="materialize-textarea"></textarea>
                        <label for="reason">Item Description *</label>
                        <span id="reasonErr"></span>
                    </div>
                </div>

                <div id="peri">

                    <label for="peri">Type:</label><br>

                    <input name="grp1" type="radio" id="r1" value="Perishable"checked>
                    <label for="r1">Perishable </label>

                    <input name="grp1" type="radio" id="r2" value="Non-Perishable">
                    <label for="r2">Non-Perishable </label>
                </div>
                <br>
                <div id="wht">
                    <label for="wht" >Weight</label><br>
                    <input name="grp2" type="radio" id="r3" value="0.5" checked>
                    <label for="r3">0.5</label>

                    <input name="grp2" type="radio" id="r4" value="1">
                    <label for="r4">1</label>
                    <input name="grp2" type="radio" id="r5" value="2">
                    <label for="r5">2</label>
                    <input name="grp2" type="radio" id="r6" value="3">
                    <label for="r6">3</label>
                    <input name="grp2" type="radio" id="r7" value="4">
                    <label for="r7">4</label>
                    <input name="grp2" type="radio" id="r8" value="5">
                    <label for="r8">5</label>
                </div>
  <!--              <a class="waves-effect waves-light btn-large right" id="next1">Next</a>-->
            </div>


            </div>

           <div id="test2" class="col s12">


      <ul class="collection with-header" id="travellers">
      </ul>

                <div class="right">
<!--                    <a class="waves-effect waves-light btn-large" id="pre2">Previous</a>-->

                    <button type="submit" onclick="submission();" class="waves-effect waves-light btn-large green">Submit</button>
                </div>

            </div>

        </div>

    </div>
    <br>

    <br><br>
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
</script>

<script>
    $(function() {
        $('#navbar').load('nav.php');
    });

    $('.datepicker').pickadate({
        selectMonths: true, // Creates a dropdown to control month
        selectYears: 15, // Creates a dropdown of 15 years to control year
        format: 'dd-mm-yyyy'
    });

    $(document).ready(function() {
        $('ul.tabs').tabs();
    });


    $("#next1").click(function() {
        gettravellers();
        $('ul.tabs').tabs('select_tab', 'test2');
    });


    $("#pre2").click(function() {
        gettravellers();
        $('ul.tabs').tabs('select_tab', 'test1');
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
        $('#edes').empty();
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
                $('#edes').append($('<option value="NULL" >').text("Select"));
                $('#edes').material_select();
                $.each(data, function(k, v)
                {
                    $('#sdes').append($('<option value="' + v + '" >').text(v));
                    $('#sdes').material_select();
                });
                $('#edes').material_select();
            }
        });

    }
        $(function() {
        $('#footer').load('foot.html');
    });
</script>

</html>
