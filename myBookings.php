 <?php
                session_start();
                include 'connection.php';
                //Sets an sql query and runs it 
                $id=$_SESSION['userID'];
                $name=$_SESSION['user'];
                $currentDate=date("Y-m-d");
                $query="SELECT * FROM LUBookings WHERE UserID='$id'AND ServiceDate<'$currentDate'";
                $result=mysqli_query($connection, $query);
                //Shows users previous bookings
                echo '<h3>Your previous bookings:</h3><br>';
                echo '<table id="userArea">';
                echo '<tr><th>Service</th><th>Walker Name</th><th>Booking date</th><th>Service Date</th><th>Service End Date</th><th>Pet Name</th><th>Comments</th><th>Payment Method</th><th>Amount</th><th> Walker Rating</th><th></th></tr>';
                while($row=mysqli_fetch_assoc($result)){
                    $serviceID=$row['ServiceID'];
                    $query2="SELECT ServiceName FROM LUServices WHERE ServiceID='$serviceID' ";
                    $result2=mysqli_query($connection, $query2);
                    $row2=mysqli_fetch_assoc($result2);
                    $profileID=$row['ProfileID'];
                    $query3="SELECT WalkerName FROM LUProfiles WHERE ProfileID='$profileID' ";
                    $result3=mysqli_query($connection, $query3);
                    $row3=mysqli_fetch_assoc($result3);
                    if($row['BookingRating']==0){
                    echo '<tr><td>'.$row2['ServiceName'].'</td><td>'.$row3['WalkerName'].'</td><td>'.$row['BookingDate'].'</td><td>'.$row['ServiceDate'].'</td><td>'.$row['EndDate'].'</td><td>'.$row['PetName'].'</td><td>'.$row['UserComment'].'</td><td>'.$row['PaymentMethod'].'</td><td>'.$row['Amount'].'</td><td>'.$row['BookingRating'].'</td><td><a href="rateWalker.php?id='. $row['BookingID'].'">Rate Walker</a></td></tr>';
                }
                else{
                     echo '<tr><td>'.$row2['ServiceName'].'</td><td>'.$row3['WalkerName'].'</td><td>'.$row['BookingDate'].'</td><td>'.$row['ServiceDate'].'</td><td>'.$row['EndDate'].'</td><td>'.$row['PetName'].'</td><td>'.$row['UserComment'].'</td><td>'.$row['PaymentMethod'].'</td><td>'.$row['Amount'].'</td><td>'.$row['BookingRating'].'</td></tr>';
                }
    
                }
                echo '</table>';
                //Shows users future bookings
                 $query="SELECT * FROM LUBookings WHERE UserID='$id'AND ((ServiceDate>'$currentDate')OR (ServiceDate='$currentDate')) ";
                $result=mysqli_query($connection, $query);
                echo '<h3>Your upcoming bookings:</h3><br>';
                echo '<table id="userArea">';
                echo '<tr><th>Service</th><th>Walker Name</th><th>Booking date</th><th>Service Date</th><th>Service Time</th><th>Service End Date</th><th>Pet Name</th><th>Comments</th><th>Payment Method</th><th>Amount</th></tr>';
                while($row=mysqli_fetch_assoc($result)){
                    $serviceID=$row['ServiceID'];
                    $query2="SELECT ServiceName FROM LUServices WHERE ServiceID='$serviceID' ";
                    $result2=mysqli_query($connection, $query2);
                    $row2=mysqli_fetch_assoc($result2);
                    
                    $profileID=$row['ProfileID'];
                    $query3="SELECT WalkerName FROM LUProfiles WHERE ProfileID='$profileID' ";
                    $result3=mysqli_query($connection, $query3);
                    $row3=mysqli_fetch_assoc($result3);
                    echo '<tr><td>'.$row2['ServiceName'].'</td><td>'.$row3['WalkerName'].'</td><td>'.$row['BookingDate'].'</td><td>'.$row['ServiceDate'].'</td><td>'.$row['ServiceTime'].'</td><td>'.$row['EndDate'].'</td><td>'.$row['PetName'].'</td><td>'.$row['UserComment'].'</td><td>'.$row['PaymentMethod'].'</td><td>'.$row['Amount'].'</td><td><a href="cancelBooking.php?id='. $row['BookingID'].'">Cancel Booking</a></td></tr>';
                }
                echo '</table>';
            
?>