<?php

    session_start();
    include "connection.php";
    
    //gather the data submitted and store in variables
    $query            = "SELECT * FROM LUServices";
    $searchResult     = $_POST['search']; //search textbox
    $sort             = $_POST['sort']; //sort by drop down
    $_SESSION['sort'] = $_POST['sort'];
    
    
    //Search and Sort Options if the search button has been pressed
    if (isset($_POST['searchButton'])) {
        
        //if search text has been entered but no sort selected
        if (isset($_POST['search'])) { 
            $query = "SELECT * FROM LUServices WHERE ServiceName LIKE '%$searchResult%' OR ServiceDescription LIKE '%$searchResult%'";
        }
        
        //if search text has been entered and sort has been selected
        if (isset($_POST['search'])) {       
            if (isset($_POST['sort']) && $_POST['sort'] == "priceSortAsc") {
                $query = "SELECT * FROM LUServices WHERE ServiceName LIKE '%$searchResult%' OR ServiceDescription LIKE '%$searchResult%' ORDER BY ServicePrice ASC";
            } else if (isset($_POST['sort']) && $_POST['sort'] == "priceSortDsc") {
                $query = "SELECT * FROM LUServices WHERE ServiceName LIKE '%$searchResult%' OR ServiceDescription LIKE '%$searchResult%' ORDER BY ServicePrice DESC";
            } else if (isset($_POST['sort']) && $_POST['sort'] == "nameAZ") {
                $query = "SELECT * FROM LUServices WHERE ServiceName LIKE '%$searchResult%' OR ServiceDescription LIKE '%$searchResult%' ORDER BY ServiceName ASC";
            } else if (isset($_POST['sort']) && $_POST['sort'] == "nameZA") {
                $query = "SELECT * FROM LUServices WHERE ServiceName LIKE '%$searchResult%' OR ServiceDescription LIKE '%$searchResult%' ORDER BY ServiceName DESC";
            }
        }
        
        //if nothing has been searched but want to sort
        else if (!isset($_POST['search'])) {      
            if (isset($_POST['sort']) && $_POST['sort'] == "priceSortAsc") {
                $query = "SELECT * FROM LUServices ORDER BY ServicePrice ASC";
            } else if (isset($_POST['sort']) && $_POST['sort'] == "priceSortDsc") {
                $query = "SELECT * FROM LUServices ORDER BY ServicePrice DESC";
            } else if (isset($_POST['sort']) && $_POST['sort'] == "nameAZ") {
                $query = "SELECT * FROM LUServices ORDER BY ServicePrice ASC";
            } else if (isset($_POST['sort']) && $_POST['sort'] == "nameZA") {
                $query = "SELECT * FROM LUServices ORDER BY ServicePrice DESC";
            }
        }
        
    }
    
    //run query that has been created
    $result = mysqli_query($connection, $query);
    
    
    
    //build table
    echo "<table id='services'>";
    echo "<tr><th>Service Name</th>";
    echo "<th>Description</th>";
    echo "<th>Price</th>";
    echo "</tr>";
    
    //while loop to create a new row for each row in the database
    while ($row = mysqli_fetch_assoc($result)) {
        
        //if a session variable has been set (user is logged in), an "add to favourites" button will be added to the products table
            echo "<tr><td>";        
            echo $row["ServiceName"] . " ";        
            echo "</td><td>";
            echo "<br>"; 
            echo $row["ServiceDescription"] . " ";       
            echo "</td><td>";
            echo "<br>"; 
            echo $row["ServicePrice"] . " ";
            echo "<br>";       
            echo "</td></tr>";
    }
    
    echo "</table>";
    

?> 