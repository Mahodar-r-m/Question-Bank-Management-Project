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

        // Extra in update than add
        $id = $_POST['id'];
        $oldTitle = $_POST['oldTitle'];

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
            $marks = '0'+(string)$marks;
            $marks = (int)$marks;
        }

        $allCheck = $collection->find();

        $today = getdate();
        $date = $today['mday']."-".$today['mon']."-".$today['year'];
        // Converting string date to date format
        $date = strtotime($date);
        $date = date('d/M/Y', $date);
        foreach ($allCheck as $check) {
            if ($check['_id']==$id) {
                $collection->updateOne(["title"=>$oldTitle],
                    ['$set'=>[
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
                    "update"=>$date,
                ]]);
            }
        }
        
        echo "<script type='text/javascript'> document.location = 'questions.php?user=x'; </script>";

    }

?>