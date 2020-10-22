<?php 
    if ($_SERVER['REQUEST_METHOD'] == "POST") {

        require 'connection.php';

        // Creating / selecting database
        $db=$conn->queBank;
    
        // Create / select collection
        $collection=$db->user;

        $username = $_POST['username'];
        $password = $_POST['password'];
        
        $check = $collection->find(['username'=>$username, 'password'=>$password]);

        $count = $collection->count(['username'=>$username, 'password'=>$password]);
        // Reference : https://github.com/mongodb/mongo-php-library/issues/125
        if ($count==1) {
            // Reference : https://stackoverflow.com/questions/871858/php-pass-variable-to-next-page
            session_start();
            $_SESSION['username'] = $username;
            // $_SESSION['varname'] = $var_value; // Syntax
            echo "<script type='text/javascript'> document.location = 'questions.php?user=x'; </script>";
        }else {
            $error = "<b> TRY AGAIN - </b> Username / Password Incorrect !!!";
            echo "<script type='text/javascript'> document.location = 'index.php?error=$error'; </script>";
        }

        // foreach ($check as $c) {
        //     if ($c['username']==$username and $c['password']==$password) {
        //         echo "Login Successful !!!";
        //     }else{
        //         echo "Login Unsuccess !!!";
        //         // echo "<script type='text/javascript'> document.location = './'; </script>";
        //     }
        // }

    }
?>