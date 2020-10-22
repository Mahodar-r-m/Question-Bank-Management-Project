<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home</title>

    <style>
        #addQueForm input,textarea,select,button{
            padding: 5px;
        }
        #addQueForm label{
            padding-top: 5px;
        }
        .btn-info{ /* Reference : https://stackoverflow.com/questions/28261287/how-to-change-btn-color-in-bootstrap */
            background: #1f76c2 !important;
            border: #1f76c2 !important;
            margin: 20px;
        }
        .btn-info:hover{
            box-shadow: 5px 5px 3px silver !important; /* Reference : https://www.w3schools.com/css/css3_shadows_box.asp */
        }
        .card{
            width: 97%;
            margin: 0 auto;
            padding: 10px 10px 2px 10px;
        }
        .card:hover{
            box-shadow: 0 0 30px #78acda !important; /* Reference : https://css-tricks.com/forums/topic/how-to-add-shadows-on-all-4-sides-of-a-block-with-css/ */
        }
        .comment {
            /* // layout */
            position: relative;
            max-width: 20em;
            
            /* // looks */
            background-color: #bbd5ec;
            padding: 1.125em 1.5em;
            font-size: 1.25em;
            border-radius: 1rem;
            box-shadow:	0 0.125rem 0.5rem rgba(0, 0, 0, .3), 0 0.0625rem 0.125rem rgba(0, 0, 0, .2);
        }
        /* Reference : https://codepen.io/rikschennink/pen/mjywQb */
        .comment::before {
            /* // layout */
            content: '';
            position: absolute;
            width: 0;
            height: 0;
            bottom: 100%;
            left: 1.5em; /* offset should move with padding of parent */
            border: .75rem solid transparent;
            border-top: none;

            /* // looks */
            border-bottom-color: #bbd5ec;
            filter: drop-shadow(0 -0.0625rem 0.0625rem rgba(0, 0, 0, .1));
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
    <!-- For info icon -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <!-- CSS only -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">

    <!-- JS, Popper.js, and jQuery -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js" integrity="sha384-B4gt1jrGC7Jh4AgTPSdUtOBvfO8shuf57BaghqFfPlYxofvL8/KUEfYiJOMMV+rV" crossorigin="anonymous"></script>
    
    <!-- For comment icon  -->
    <script src='https://kit.fontawesome.com/a076d05399.js'></script>
    <!-- For check - correct answer -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

    <!-- This below single line means a lot
    Reference : https://stackoverflow.com/questions/18271251/typeerror-ajax-is-not-a-function -->
    <script src="jquery-3.5.1.js"></script>

    <script src="script.js"></script>
</head>
<body>
    <?php
        // if (true) {
        if (isset($_GET['user']) or isset($_GET['sort']) or ($_SERVER['REQUEST_METHOD'] == "POST")) {
            // logged In

            // Reference : https://stackoverflow.com/questions/871858/php-pass-variable-to-next-page
            session_start();
            $username = $_SESSION['username']; // Take value from previous file
            $_SESSION['username'] = $username; // Pass value to next file
            // $var_value = $_SESSION['varname']; // Syntax
            
            include 'header.php';


            require 'connection.php';

            // Creating / selecting database
            $db=$conn->queBank;

            // Create / select collection
            $collection=$db->questions;

            $sort = ['sort' => ["_id"=>-1]];
            $filter= [];

            if (isset($_POST['que_type_sort'])){
                $x = $_POST['que_type_sort'];
                if ($x!='all'){
                    $filter = ['que_type'=>$x];
                }
            }

            // NOTE : MongoDB doesn't support sorting on lexicographical order 
            // (lexical order, dictionary order, alpahbetical order, or human readable order). 
            // The rule of mongodb sorting is numeric first, then upper case letters then lower case letters last.
            // May 14, 2015
            if (isset($_POST['alphabet']) and isset($_POST['marks'])) {
                $alphabet = $_POST['alphabet'];
                $marks = $_POST['marks'];
                if ($alphabet=="1") {
                    $alphabet = 1;
                } else {
                    $alphabet = -1;
                }
                if ($marks=="1") {
                    $marks = 1;
                } else {
                    $marks = -1;
                }
                
                $sort = ['sort' => ["title"=>$alphabet,"marks"=>$marks]];
            }elseif (isset($_POST['alphabet'])) {
                $alphabet = $_POST['alphabet'];
                // echo "both";
                if ($alphabet=="1") {
                    $alphabet = 1;
                } else {
                    $alphabet = -1;
                    // echo "negative";
                }
                $sort = ['sort' => ["title"=>$alphabet]];
            }elseif (isset($_POST['marks'])) {
                $marks = $_POST['marks'];
                // echo "working";
                if ($marks=="1") {
                    $marks = 1;
                } else {
                    $marks = -1;
                }
                $sort = ['sort' => ["marks"=>$marks]];
            }
            

            $check = $collection->find($filter,$sort);

            $count = $collection->count($filter,$sort);

            // To display count
            include 'reportCalculate.php';
            // Create / select collection
            $collection2=$db->report;
            $group = ['$group'=>["_id"=>'$username',"Total Questions"=>['$sum'=>'$Total']]];
            $doc1 = $collection2->aggregate([$group]);
            $totalCount = 0;
            $youFinalCount = 0;
            foreach ($doc1 as $k1) {
                $you = $k1['_id'];
                $youCount = $k1['Total Questions'];
                if ($you == $username) {
                    $youFinalCount = $youCount;
                }
                $totalCount += $youCount;
                // $arr = [ "label"=>$k1['_id'],"y"=>$k1['Total Questions'] ];
            }
            // echo $totalCount;
            ?> 
            <div>
                <a href="questions.php?user=x&f=yes"><button class="shadow btn btn-info">Add New Question</button></a>
                <div class="d-flex" style="position: absolute;
                            top: 6em;
                            left: 30em;">
                            <div class="mr-5">
                                <span class="MyQues mr-3 font-weight-bold" style="font-size:33px;"><?php echo $youFinalCount; ?></span>
                                <span class="MyText" style="font-size: 29px;"></span>
                            </div>
                            <div class="ml-5">
                                <span class="TotalQues mr-3 font-weight-bold" style="font-size:33px;"><?php echo $totalCount; ?></span>
                                <span class="TotalText" style="font-size: 29px;"></span>
                            </div>
                </div>
                <?php 
                    if (isset($_GET['f'])) { // Reference : http://www.wickham43.net/showform.php
                        ?>
                        <a href="questions.php?user=x"><i style="font-size: 27px;" class="fa fa-close"></i></a>
                        
                        <?php
                        include 'addQue.php';    
                    }
                    
                    ?>
            </div>
            

            <?php
            if ($count>0) { 
                ?>

                <!-- Sort Modal -->
                <!-- Button trigger modal -->
                <div class="ml-3 mb-3">
                    <button type="button" class="btn font-weight-bold" data-toggle="modal" data-target="#sortModal">
                    Sort & Filter By
                    </button>
                    <?php
                        if ($_SERVER['REQUEST_METHOD'] == "POST") {
                            echo '<div class="btn ml-3"><a href="questions.php?user=x">Reset</a></div>';
                        }
                    ?>
                </div>
                <!-- Modal -->
                <div class="modal fade" id="sortModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content" style="background:#bbd5ec;">
                    <div class="modal-header" style="background:#1f76c2;">
                        <h5 class="modal-title font-weight-bold" id="exampleModalLabel" style="color:white;">Sort Questions By</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form action="questions.php" method="post" id="sorting">
                        <div class="modal-body">
                            <div align="center" class="font-weight-bold bg-dark text-light mb-2 mt-1" style="border-radius:25px;font-size:16px;">
                                <label class="mt-2">SORT BY :</label>
                            </div>
                            <div class="d-flex">
                                <div class="ml-4 mr-5">
                                    <label class="font-weight-bold">Title :</label><br>
                                    <input class="ml-4" type="radio" id="ascending" name="alphabet" value="1">&nbsp;
                                    <label for="ascending">A - Z</label><br>
                                    <input class="ml-4" type="radio" id="descending" name="alphabet" value="-1">&nbsp;
                                    <label for="descending">Z - A</label>
                                </div>
                                <div class="ml-5">
                                    <label class="font-weight-bold">Marks :</label><br>
                                    <input class="ml-4" type="radio" id="ascending" name="marks" value="1">&nbsp;
                                    <label for="ascending">Ascending</label><br>
                                    <input class="ml-4" type="radio" id="descending" name="marks" value="-1">&nbsp;
                                    <label for="descending">Descending</label>
                                </div>
                            </div>

                            <div align="center" class="font-weight-bold bg-dark text-light mb-2 mt-3" style="border-radius:25px;font-size:16px;">
                                <label class="mt-2">FILTER BY :</label>
                            </div>
                            <div>
                                <?php
                                // Filter Question Type
                                $type = $collection->distinct('que_type');
                                ?>
                                <div class="dropdown ml-4 mb-3">
                                    <label class="mt-1 font-weight-bold" for="que_type_sort">Filter By : </label>
                                    <select class="btn btnd dropdown-toggle" name="que_type_sort" id="que_type_sort">
                                    <!-- Working line below -->
                                    <!-- <select onchange='demo()' class="btn btnd dropdown-toggle" name="que_type_sort" id="que_type_sort"> -->
                                        <option value="all">All (Type)</option>
                                        <?php 
                                            foreach ($type as $t) {
                                                ?>
                                                <option value="<?php echo $t; ?>"><?php echo $t; ?></option>
                                                <?php
                                            }
                                        ?>
                                        
                                    </select>
                                </div>
                            </div>
                        </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary" form="sorting">Sort</button></form>
                        <button type="submit" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    </div>
                    </div>
                </div>
                </div>

                <!-- Main Div -->
                <!-- <div class="row"> -->
                <?php
                // Show Questions
                foreach ($check as $c) {
                    ?>

                <div style="float:left; width:319px; height:170px;" class="ml-3 p-3 col col-lg-3 card mb-3 shadow">
                    <a href="" style="text-decoration:none;color:#1f76c2;" data-toggle="modal" data-target="#modalDetails<?php echo $c['_id']; ?>">
                        <strong><?php echo $c['title']; ?></strong>
                        <i class="fa fa-info-circle"></i>
                    </a>
                    <div style="height:110px;overflow:hidden;">
                        <?php echo $c['body']; ?><br>
                    </div>
                    <div class="pt-3">Added : by <?php echo $c['username']; ?> on <?php echo $c['date']; ?></div> 
                </div>

                <!-- Detailed information modal -->
                <div class="modal fade" id="modalDetails<?php echo $c['_id']; ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-lg" role="document">
                    <div class="modal-content" style="background:#bbd5ec;">
                    <div class="modal-header text-center" style="background:#1f76c2;">
                        <h4 class="modal-title w-100 font-weight-bold text-white">QUESTION DETAILS</h4>
                        <?php if($c['username']==$username){ ?>
                        <button style="font-size:17px;" class="btn btn-danger mr-3 w-25" data-toggle="modal" data-target="#myDeleteModal<?php echo $c['_id']; ?>"><b>DELETE</b></button>
                        <?php } ?>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                        
                    </div>
                    <form action="updateQue.php" method="post">
                    <div class="modal-body mx-3">
                        <div class="md-form mb-3 d-flex">
                            <!-- <label class="text-danger" data-error="wrong" data-success="right" for="defaultForm-req">Required*</label> -->
                            <div class="mt-2 mr-2 font-weight-bold"><i class="fa fa-bars"></i>&nbsp;Question Type :</div>
                            <select required id="que_type" name="que_type" class="form-control validate w-25">
                                <option value="" disabled selected hidden>Question Type</option>
                                <!-- Value="" is important to add in disabled option without which required function doesn't work -->
                                <!-- Reference : https://www.w3docs.com/snippets/css/how-to-create-a-placeholder-for-an-html5-select-box-by-using-only-html-and-css.html -->

                                <option <?php if($c['que_type']=="Quantitative"){ echo 'selected'; }  ?> value="Quantitative">Quantitative</option>
                                <option <?php if($c['que_type']=="General Knowledge"){ echo 'selected'; }  ?> value="General Knowledge">General Knowledge</option>
                                <option <?php if($c['que_type']=="Logical"){ echo 'selected'; }  ?> value="Logical">Logical</option>
                                <option <?php if($c['que_type']=="Verbal"){ echo 'selected'; }  ?> value="Verbal">Verbal</option>
                            </select>

                            <input style="visibility: hidden;width:1px;" name="id" type="text" value="<?php echo $c['_id']; ?>">
                            <input style="visibility: hidden;width:1px;" name="oldTitle" type="text" value="<?php echo $c['title']; ?>">
                            <input style="visibility: hidden;width:10px;" type="text">
                            <div>Added on : <?php echo $c['date']; ?><br>
                            Last Updated on : <?php echo $c['update']; ?></div>
                        </div>

                        <div class="md-form mb-3">
                            <label data-error="wrong" data-success="right" for="defaultForm-title" class="font-weight-bold"><i class="fa fa-check"></i>&nbsp;Question Title</label>
                            <textarea required rows="1" cols="100" name="title" id="que_title" type="text" class="form-control validate" placeholder="Question Title"><?php echo $c["title"]; ?></textarea>
                            <!-- NOTE - In textarea value attribute don't work we need to just put value between opening and closing textarea tags -->
                        </div>

                        <div class="md-form mb-3">
                            <label data-error="wrong" data-success="right" for="defaultForm-desc" class="font-weight-bold"><i class="fa fa-question-circle"></i>&nbsp;Question</label>
                            <textarea required rows="3" cols="100" name="body" id="que_body" type="text" class="form-control validate" placeholder="Question Body"><?php echo $c["body"]; ?></textarea>
                            <!-- Reference : https://www.w3schools.com/tags/tryit.asp?filename=tryhtml5_textarea_form -->
                        </div>

                        <div class="md-form mb-3">
                            <label data-error="wrong" data-success="right" for="defaultForm-catg" class="font-weight-bold"><i class="fa fa-cog"></i>&nbsp;Option A</label>
                            <textarea required rows="1" cols="100" name="optionA" id="optionA" type="text" class="form-control validate" placeholder="Option A"><?php echo $c["optionA"]; ?></textarea>
                        </div>

                        <div class="md-form mb-3">
                            <label data-error="wrong" data-success="right" for="defaultForm-catg" class="font-weight-bold"><i class="fa fa-cog"></i>&nbsp;Option B</label>
                            <textarea required rows="1" cols="100" name="optionB" id="optionB" type="text" class="form-control validate" placeholder="Option B"><?php echo $c["optionB"]; ?></textarea>
                        </div>

                        <div class="md-form mb-3">
                            <label data-error="wrong" data-success="right" for="defaultForm-catg" class="font-weight-bold"><i class="fa fa-cog"></i>&nbsp;Option C</label>
                            <textarea required rows="1" cols="100" name="optionC" id="optionC" type="text" class="form-control validate" placeholder="Option C"><?php echo $c["optionC"]; ?></textarea>
                        </div>

                        <div class="md-form mb-3">
                            <label data-error="wrong" data-success="right" for="defaultForm-catg" class="font-weight-bold"><i class="fa fa-cog"></i>&nbsp;Option D</label>
                            <textarea required rows="1" cols="100" name="optionD" id="optionD" type="text" class="form-control validate" placeholder="Option D"><?php echo $c["optionD"]; ?></textarea>
                        </div>

                        <div class="md-form mb-3 d-flex">
                            <div class="mt-1 mr-2 font-weight-bold"><i class="fa fa-check-square-o"></i>&nbsp;Correct Answer :</div>
                            <select required name="answer" id="answer" class="form-control validate w-25">
                                <option value="" disabled selected hidden>Correct Option</option>
                                <!-- Reference : https://www.w3docs.com/snippets/css/how-to-create-a-placeholder-for-an-html5-select-box-by-using-only-html-and-css.html -->
                                
                                <option <?php if($c['answer']=="A"){ echo 'selected'; }?> value="A">A</option>
                                <option <?php if($c['answer']=="B"){ echo 'selected'; }?> value="B">B</option>
                                <option <?php if($c['answer']=="C"){ echo 'selected'; }?> value="C">C</option>
                                <option <?php if($c['answer']=="D"){ echo 'selected'; }?> value="D">D</option>
                            </select>
                        </div>
                        
                        <div class="md-form mb-3">
                            <label data-error="wrong" data-success="right" for="defaultForm-catg" class="font-weight-bold"><i class="fa fa-cog"></i>&nbsp;Marks</label>
                            <textarea required rows="1" cols="100" name="marks" id="marks" type="text" class="form-control validate" placeholder="Maximum Marks"><?php echo $c["marks"]; ?></textarea>
                        </div>

                        <div class="text-danger"><?php if($c['username']!=$username){ echo '<i class="fa fa-ban"></i>&nbsp;You are not authorised to make any changes'; } ?></div>

                    </div>
                    <div class="modal-footer d-flex justify-content-center">
                        <button style="font-size:17px;" <?php if($c['username']!=$username){ echo 'disabled'; } ?> class="btn btn-primary w-75"><b>UPDATE</b></button></form> 
                    </div>
                    
                    </div>
                </div>
                </div>

                <!-- Delete alert Modal -->
                <div id="myDeleteModal<?php echo $c['_id']; ?>" class="modal fade" role="dialog">
                <div class="modal-dialog modal-lg">

                    <!-- Modal content-->
                    <div class="modal-content" style="background:#fbe4e3;">
                    <div class="modal-header bg-danger">
                        <h4 class="modal-title text-white font-weight-bold">Delete Alert</h4>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>
                    <div class="modal-body" style="font-size:18px;">
                        <p><b>Are you sure, you want to delete this question ?</b></p>
                    </div>
                    <div class="modal-footer">
                        <!-- for passing 2 parameters in function :  -->
                        <?php  
                            $myId =  $c["_id"];
                            $myTitle = $c["title"]; 

                        ?>
                        <!-- <button onclick="myFunction1()">Click me</button> -->
                        <button style="font-size:17px;" onclick="myDelete('<?php echo $myId; ?>', '<?php echo $myTitle; ?>')" type="button" class="btn btn-danger mr-5"><b>Confirm Delete</b></button>

                        <!-- <button type="button" class="btn btn-danger" onclick="myDelete('<?php //echo $document['_id'] ?>')">Confirm Delete</button> -->
                        <button style="font-size:17px;" type="button" class="btn btn-default ml-2 mr-5" data-dismiss="modal"><b>Close</b></button>
                        <!-- Reference: https://stackoverflow.com/questions/40827494/how-to-pass-two-php-variables-in-html-button-onclick-function -->
                    </div>
                    </div>

                </div>
                </div>
                <?php } ?>
                <!-- Main div end here -->
                <!-- </div> -->
                <?php
            }else{
                ?>
                <i class='animated bounce infinite slower fas fa-angle-double-up' style='margin-left:96px;font-size:35px'></i>
                <span class="animated fadeIn delay-2s" style="font-size:19px;"><b>Click here to add new question</b></span> 
                <div align="center">
                    <div class="mb-5" style="margin-right:200px;"><img src="sad.png" height="250" width="250"></div>
                    <div class="mt-3 mr-5 comment" style="font-size:21px;margin-left:170px;"><strong>No Questions Added Yet</strong></div>
                </div>
                <?php
            }

        }else {
            // Redirecting to home page if unauthorised person access through direct links
            // echo "coming to last else";
            echo "<script type='text/javascript'> document.location = './'; </script>";
        }
    ?>
    

    <div>
        <a href="#top" id="myBtn"><i class="fa fa-chevron-circle-up" style="font-size:34px;"></i></a>
    </div>
    <div class="row" style="width:1364px;">
        <!-- <div class="col" style="width:100%;">  -->
        <?php
            include 'footer.php';
        ?>
        <!-- </div> -->
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

    // Reference : Hitesh Choudhary Youtube JS Course
    // Assignment of getting element(s) by id / class
    var counterYou = document.getElementsByClassName("MyQues")[0];
    var counterTotal = document.getElementsByClassName("TotalQues")[0];
    var myText = document.getElementsByClassName("MyText")[0];
    var totalText = document.getElementsByClassName("TotalText")[0];

    let count = 1;
    setInterval(() => {
        if (count < <?php echo $youFinalCount; ?>) {
            count++;
            counterYou.innerText = count;
        }else if (count >= <?php echo $youFinalCount; ?>) {
            myText.innerText = "Questions Contributed By You";
        }
    }, 400);

    let count2 = 1;
    setInterval(() => {
        if (count2 < <?php echo $totalCount; ?>) {
            count2++;
            counterTotal.innerText = count2;
        }else if (count2 >= <?php echo $totalCount; ?>) {
            totalText.innerText = "Total Questions";
        }
    }, 200);

    // Reference : https://www.w3schools.com/jsref/tryit.asp?filename=tryjsref_onchange

    // Working 3 lines
    // function demo() {
    // var x = document.getElementById("que_type_sort").value;
    // document.location = 'questions.php?sort='+x;

    // Reference : https://stackoverflow.com/questions/17863986/is-there-a-way-to-pass-javascript-variables-in-url
    // document.getElementById("demo").innerHTML = "You selected: " + x;
    // }
    </script>

</body>
</html>