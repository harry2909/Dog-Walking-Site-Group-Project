<?php
session_start();
//include init.php
include 'connection.php';
//Gather details submitted from the $_POST array and store in local vars
$Email=$_POST['txtEmail'];
$Password=$_POST['txtPass'];
//build query to SELECT records from the users table WHERE
//the username AND password in the table are equal to those entered.
$query="SELECT * FROM LUUsers WHERE UserEmail='$Email'";
//run query and store result
$result=mysqli_query($connection, $query);
//check result and generate message with code below
if ($row = mysqli_fetch_assoc($result)) {
    $hash=$row['UserPassword'];//sets the value of password in the table
    if (password_verify($Password, $hash)) {//checks if the password is correct
        //sets session variables
        $_SESSION['user']=$row['UserFirstname'];
        $_SESSION['userID']=$row['UserID'];
        $_SESSION['message']='login success';
        if ($row['UserType']=='Admin'){//Checks if the user is an admin
            $_SESSION['UserType']='Admin';
        }
        if ($row['UserType']=='Employee'){//Checks if the user is an admin
            $_SESSION['UserType']='Employee';
            $id=$_SESSION['userID'];
            $query="SELECT ProfileID FROM LUProfiles where UserID= '$id'";
        $result=mysqli_query($connection, $query);
            while($row=mysqli_fetch_assoc($result)){
                $_SESSION['profileID']=$row['ProfileID'];
            }
        }
        if ($row['UserType']=='Customer'){//Checks if the user is an admin
            $_SESSION['UserType']='Customer';
        }
       $_SESSION['message']= 'You are now logged in';
       
        header ('location: account.php');
    }
    else{
        //creditionals are wrong, user taken back to login form
        $_SESSION['message']= 'Details entered are invalid';
        header ('location: login.php');
    }
}
else {
            //username is not in the table, user taken back to login form
            $_SESSION['message']= 'Email not recognised';
            header ('location: login.php');
        }
?>