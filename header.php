<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        .navlink{
            color:black;
            font-size: 19px;
            border-bottom: 3px solid #bbd5ec;
            transition: all 0.5s;
        }
        .navlink:hover{
            color: #1f76c2;
            border-bottom: 3px solid #1f76c2;
            text-decoration: none;
        }
    </style>
</head>
<body>

<?php
    require 'connection.php';

    // Creating / selecting database
    $db=$conn->queBank;

    // Create / select collection
    $collection=$db->questions;

    $check = $collection->find();
    $count = $collection->count();
?>

<div class="" id="top">
    <nav class="navbar navbar-expand-md navbar-light shadow" style="background:#bbd5ec;font-family: cursive;">
    <div class="container">
        <a class="navbar-brand d-flex">
            <div><img src="OnlyLogo.png" style="height: 50px; border-right: 1px solid #333" class="pr-3"></div>
            <div class="pl-3 pt-1 font-weight-bold" style="font-size:25px;">Question Bank Management</div>
        </a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <!-- Left Side Of Navbar -->
            <ul class="navbar-nav mr-auto">
                <li class="mr-3 ml-2"><a class="navlink" href="questions.php?user=x">Questions</a></li>
                <li class="mr-3 ml-2"><a class="navlink" <?php if ($count>0) {
                    ?> href="reportQue.php" <?php
                }else {
                   ?> href="#" <?php
                } ?> >Report</a></li>
            </ul>

            <!-- Right Side Of Navbar -->
            <ul class="navbar-nav ml-auto">
                <!-- Authentication Links -->
                
                <li class="nav-item dropdown">
                    <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                        <?php echo $username; ?>
                    </a>

                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                        <a class="dropdown-item" href="./">
                            Logout
                        </a>
                    </div>
                </li>
            </ul>
        </div>
    </div>
</nav>
</div>

</body>
</html>