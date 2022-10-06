<?php
require_once "./service.php";
require_once "./serviceApi.php";
if(isset($_POST['login'])){

    $username=$_POST['email'];
    $password=$_POST['password'];
    authentication::login($username,$password);
}
if(isset($_POST['Create'])){
    $fname=$_POST['fname'];
    $lname=$_POST['lname'];
    $email=$_POST['email'];
    $phone=$_POST['phone'];
    $major=$_POST['major'];
    $year=$_POST['year'];
    $password=$_POST['password'];
    authentication::register($fname,$lname,$email,$phone,$major,$year,$password);

}

if(isset($_POST['update'])){
    $fname=$_POST['fname'];
    $lname=$_POST['lname'];
    $email=$_POST['email'];
    $phone=$_POST['phone'];
    $major=$_POST['major'];
    $year=$_POST['year'];
    authentication::update($fname,$lname,$email,$phone,$major,$year);
}

if(isset($_POST['send'])){
    $attestation=$_POST['request'];
    $comment=$_POST['message'];
    authentication::SendRequest($attestation,$comment);
}
if(isset($_POST['finished'])){
    $id=$_POST['id'];
    authentication::finishRequest($id); 
}
if(isset($_POST['reject'])){
    $id=$_POST['id'];
    authentication::rejectRequest($id); 
}
if(isset($_POST['undo'])){
    $id=$_POST['id'];
    authentication::undoRequest($id); 
}
if(isset($_POST['remove'])){
    $id=$_POST['id'];
    authentication::removeemploye($id); 
}
if(isset($_POST['add'])){
    $fname=$_POST['fname'];
    $lname=$_POST['lname'];
    $email=$_POST['email'];
    $phone=$_POST['phone'];
    authentication::addemploye($fname,$lname,$email,$phone); 
}
