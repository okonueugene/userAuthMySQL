<?php

require_once "../config.php";
session_start();

//register users
function registerUser($fullnames, $email, $password, $gender, $country){
    //create a connection variable using the db function in config.php
    $conn = db();
   //check if user with this email already exist in the database
   $select = mysqli_query($conn, "SELECT * FROM students WHERE email = '$email'");
if(mysqli_num_rows($select)) {
    exit('This email address is already registered!');}
    else{
        $sql = "INSERT INTO students (full_names, country, email,gender,password)
VALUES ('$fullnames', '$country', '$email','$gender','$password')";

if ($conn->query($sql) === TRUE) {
  echo "User Successfully registered";
} else {
  echo "Error: " . $sql . "<br>" . $conn->error;
}

$conn->close();
    }
}


//login users
function loginUser($email, $password){
    //create a connection variable using the db function in config.php
    $conn = db();

    echo "<h1 style='color: red'> LOG ME IN (IMPLEMENT ME) </h1>";
    //open connection to the database and check if username exist in the database
    $select = mysqli_query($conn, "SELECT * FROM students WHERE email = '$email'");
    if(mysqli_num_rows($select)) {
        $sql = "SELECT * FROM students WHERE email = '$email' and password = '$password'";
        $result = mysqli_query($conn,$sql);
        $row = mysqli_fetch_array($result,MYSQLI_ASSOC);
        
        $count = mysqli_num_rows($result);
          
        if($count == 1) {
            $_SESSION['username'] = $row['full_names'];
           
           header("location: /userAuthMySQL/dashboard.php");
        }else {
            header("location: /userAuthMySQL/forms/login.html");        }
    }
    $conn->close();
    //if it does, check if the password is the same with what is given
    //if true then set user session for the user and redirect to the dasbboard
}


function resetPassword($email, $password){
    //create a connection variable using the db function in config.php
    $conn = db();
    echo "<h1 style='color: red'>RESET YOUR PASSWORD (IMPLEMENT ME)</h1>";
    //open connection to the database and check if username exist in the database
    $select = mysqli_query($conn, "SELECT * FROM students WHERE email = '$email'");
    if(mysqli_num_rows($select)) {
        $sql="UPDATE students SET password='$password' WHERE email = '$email' ";
    }
    $conn->close();
    //if it does, replace the password with $password given
}

function getusers(){
    $conn = db();
    $sql = "SELECT * FROM Students";
    $result = mysqli_query($conn, $sql);
    echo"<html>
    <head></head>
    <body>
    <center><h1><u> ZURI PHP STUDENTS </u> </h1> 
    <table border='1' style='width: 700px; background-color: magenta; border-style: none'; >
    <tr style='height: 40px'><th>ID</th><th>Full Names</th> <th>Email</th> <th>Gender</th> <th>Country</th> <th>Action</th></tr>";
    if(mysqli_num_rows($result) > 0){
        while($data = mysqli_fetch_assoc($result)){
            //show data
            echo "<tr style='height: 30px'>".
                "<td style='width: 50px; background: blue'>" . $data['id'] . "</td>
                <td style='width: 150px'>" . $data['full_names'] .
                "</td> <td style='width: 150px'>" . $data['email'] .
                "</td> <td style='width: 150px'>" . $data['gender'] . 
                "</td> <td style='width: 150px'>" . $data['country'] . 
                "</td>
                <form action='action.php' method='post'>
                <input type='hidden' name='id'" .
                 "value=" . $data['id'] . ">".
                "<td style='width: 150px'> <button type='submit', name='delete'> DELETE </button>".
                "</tr>";
        }
        echo "</table></table></center></body></html>";
    }
    //return users from the database
    //loop through the users and display them on a table
}

 function deleteaccount($id){
     $conn = db();
     //delete user with the given id from the database
     $sql="DELETE FROM students WHERE id='$id'";
     $conn->close();
 }
