<?php 
    if ($_SERVER['REQUEST_METHOD'] == "POST") {

        session_start();
        $username = $_SESSION['username']; // Take value from previous file
        $_SESSION['username'] = $username; // Pass value to next file

        require 'connection.php';

        // Creating / selecting database
        $db=$conn->queBank;

        // Create / select collection
        $collection=$db->questions;

        $que_type = $_POST['que_type'];
        $title = $_POST['title'];
        $body = $_POST['body'];
        $optionA = $_POST['optionA'];
        $optionB = $_POST['optionB'];
        $optionC = $_POST['optionC'];
        $optionD = $_POST['optionD'];
        $answer = $_POST['answer'];
        $marks = $_POST['marks'];

        // Converting 1 to 01 for sortinf perfectly
        if ($marks<10) {
            $marks = '0'+(string)$marks; // Reference : https://stackoverflow.com/questions/1035634/converting-an-integer-to-a-string-in-php
            $marks = (int)$marks;
        }

        $today = getdate();
        $date = $today['mday']."-".$today['mon']."-".$today['year'];
        // Converting string date to date format
        $date = strtotime($date);
        $date = date('d/M/Y', $date);
        $collection->insertOne([
            "que_type"=>$que_type, 
            "title"=>$title, 
            "body"=>$body, 
            "optionA"=>$optionA, 
            "optionB"=>$optionB, 
            "optionC"=>$optionC, 
            "optionD"=>$optionD, 
            "answer"=>$answer, 
            "marks"=>$marks,
            "username"=>$username,
            "date"=>$date,
            "update"=>$date,
            ]);

        echo "<script type='text/javascript'> document.location = 'questions.php?user=x'; </script>";

    }

?>