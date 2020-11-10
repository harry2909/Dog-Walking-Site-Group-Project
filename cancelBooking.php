<?php
$id=$_GET['id'];
//Updates APEX
require 'oci_connect_zeus.php';
$query_str="DELETE FROM LUBOOKINGS WHERE BOOKINGID='$id' ";
echo $query_str;
$stid = oci_parse($connection2,$query_str);   
oci_execute($stid); 

//Updates MYSQL
include 'connection.php';
$query="DELETE FROM LUBookings WHERE BookingID='$id' ";

$_SESSION['CancelBooking']=true;
mysqli_query($connection, $query);




if (mysqli_affected_rows($connection) > 0) {
    header("Location: {$_SERVER['HTTP_REFERER']}");
} 
else {
    echo "Error in query: $query. " . mysqli_error($connection);
    exit ;
}

?>