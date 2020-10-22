<?php 
    if ($_SERVER['REQUEST_METHOD'] == "POST") {

        require 'connection.php';

        // Creating / selecting database
        $db=$conn->queBank;
    
        // Create / select collection
        $collection=$db->user;

        $username = $_POST['username'];
        $password = $_POST['password'];
        // $collection->insertOne(["username"=>$username, "password"=>$password]);
        $check = $collection->find(['username'=>$username]);

        $count = $collection->count(['username'=>$username]);
        // Reference : https://github.com/mongodb/mongo-php-library/issues/125
        if ($count==1) {
            $error = "<b> TRY AGAIN - </b> Username Already Registered !!!";
            echo "<script type='text/javascript'> document.location = 'index.php?error=$error'; </script>";
        }else {
            $collection->insertOne(["username"=>$username, "password"=>$password]);
            // Reference : https://stackoverflow.com/questions/871858/php-pass-variable-to-next-page
            session_start();
            $_SESSION['username'] = $username;
            // $_SESSION['varname'] = $var_value; // Syntax
            echo "<script type='text/javascript'> document.location = 'questions.php?user=x'; </script>";
        }
        // foreach ($check as $c) {
        //     if ($c['username']==$username) {
        //         echo "username registered already";
        //     }else {
        //         $collection->insertOne(["username"=>$username, "password"=>$password]);
        //         echo "<script type='text/javascript'> document.location = './'; </script>";
        //     }
        // }

    }
?>