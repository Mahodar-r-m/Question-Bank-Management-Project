<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home</title>

    <style>
       .container{
           box-shadow: 20px;
       }
       .register{
            background: #3498DB;
            border-radius: 9px 9px 0 0;
       }
       .login{
            background: #3498DB;
            border-radius: 9px 9px 0 0;
       }
       .textWhite{
            font-size: 20px;    
            color: white;
       }
       .textWhite:hover{
            color:white;
            text-decoration:none;
       }
       .textBlack{
            font-size: 20px;
            color: black;
       }
       .textBlack:hover{
           color:black;
           text-decoration:none;
       }
       .toggle{
            padding:20px; 
            width:250px;
       }
    </style>

    <!-- CSS only -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">

    <!-- JS, Popper.js, and jQuery -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js" integrity="sha384-B4gt1jrGC7Jh4AgTPSdUtOBvfO8shuf57BaghqFfPlYxofvL8/KUEfYiJOMMV+rV" crossorigin="anonymous"></script>

    <script src="script.js"></script>
</head>
<body>
    <?php 
        require 'connection.php';

        // Creating / selecting database
        $db=$conn->queBank;
    
        // Create / select collection
        $collection=$db->user;
    ?>
    <!-- color used in logo : 1f76c2 / rgb(31,118,194) -->
    <div class="d-flex pb-5" style="background:#bbd5ec; height:657px;">
        <div class="mt-5 pt-5 pl-5 mr-5" style="height:413px;">
            <img src="QBMLogo.png" alt="Logo">
        </div>
        <div class="ml-5" style="width:482px;">
            <div class="d-flex mt-5">
                <div id="log" class="login toggle"><a id="textl" class="textWhite" onclick="login()" href="#login">Login</a></div>
                <div id="reg" class="toggle"><a id="textr" class="textBlack" onclick="register()" href="#register">Register</a></div>
            </div>
            <div class="d-flex shadow-lg container rounded" align="center" style="overflow:hidden; height:413px; background-image: url('https://assets.entrepreneur.com/content/3x2/2000/20191126130426-FotoJet.jpeg');">

                <!-- Login -->
                <div id="login">
                    <div class="ml-5 mr-5">
                        <div style="height:65px;"></div>
                        <table style="width:75%; font-size:20px; color:white;" class="table">
                            <form action="login.php" method="post" id="form1">
                            <!-- Reference : https://www.w3schools.com/tags/att_button_form.asp -->
                                <tr>
                                    <td style="font-size:25px; font-family:'Comic Sans MS', cursive, sans-serif;" align="center" colspan="2" class="font-weight-bold">Management Login</td>
                                </tr>
                                <tr>
                                    <td class="pt-3 font-weight-bold" style="color:#99AAAB;">Username</td>
                                    <td><input name="username" class="p-1" type="text" placeholder="Eg. UserA"></td>
                                </tr>
                                <tr>
                                    <td class="pt-3 font-weight-bold" style="color:#99AAAB;">Password</td>
                                    <td><input name="password" class="p-1" type="password" placeholder="Password"></td>
                                </tr>
                                <tr>
                                    <td align="center" colspan="2"><button style="font-size:19px;" class="btn btn-outline-info w-100 p-3 mt-2" value="submit" type="submit" form="form1">Login</button></td>
                                </tr>
                            </form>
                        </table>
                    </div>
                </div>

                <!-- Register -->
                <div id="register">
                    <div class="ml-5 mr-5">
                        <div style="height:65px;"></div>
                        <table style="width:75%; font-size:20px; color:white;" class="table">
                            <form action="register.php" method="post" id="form2">
                                <tr>
                                    <td style="font-size:25px; font-family:'Comic Sans MS', cursive, sans-serif;" align="center" colspan="2" class="font-weight-bold">Management Register</td>
                                </tr>
                                <tr>
                                    <td class="pt-3 font-weight-bold" style="color:#99AAAB;">Username</td>
                                    <td><input name="username" class="p-1" type="text" placeholder="Eg. UserA"></td>
                                </tr>
                                <tr>
                                    <td class="pt-3 font-weight-bold" style="color:#99AAAB;">Password</td>
                                    <td><input name="password" class="p-1" type="password" placeholder="Password"></td>
                                </tr>
                                <tr>
                                    <td align="center" colspan="2"><button style="font-size:19px;" class="btn btn-outline-info w-100 p-3 mt-2" value="submit" type="submit" form="form2">Register</button></td>
                                </tr>
                            </form>
                        </table>
                    </div>
                </div>

            </div>
            <!-- Alert -->
       <?php
       if (isset($_GET['error'])) {
            $error = $_GET['error'];
            ?>
            <!-- Reference : https://www.w3schools.com/bootstrap/tryit.asp?filename=trybs_ref_js_alert&stacked=h -->
            <div class="mt-2 shadow alert alert-danger alert-dismissible">
                <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                <?php echo $error; ?>
            </div>
            <?php
       }
        ?>
        </div>

       
    </div>


</body>
</html>