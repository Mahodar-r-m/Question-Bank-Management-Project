<?php
    session_start();
    $username = $_SESSION['username']; // Take value from previous file
    $_SESSION['username'] = $username; // Pass value to next file
    ?> <div id="verytop"> </div> <?php

    include 'header.php';
    include 'subnav.php';
    include 'reportCalculate.php';

    require 'connection.php';

    // Creating / selecting database
    $db=$conn->queBank;

    // Create / select collection
    $collection1=$db->questions;

    // Create / select collection
    $collection2=$db->report;

    // Calculation for Pie - Chart
    // Reference : https://canvasjs.com/php-charts/pie-chart-index-data-label-inside/
    // $match = ['$match'=>["username"=>'User C']];
    $group = ['$group'=>["_id"=>'$username',"Total Questions"=>['$sum'=>'$Total']]];
    $doc1 = $collection2->aggregate([$group]);

    $dataPoints = [];
    foreach ($doc1 as $k1) {
        $arr = [ "label"=>$k1['_id'],"y"=>$k1['Total Questions'] ];
        array_push($dataPoints,$arr);
    }

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
    
    // $dataPoints = array( 
    //     array("label"=>"Chrome", "y"=>64.02),
    //     array("label"=>"Firefox", "y"=>12.55),
    //     array("label"=>"IE", "y"=>8.47),
    //     array("label"=>"Safari", "y"=>6.08),
    //     array("label"=>"Edge", "y"=>4.29),
    //     array("label"=>"Others", "y"=>4.59)
    // )
 
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Report</title>
    <style>
        .card{
            width: 97%;
            margin: 0 auto;
            padding: 10px 10px 2px 10px;
        }
        .card:hover{
            box-shadow: 0 0 30px #78acda !important; /* Reference : https://css-tricks.com/forums/topic/how-to-add-shadows-on-all-4-sides-of-a-block-with-css/ */
        }
        #myBtn {
            display: none;
            position: fixed;
            bottom: 20px;
            right: 30px;
            z-index: 99;
            font-size: 18px;
            border: none;
            outline: none;
            background-color: #0275d8;
            color: white;
            cursor: pointer;
            padding: 7px;
            border-radius: 50%;
        }
    </style>

    <!-- Script only for PIE - CHART -->
    <script>
        window.onload = function() {
        
        var chart = new CanvasJS.Chart("chartContainer", {
            theme: "light2",
            animationEnabled: true,
            title: {
                text: "Overall Question Bank Report"
            },
            subtitles: [{
                text: "Total Questions Contributed"
            }],
            data: [{
                type: "pie",
                indexLabel: "{y}",
                yValueFormatString: "#,##",
                indexLabelPlacement: "inside",
                indexLabelFontColor: "#36454F",
                indexLabelFontSize: 18,
                indexLabelFontWeight: "bolder",
                showInLegend: true,
                legendText: "{label}",
                dataPoints: <?php echo json_encode($dataPoints, JSON_NUMERIC_CHECK); ?>
            }]
        });
        chart.render();
        
        
        var chart = new CanvasJS.Chart("chartContainer2", {
            theme: "light1",
            animationEnabled: true,
            title: {
                text: "My Report"
            },
            subtitles: [{
                text: "Questions Contributed Day Wise"
            }],
            data: [{
                type: "pie",
                indexLabel: "{y}",
                yValueFormatString: "#,##",
                indexLabelPlacement: "inside",
                indexLabelFontColor: "#36454F",
                indexLabelFontSize: 18,
                indexLabelFontWeight: "bolder",
                showInLegend: true,
                legendText: "{label}",
                dataPoints: <?php echo json_encode($dataPoints2, JSON_NUMERIC_CHECK); ?>
            }]
        });
        chart.render();
        
        }
    </script>

    <!-- For Data Table -->
    <link rel="stylesheet" type="text/css" href="//cdn.datatables.net/1.10.21/css/jquery.dataTables.min.css"/>

    <!-- CSS only -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">

    <!-- JS, Popper.js, and jQuery -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js" integrity="sha384-B4gt1jrGC7Jh4AgTPSdUtOBvfO8shuf57BaghqFfPlYxofvL8/KUEfYiJOMMV+rV" crossorigin="anonymous"></script>
    
    <!-- ###############   JUST FOR PRACTICE   ################### -->
    <!-- Reference : https://artisansweb.net/how-to-use-datatable-in-php/ -->
    <!-- <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script type="text/javascript" src="//cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js"></script> -->
    <script>
    // $(document).ready(function() {
    //     $('#userTable').DataTable( {
    //     "lengthMenu": [[2, 4, 10, -1], [2, 4, 10, "All"]]
    //     // Reference : https://datatables.net/examples/advanced_init/length_menu.html
    // });
    // });
    </script>
    <!-- Reference : https://stackoverflow.com/questions/44722666/datatables-bootstrap-not-working -->

