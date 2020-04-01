<?php

// action php
include('db.php');

// menangkap formfile action 
if (isset($_POST["action"])) {
    // and function insert to database
    if ($_POST["action"] == "insert") {
        $query = " INSERT INTO user (first_name,last_name) VALUES ( ' " . $_POST["first_name"] . " ',' " . $_POST["last_name"] . " ' )";
        $statement = $connect->prepare($query);
        $statement->execute();
        echo "<p> Data Telah di input! </p>";
    }

    // function edit database 
    // 1. untuk menampilkan value pada form modal 
    if ($_POST["action"] == "fetch_single") {
        $query = " SELECT * FROM user WHERE id = '" . $_POST["id"] . "'";
        $statement = $connect->prepare($query);
        $statement->execute();
        $result = $statement->fetchAll();
        foreach ($result as $row) {
            $output['first_name'] = $row['first_name'];
            $output['last_name'] = $row['last_name'];
        }
        echo json_encode($output);
    }
    // 2. untuk update value yang di input ke database 
    if ($_POST["action"] == "update") {
        $query = " UPDATE user SET
        first_name = '" . $_POST['first_name'] . "',
        last_name = '" . $_POST['last_name'] . "'
        WHERE id = '" . $_POST['hidden_id'] . "'
        ";
        $statement = $connect->prepare($query);
        $statement->execute();
        echo "<p> Data Updated </p>";
    }

    // 3. Untuk Delete Data
    if ($_POST["action"] == "delete") {
        $query = "DELETE FROM user WHERE id = '" . $_POST["id"] . "'";
        $statement = $connect->prepare($query);
        $statement->execute();
        echo "<p> Data Deleted </p>";
    }
}
