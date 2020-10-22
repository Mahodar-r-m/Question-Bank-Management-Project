<?php
    require 'connection.php';

    // Creating / selecting database
    $db=$conn->queBank;

    // Create / select collection
    $collection1=$db->questions;

    // Create / select collection
    $collection2=$db->report;

    // Calculation for Pie - Chart - 2
    // Reference : https://canvasjs.com/php-charts/pie-chart-index-data-label-inside/
    $match = ['$match'=>["username"=>$username]];
    $group = ['$group'=>["_id"=>'$date',"Total Questions"=>['$sum'=>'$Total']]];
    $doc2 = $collection2->aggregate([$match,$group]);

    $dataPoints2 = [];
    foreach ($doc2 as $k2) {
        // echo $k2['_id'].$k2['Total Questions']."<br>";
        $arr2 = [ "label"=>$k2['_id'],"y"=>$k2['Total Questions'] ];
        array_push($dataPoints2,$arr2);
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
    .sidenav {
        height: 100%;
        width: 0;
        position: fixed;
        z-index: 1;
        top: 0;
        left: 0;
        background-color: #124674;
        overflow-x: hidden;
        transition: 0.5s;
        padding-top: 60px;
        }

        .sidenav a {
        padding: 8px 8px 8px 32px;
        text-decoration: none;
        font-size: 25px;
        color: #818181;
        display: block;
        transition: 0.3s;
        }

        .sidenav a:hover {
        color: #f1f1f1;
        text-decoration: none;
        }

        .sidenav .closebtn {
        position: absolute;
        top: 0;
        right: 25px;
        font-size: 36px;
        margin-left: 50px;
        }

        @media screen and (max-height: 450px) {
        .sidenav {padding-top: 15px;}
        .sidenav a {font-size: 18px;}
        }
        #side1{
            background: #1f76c2;
            padding-right: 10px;
            border-radius: 0 21px 21px 0;
        }
    </style>
    <script>
    function openNav() {
            document.getElementById("mySidenav").style.width = "250px";
            document.getElementById("side1").style.display= "none";
            // Reference : https://stackoverflow.com/questions/14356124/how-to-change-the-visibility-of-a-div-tag-using-javascript-in-the-same-page/14356204#:~:text=Using%20the%20display%20attribute%3A&text=if%20you%20want%20to%20change,then%20you%20can%20do%20with..&text=Call%20this%20function%20when%20you,conditions%20in%20your%20segment%2Fcase.
        }

        function closeNav() {
            document.getElementById("mySidenav").style.width = "0";
            document.getElementById("side1").style.display= "block";
        }
    </script>
    <script src='https://kit.fontawesome.com/a076d05399.js'></script>
</head>
<body>
    
<div id="mySidenav" class="sidenav">
    <a href="javascript:void(0)" class="closebtn" onclick="closeNav()">&times;</a>
    <a href="#verytop">Overall Report</a>
    <a href="#userTable">Detailed Report</a>
    <a <?php if (count($dataPoints2) == 0){ ?> href="#MY2" <?php }else{ ?> href="#chartContainer2" <?php } ?> class="">My Report</a>
    </div>

    <!-- Reference : https://www.w3schools.com/howto/tryit.asp?filename=tryhow_js_sidenav -->
    <span id="side1" style="font-size: 30px;cursor:pointer;position:fixed;top: 80px;left: 0;z-index:1;" onclick="openNav()"><span style="color:#1f76c2">i</span><i class='fas fa-chevron-right'></i></span>
    <!-- Reference : https://www.w3schools.com/icons/tryit.asp?icon=fas_fa-chevron-right&unicon=f054 -->
</body>
</html>