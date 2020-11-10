<?php
    include 'connection.php';
    $id=$_GET['id'];
    //Update MYSQL
    $query="DELETE FROM LUProfiles WHERE UserID='$id'";
    mysqli_query($connection,$query);
    $query2="UPDATE LUUsers SET UserType='Customer' WHERE UserID='$id'";
    mysqli_query($connection,$query2);
    
    //Update APEX
    require 'oci_connect_zeus.php';
    
    $query_str="DELETE FROM LUPROFILES WHERE USERID='$id'";
    $stid = oci_parse($connection2,$query_str);   
    oci_execute($stid); 

    $query_str2="UPDATE LUUSERS SET USERTYPE='CUSTOMER' WHERE USERID='$UserID'";
    $stid = oci_parse($connection2,$query_str2);   
    oci_execute($stid); 
   
   $_SESSION['RemoveWalker']=false;
    header ('location: manageWalkers.php');
?>