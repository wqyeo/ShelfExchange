<?php

/*
 * Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
 * Click nbfs://nbhost/SystemFileSystem/Templates/Scripting/EmptyPHP.php to edit this template
 */
include 'util.php';
if (isset($_POST['update'])) {
    $id = $_POST['id'];
    $username = $_POST['username'];
    $email = $_POST['email'];
    $sql = "UPDATE user SET id='$id', username='$username', email='$email' WHERE id='$id'";
    $result = mysqli_query($conn, $sql);
    if ($result) {
        header('Location: testAPAcc.php');
    } else {
        die(mysqli_error($conn));
    }
}
?>