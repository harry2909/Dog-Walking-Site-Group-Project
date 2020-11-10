<?php
    include 'connection.php';
    //Gets data from MYSQL for the correct applicant
    $id=$_GET['id'];
    $query="SELECT * FROM LUApplicants WHERE ApplicantID='$id' ";
    $result=mysqli_query($connection, $query);
    $row=mysqli_fetch_assoc($result);
    $UserID=$row['UserID'];
    $Name=$row['WalkerName'];
    $Imagename=$row['WalkerImg'];
    $Age=$row['WalkerAge'];
    $Bio=$row['WalkerBio'];

    //Updates MYSQL
    $query="INSERT INTO LUProfiles (UserID,WalkerName,WalkerImg,WalkerAge,WalkerBio,WalkerRating,RatingCount,RatingTotal) VALUES ('$UserID','$Name','$Imagename','$Age','$Bio',0,0,0)";
    mysqli_query($connection,$query);
    $query2="DELETE FROM LUApplicants WHERE ApplicantID='$id'";
    mysqli_query($connection,$query2);
    $query3="UPDATE LUUsers SET UserType='Employee' WHERE UserID='$UserID'";
    mysqli_query($connection,$query3);


    //Updates APEX
    
    require 'oci_connect_zeus.php';
    
    
    $query_str1="INSERT INTO LUPROFILES (PROFILEID,USERID,WALKERNAME,WALKERIMG,WALKERAGE,WALKERBIO,WALKERRATING,RATINGCOUNT,RATINGTOTAL) VALUES (SEQ_PROFILES.nextval,'$UserID','$Name','$Imagename','$Age','$Bio',0,0,0)";
    $stid = oci_parse($connection2,$query_str1);   
    oci_execute($stid); 
    
    $query_str2="DELETE FROM LUAPPLICANTS WHERE APPLICANTID='$id'";
    $stid = oci_parse($connection2,$query_str2);   
    oci_execute($stid); 
    
    $query_str3="UPDATE LUUSERS SET USERType='Employee' WHERE USERID='$UserID'";
    $stid = oci_parse($connection2,$query_str3);   
    oci_execute($stid); 
    
    $_SESSION['AcceptApplicant']="'$Name' is now a walker.";
    header ('location: manageWalkers.php');

?>
