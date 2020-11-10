<?php
    include 'connection.php';
    $id=$_GET['id'];
    //Updates MYSQL
    $query="DELETE FROM LUApplicants WHERE ApplicantID='$id'";
    mysqli_query($connection,$query);
    
    //Updates APEX
    require 'oci_connect_zeus.php';
    $query_str="DELETE FROM LUAPPLICANTS WHERE APPLICANTID='$id'";
    $stid = oci_parse($connection2,$query_str);   
    oci_execute($stid); 
   
    $_SESSION['AcceptApplicant']="'$Name' has been rejected.";
    header ('location: manageWalkers.php');
?>