<!-- ################################# -->
<!-- FAILED ATTEMPT KEPT FOR REFERENCE -->
<!-- ################################# -->
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
    </style>
    <!-- CSS only -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">

    <!-- JS, Popper.js, and jQuery -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js" integrity="sha384-B4gt1jrGC7Jh4AgTPSdUtOBvfO8shuf57BaghqFfPlYxofvL8/KUEfYiJOMMV+rV" crossorigin="anonymous"></script>
    
</head>
<body>
    <?php 
        session_start();
        $username = $_SESSION['username']; // Take value from previous file
        $_SESSION['username'] = $username; // Pass value to next file
        include 'header.php';

        require 'connection.php';

        // Creating / selecting database
        $db=$conn->queBank;

        // Create / select collection
        $collection1=$db->questions;

        // Create / select collection
        $collection2=$db->report;

        
        $filter = [];
        $sort = ['sort' => ["_id"=>-1]];
        // $dates = $collection->distinct('date');
        $dates = $collection->distinct('date');

        $d = [];
        $dAll = [];
        foreach ($dates as $date) {
            array_push($dAll,$date);
            // Filter for Date
            if (isset($_POST['date'])) {
                // echo "<div>POST</div>";
                $dateInput = $_POST['date'];
                // echo "<div>Input - ".$dateInput."</div>";
                if ($dateInput == "all") {
                    array_push($d,$date);
                }elseif ($dateInput == $date) {
                    array_push($d,$dateInput);
                }
            }else{
                array_push($d,$date);
            }

            
            // echo $a."<br>";
        }
        rsort($dAll);
        rsort($d); // Reference : https://www.php.net/manual/en/function.sort.php
        ?>
        <!-- Sort Modal -->
        <!-- Button trigger modal -->
        <div class="mt-3 ml-5">
            <button type="button" class="btn font-weight-bold" data-toggle="modal" data-target="#sortModal">
            Filter & Sort By
            </button>
        </div>
        <!-- Modal -->
        <div class="modal fade" id="sortModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content" style="background:#bbd5ec;">
            <div class="modal-header" style="background:#1f76c2;">
                <h5 class="modal-title font-weight-bold" id="exampleModalLabel" style="color:white;">Filter & Sort Reports</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="reportQue.php" method="post" id="sorting">
                <div class="modal-body">
                    <div class="font-weight-bold">Filter By :</div>
                    <!-- Dropdown for Date filter -->
                    <div class="dropdown ml-4 mb-1">
                        <label class="mt-1 font-weight-bold" for="date">Date : </label>
                        <select class="btn btnd dropdown-toggle" name="date" id="date">
                            <option value="all">All (Type)</option>
                            <?php 
                                foreach ($dAll as $t) {
                                    ?>
                                    <option value="<?php echo $t; ?>"><?php echo $t; ?></option>
                                    <?php
                                }
                            ?>
                            
                        </select>
                    </div>
                    <?php 
                        // Getting Username
                        $users = $collection->distinct('username');
                        $uAll = $users;
                    ?>
                    <!-- Dropdown for User filter -->
                    <div class="dropdown ml-4 mb-1">
                        <label class="mt-1 font-weight-bold" for="user">User : </label>
                        <select class="btn btnd dropdown-toggle" name="user" id="user">
                            <option value="all">All (Users)</option>
                            <?php 
                                foreach ($uAll as $u) {
                                    ?>
                                    <option value="<?php echo $u; ?>"><?php echo $u; ?></option>
                                    <?php
                                }
                            ?>
                            
                        </select>
                    </div>
                </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-primary" form="sorting">Sort</button></form>
                <button type="submit" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
            </div>
        </div>
        </div>
        <?php
        foreach ($d as $a) {
            ?>
            <div class="card ml-5 mt-3 p-3 w-75">
                <!-- Display Date -->
                <div class="p-1"><?php echo $a; ?></div>

            <?php
            
            $filterDate = $a;
            // echo "<div>".$filterDate."</div>";
            $match = ['$match'=>["date"=>$filterDate]];
            if (isset($_POST['user'])) {
                $userSort = $_POST['user'];
                if ($userSort != 'all') {
                    $match = ['$match'=>["date"=>$filterDate,"username"=>$userSort]];
                }
            }

            // $match = ['$match'=>["date"=>$filterDate]];
            $group = ['$group'=>["_id"=>'$username',"Total Questions"=>['$sum'=>1]]];
            // $sort = ['sort' => ["marks"=>$marks]];
            $doc1 = $collection->aggregate([$match,$group]);
            
            foreach ($doc1 as $d1) {
                ?>
                <div class="d-flex">
                
                <!-- Display Username -->
                <div class="pl-2"><?php echo $d1['_id']; ?></div>
                
                <?php
                $user = $d1['_id'];

                $match = ['$match'=>["date"=>$a,"username"=>$user]];
                $group = ['$group'=>["_id"=>'$que_type',"Questions Total"=>['$sum'=>1]]];
                $doc2 = $collection->aggregate([$match,$group]);

                ?><div class="d-flex"><?php
                foreach ($doc2 as $d2) {
                    ?>
                    <div class="d-flex">
                        <!-- Display Question Type & Respective Total -->
                        <div class="mr-3 pl-4"><?php echo $d2['_id']; ?></div>
                        <div><?php echo $d2['Questions Total']; ?></div>
                    </div>
                    <?php
                }
                ?>
                </div>
                <!-- Display Final Total -->
                <div class="pl-4 justify-content-right">Total Questions : &nbsp;<?php echo $d1['Total Questions']; ?></div>

            </div>
            <?php
                
            }
            ?>
            
            </div>
            <?php
        }
        // $today = getdate();
        // $date = $today['mday']."-".$today['mon']."-".$today['year'];
        // echo $date;
    ?>
</body>
</html>