</head>
<body>

    <!-- Below 2 lines for PIE - CHART -->
    <div id="chartContainer" style="height: 480px; width: 100%; padding-top: 20px;margin-top:30px;z-index:0;"></div>
    <script src="https://canvasjs.com/assets/script/canvasjs.min.js"></script>
    <div>
        <!-- Report  Detailed Report | Create navbar and sort & filtering | create detailed report pie chart for each and option to download it. -->
    </div>

    <!-- Sort and Filter Modal -->
    <!-- Button trigger modal -->
    <!-- <div class="ml-5" style="margin-top:75px;" id="section2">
        <button style="background:#1f76c2;font-size:25px;" type="button" class="btn font-weight-bold" data-toggle="modal" data-target="#sortModal">
        Sort & Filter By
        </button>
    </div> -->
    
    <?php
        $filter = []; // Default
        $sort = []; // Default

        if (isset($_POST['type']) and isset($_POST['category'])){
            $type = $_POST['type'];
            $category = $_POST['category'];
            $category = (int)$category;
            // echo $type.$category;
            if ($type!="all") {
                $sort = ['sort' => [$type=>$category]];
            }else {
                $sort = ['sort' => ['Total'=>$category]];
            }
        }
        if (isset($_POST['total'])){
            $total = $_POST['total'];
            $total = (int)$total;
            // echo $total;
            $sort = ['sort' => ['Total'=>$total]];
        }
        if (isset($_POST['user']) and isset($_POST['date'])) {
            $user = $_POST['user'];
            $date = $_POST['date'];
            if ($user!="all" and $date!="all") {
                $filter = ['date'=>$date,'username'=>$user];
            }elseif ($user!="all") {
                $filter = ['username'=>$user];
            }elseif ($date!="all") {
                $filter = ['date'=>$date];
            }else {
                $filter = [];
            }
        }
        // Trial and Error
        // elseif (isset($_POST['date'])){
        //     $date = $_POST['date'];
        //     // echo $date;
        //     if ($date!="all") {
        //         $filter = ['date'=>$date];
        //     }else {
        //         $filter = [];
        //     }
        // }elseif (isset($_POST['user'])){
        //     $user = $_POST['user'];
        //     // echo $user;
        //     if ($user!="all") {
        //         // echo $user;
        //         $filter = ['username'=>$user]; 
        //     }else {
        //         $filter = [];
        //     }
        // }

        $check2 = $collection2->find($filter,$sort);

    ?>

    <!-- Modal -->
    <div class="modal fade" id="sortModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content" style="background:#bbd5ec;">
        <div class="modal-header" style="background:#1f76c2;">
            <h5 class="modal-title font-weight-bold ml-3" id="exampleModalLabel" style="font-family: monospace;color:white;font-size:20px;">SORT & FILTER</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <form action="reportQue.php#userTable" method="post" id="sorting">
            <div class="modal-body">
                <div align="center" class="font-weight-bold bg-dark text-light mb-2 mt-1" style="border-radius:25px;font-size:16px;">
                    <label class="mt-2">SORT BY :</label>
                </div>
                <div class="d-flex">
                    <div>
                        <div class="dropdown ml-4 mb-2">
                            <label class="font-weight-bold" for="type">Question Type :</label><br>
                            <select class="btn btnd dropdown-toggle" name="type" id="type">
                                <option value="all">All (Types)</option>
                                <option value="Quantitative">Quantitative</option>
                                <option value="General Knowledge">General Knowledge</option>
                                <option value="Logical">Logical</option>
                                <option value="Verbal">Verbal</option>                               
                            </select>
                        </div>

                        <!-- <input <?php //if (isset($_POST['category'])){if($category==1){ echo 'checked'; }} ?> class="ml-5" type="radio" id="ascending" name="category" value="1">&nbsp; -->
                        <input class="ml-5" type="radio" id="ascending" name="category" value="1">&nbsp;
                        <label for="ascending">Ascending</label><br>
                        <!-- <input <?php //if (isset($_POST['category'])){if($category==-1){ echo 'checked'; }} ?> class="ml-5" type="radio" id="descending" name="category" value="-1">&nbsp; -->
                        <input class="ml-5" type="radio" id="descending" name="category" value="-1">&nbsp;
                        <label for="descending">Descending</label>
                    </div>
                    <div class="ml-5">
                        <label class="font-weight-bold">Total Questions :</label><br>
                        <!-- <input <?php //if (isset($_POST['total'])){if($total==1){ echo 'checked'; }} ?> class="ml-3" type="radio" id="ascending" name="total" value="1">&nbsp; -->
                        <input class="ml-3" type="radio" id="ascending" name="total" value="1">&nbsp;
                        <label for="ascending">Ascending</label><br>
                        <!-- <input <?php //if (isset($_POST['total'])){if($total==-1){ echo 'checked'; }} ?> class="ml-3" type="radio" id="descending" name="total" value="-1">&nbsp; -->
                        <input class="ml-3" type="radio" id="descending" name="total" value="-1">&nbsp;
                        <label for="descending">Descending</label>
                    </div>
                </div>

                <div align="center" class="font-weight-bold bg-dark text-light mb-2 mt-3" style="border-radius:25px;font-size:16px;">
                    <label class="mt-2">FILTER BY :</label>
                </div>
                <div class="d-flex">
                    <div class="mr-2 ml-2">
                        <?php $users = $collection2->distinct('username'); ?>
                        <div class="dropdown ml-4 mb-3">
                            <label class="mt-1 font-weight-bold" for="user">User : </label>
                            <select class="btn btnd dropdown-toggle" name="user" id="user">
                                <option value="all">All (Users)</option>
                                <?php 
                                    foreach ($users as $us) {
                                        ?>
                                        <option <?php if (isset($_POST['user'])){if($user==$us){ echo 'selected'; }} ?> value="<?php echo $us; ?>"><?php echo $us; ?></option>
                                        <?php
                                    }
                                ?>
                                
                            </select>
                        </div>
                    </div>
                    <div class="ml-2">
                        <?php $dates = $collection2->distinct('date'); ?>
                        <div class="dropdown ml-4 mb-3">
                            <label class="mt-1 font-weight-bold" for="date">Date : </label>
                            <select class="btn btnd dropdown-toggle" name="date" id="date">
                                <option value="all">All (Dates)</option>
                                <?php 
                                    foreach ($dates as $d) {
                                        ?>
                                        <option <?php if (isset($_POST['date'])){if($date==$d){ echo 'selected'; }} ?> value="<?php echo $d; ?>"><?php echo $d; ?></option>
                                        <?php
                                    }
                                ?>
                                
                            </select>
                        </div>
                    </div>
                </div>
            </div>
        <div class="modal-footer">
            <button type="submit" class="btn text-light" style="background:#1f76c2;" form="sorting">Sort</button></form>
            <button type="submit" class="btn btn-secondary" data-dismiss="modal">Close</button>
        </div>
        </div>
    </div>
    </div>
    
    <table id="userTable" class="table" align="center" style="width:94%;margin-top:95px;">
    <thead>
        <tr style="background:#1f76c2;font-size:25px;">
            <td class="align-middle" colspan="2">Report</td>
            <td class="align-middle" colspan="4">Count of Questions Added</td>
            <td>
                <button style="background:#1f76c2;font-size:22px;" type="button" class="btn" data-toggle="modal" data-target="#sortModal">
                Sort & Filter By
                </button>
            </td>
        </tr>
        <tr style="font-size: 17px;" class="font-weight-bold bg-dark text-light">
            <td>Date</td>
            <td>Username</td>
            <td align="center">Quantitative</td>
            <td align="center">General Knowledge</td>
            <td align="center">Logical</td>
            <td align="center">Verbal</td>
            <td align="center">Total</td>
        </tr>
    </thead>
    <tbody>

    <?php
        foreach ($check2 as $key2) {
            ?>
            <!-- <tbody> -->
                <tr>
                    <td><?php echo $key2['date']; ?></td>
                    <td><?php echo $key2['username']; ?></td>
                    <td align="center"><?php echo $key2['Quantitative']; ?></td>
                    <td align="center"><?php echo $key2['General Knowledge']; ?></td>
                    <td align="center"><?php echo $key2['Logical']; ?></td>
                    <td align="center"><?php echo $key2['Verbal']; ?></td>
                    <td align="center"><?php echo $key2['Total']; ?></td>
                </tr>
            <!-- </tbody> -->
        <?php
        }
    ?>
        </tbody>
        </table>

        <div>
            <a href="#top" id="myBtn"><i class="fa fa-chevron-circle-up" style="font-size:34px;"></i></a>
        </div>

        <?php 
            if (count($dataPoints2) == 0){
                ?>
                <div id="MY2" align="center" class="jumbotron text-dark font-weight-bold" height="1000" style="margin-top:100px;">
                    <h2 class="justify-content-center">Contribute Questions to get your report</h2> 
                </div>
                <?php
            }else {
                ?>
                <!-- Below 2 lines for PIE - CHART 2 -->
                <div id="chartContainer2" style="height: 480px; width: 100%; padding-top: 20px;margin-top:50px;z-index:0;"></div>
                <script src="https://canvasjs.com/assets/script/canvasjs.min.js"></script>
                <?php
            }
        ?>
        <div style="width:100%;">
        <?php
            include 'footer.php';
        ?>
    </div>

    <script>
    // Reference : https://www.w3schools.com/howto/tryit.asp?filename=tryhow_js_scroll_to_top
    //Get the button
    var mybutton = document.getElementById("myBtn");

    // When the user scrolls down 20px from the top of the document, show the button
    window.onscroll = function() {scrollFunction()};

    function scrollFunction() {
    if (document.body.scrollTop > 10 || document.documentElement.scrollTop > 10) {
        mybutton.style.display = "block";
    } else {
        mybutton.style.display = "none";
    }
    }
    </script>
</body>
</html>