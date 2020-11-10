<?php
//include connection to zeus
  require 'oci_connect_zeus.php';
//Produce and execute query to fetch and display all records in the user table
  echo '<h2>Display Data</h2>';
  $query_str ="SELECT * FROM TEST";

//Prepare query for execution on Oracle server
  $stid =oci_parse($connection2, $query_str);
  
//Execute query
  oci_execute($stid);

//Return result of query as associative array
//Loop around array and display result

  echo '<table border="1">';
  while ($row = oci_fetch_assoc($stid)){
    echo '<tr>'; 
    echo '<td>' . $row['USERID'] . '</td>'; 
    echo '<td>' . $row['USERNAME'] . '</td>'; 
    echo '<td>' . $row['PASSWORD'] . '</td>'; 
    echo '</tr>'; 
  }
  echo '</table>';

//Produce and execute query to INSERT a new record in the user table

  echo '<h2>Insert Data and Display</h2>';

/*Note that auto increment as used in MySQL does not work in the same way on Oracle
 *you will need a trigger before Insert that will generate a next value as shown in use here
 */

  $query_str = "INSERT INTO TEST (USERID, USERNAME, PASSWORD) VALUES (TEST_SEQ.nextval, 'onemore','password')";
  $stid = oci_parse($connection2,$query_str);  
  
  oci_execute($stid);

//Display table including new record 

  $query_str ="SELECT * FROM TEST ORDER BY USERID";
  $stid =oci_parse($connection2, $query_str);
  oci_execute($stid);
  echo '<table border="1">';
  while ($row = oci_fetch_assoc($stid)){
    echo '<tr>'; 
    echo '<td>' . $row['USERID'] . '</td>'; 
    echo '<td>' . $row['USERNAME'] . '</td>'; 
    echo '<td>' . $row['PASSWORD'] . '</td>'; 
    echo '</tr>'; 
  }
  echo '</table>';

//Delete a record

  //echo '<h2>Delete User called \'another\' and update password of \'Paul Doney\'</h2>';
  //$query_str = "DELETE FROM TEST WHERE USERNAME = 'onemore' ";
 //$stid = oci_parse($connection2,$query_str);   
  //oci_execute($stid);
//Update the password of a record
  $query_str = "UPDATE TEST SET PASSWORD='SECRET' WHERE USERNAME='Paul Doney' ";
  $stid = oci_parse($connection2,$query_str);   
  oci_execute($stid); 
//Display Data
  $query_str ="SELECT * FROM TEST ORDER BY USERID";
  $stid =oci_parse($connection2, $query_str);
  oci_execute($stid);
  echo '<table border="1">';
  while ($row = oci_fetch_assoc($stid)){
    echo '<tr>'; 
    echo '<td>' . $row['USERID'] . '</td>'; 
    echo '<td>' . $row['USERNAME'] . '</td>'; 
    echo '<td>' . $row['PASSWORD'] . '</td>'; 
    echo '</tr>'; 
  }
  echo '</table>';
//reset password
//Update the password of a record
  $query_str = "UPDATE TEST SET PASSWORD='password' WHERE USERNAME='Paul Doney' ";
  $stid = oci_parse($connection2,$query_str);   
  oci_execute($stid); 

?>