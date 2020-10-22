<?php
    require 'connection.php';

    // Creating / selecting database
    $db=$conn->queBank;

    // Create / select collection
    $collection1=$db->questions;

    // Create / select collection
    $collection2=$db->report;

    // Clear the collection to add new refreshed data
    $collection2->drop();
    // Reference : https://docs.mongodb.com/php-library/v1.2/reference/method/MongoDBCollection-drop/

    // Collecting unique dates
    $dates = $collection1->distinct('date');

    // Sorting Dates in descending order
    $d = [];
    foreach ($dates as $date) {
        array_push($d,$date);
    }
    rsort($d); // Reference : https://www.php.net/manual/en/function.sort.php

    foreach ($d as $a) {

        $reportDate = $a;

        // Calculating total questions sum for each user on each date repectively
        $match = ['$match'=>["date"=>$a]];
        $group = ['$group'=>["_id"=>'$username',"Total Questions"=>['$sum'=>1]]];
        $users = $collection1->aggregate([$match,$group]);

        foreach ($users as $user) {

            $reportUser = $user['_id'];

            // Calculating total sum for each question type 
            $b = $reportUser;
            $match = ['$match'=>["date"=>$a,"username"=>$b]];
            $group = ['$group'=>["_id"=>'$que_type',"Questions Total"=>['$sum'=>1]]];
            $Qtype = $collection1->aggregate([$match,$group]);

            $reportQueArr = [];
            foreach ($Qtype as $c) {

                $reportQueType = $c['_id'];
                $reportTypeTotal = $c['Questions Total'];

                $temp = [$reportQueType, $reportTypeTotal];
                array_push($reportQueArr,$temp);
            }

            $reportTotal = $user['Total Questions'];

            $reportFinalTotal = [$reportDate, $reportUser];

            $types = ['Quantitative', 'General Knowledge', 'Logical', 'Verbal'];
            foreach ($types as $x) { 
                $success = false;
                foreach ($reportQueArr as $k) {
                    if ($k[0] == $x) {
                        $success = true;
                        // Converting 1 to 01 for sortinf perfectly
                        if ($k[1]<10) {
                            $k[1] = '0'+(string)$k[1];
                            $k[1] = (int)$k[1];
                        }
                        array_push($reportFinalTotal,$k[1]);
                    }
                }
                if (!$success) {
                    array_push($reportFinalTotal,0);
                }
            }
            // Converting 1 to 01 for sortinf perfectly
            if ($reportTotal<10) {
                $reportTotal = '0'+(string)$reportTotal;
                $reportTotal = (int)$reportTotal;
            }
            array_push($reportFinalTotal,$reportTotal);
            // echo $reportFinalTotal;
            foreach ($reportFinalTotal as $key) {
                // echo $key." ";
            }
            $collection2->insertOne([
                "date"=>$reportFinalTotal[0],
                "username"=>$reportFinalTotal[1],
                "Quantitative"=>$reportFinalTotal[2],
                "General Knowledge"=>$reportFinalTotal[3],
                "Logical"=>$reportFinalTotal[4],
                "Verbal"=>$reportFinalTotal[5],
                "Total"=>$reportFinalTotal[6],
            ]);
            
        }
        // echo "<br>";
    }

?>