<?php 
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: authenticate.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CRUD - OOP</title>
    
    <script src="js/jquery/jquery-3.6.0.min.js"></script>
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <link rel="stylesheet" href="bootstrap/bootstrap.min.css">
    <script src="js/sweetalert/sweetalert.min.js"></script>

</head>
<body>
    <div class="container mt-5">