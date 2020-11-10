<?php
            session_start();
            include 'connection.php';
            //Sets an sql query and runs it 
            $id=$_SESSION['userID'];
            $name=$_SESSION['user'];
            $currentDate=date("Y-m-d");
            $profileID=$_SESSION['profileID'];
            $query="SELECT * FROM LUBookings WHERE ProfileID='$profileID' AND ((ServiceDate>'$currentDate')OR (ServiceDate='$currentDate'))  ";
            $result=mysqli_query($connection, $query);
            //Shows walkers future walks
            echo '<h3>Your upcoming Walks / Services:</h3><br>';
            echo '<table id="userArea">';
            echo '<tr><th>Service </th><th>Service Date</th><th>Service Time</th><th>Service End Date</th><th>Pet Name</th><th>Comments</th></tr>';
            while($row=mysqli_fetch_assoc($result)){
                $serviceID=$row['ServiceID'];
                $query2="SELECT ServiceName FROM LUServices WHERE ServiceID='$serviceID' ";
                $result2=mysqli_query($connection, $query2);
                $row2=mysqli_fetch_assoc($result2);
                echo '<tr><td>'.$row2['ServiceName'].'</td><td>'.$row['ServiceDate'].'</td><td>'.$row['ServiceTime'].'</td><td>'.$row['EndDate'].'</td><td>'.$row['PetName'].'</td><td>'.$row['UserComment'].'</td><td><a href="cancelBooking.php?id='. $row['BookingID'].'">Cancel Booking</a></td></tr>';

            }
            echo '</table>';
        ?>