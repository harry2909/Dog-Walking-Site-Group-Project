<!DOCTYPE html>
<html>
<link href="Stylesheet/stylesheet.css" rel="stylesheet" type="text/css" />

<head>
    <title>Leads United</title>
    <link href="https://fonts.googleapis.com/css?family=Montserrat&display=swap" rel="stylesheet">
    <link rel="icon" href="images/leadsunited.ico" type="image/x-icon" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>

<body>
    <div class="grid">
        <div class="logo"><img src="images/leadsunited.png" alt="Leads United Logo" /></div>
        <div class="navbar" style="font-family: 'Montserrat' , serif;">
            <a href="home.php">Home</a></li>
            <a href="services.php">Services</a>
            <a href="team.php">Our Team</a>
            <a href="gallery.php">Gallery</a>
            <a href="contact.php">Contact Us</a>
            <?php 
                //Adds relevant tabs to navbar
                session_start();
                if($_SESSION['user']==true){
                    echo $_SESSION["txtFirstname"];
                    echo '<a href = "account.php">My Account</a>';
                    echo '<a href = "logout.php"><span>Logout</span></a>';
                }
                else
                {
                    echo'<a href="login.php"><span>Login/Register</span></a>';
                }
            ?>

        </div>
        <div class="container">
            <section id="content">

                <?php
                    session_start();
                    //Checks if user is logged in
                    if(!isset($_SESSION['user'])){
                        header ('location: login.php');
                    }
                    if ($_SESSION['UserType']=="Admin"){
                      //Shows links to other admin pages
                        echo '<div class="bookingLinks">';
                        echo '<div class="manageCustomer">';    
                        echo '<a href="manageCustomers.php"><center>Manage<br />Customers</center></a>';
                        echo '</div>';                       
                        echo '<div class="manageBooking">';
                        echo '<a href="manageBookings.php"><center>Manage<br />Bookings</center></a>';
                        echo '</div>';                       
                        echo '<div class="manageWalkers">';
                        echo '<a href="manageWalkers.php" ><center>Manage<br />Walkers</center></a>';
                        echo '</div>';
                        echo '</div>'; 
                    }
                        include 'connection.php';
                        //Outputs dialogue box if user has updated database
                        if ($_SESSION['EditBookings']==true){
                            echo ' <script type="text/javascript">
                            alert (" Dog Walker Assigned");
                            </script>';
                            $_SESSION['EditBookings']=false;
                        }
                        if ($_SESSION['CancelBooking']==true){
                            echo ' <script type="text/javascript">
                            alert ("Booking Cancelled");
                            </script>';
                            $_SESSION['CancelBooking']=false;
                        }
                        $query="SELECT * FROM LUBookings;";
                        $result=mysqli_query($connection, $query);
                        echo '<h1>Manage Bookings</h1> <br><br>';
                        echo '<h3>All bookings:</h3><br>';
                        echo '<table id="userArea">';
                        //Displays all bookings
                        echo '<tr><th>Customer Name</th><th>Service</th><th>Walker Name</th><th>Booking Date</th><th>Service Date</th><th>Service Time</th><th>Service End Date</th><th>Pet Name</th><th>Comments</th><th>Payment Method</th><th>Amount</th></tr>';
                        while($row=mysqli_fetch_assoc($result)){
                            $serviceID=$row['ServiceID'];
                            $query2="SELECT ServiceName FROM LUServices WHERE ServiceID='$serviceID' ";
                            $result2=mysqli_query($connection, $query2);
                            $row2=mysqli_fetch_assoc($result2);
            
                            $profileID=$row['ProfileID'];
                            $query3="SELECT WalkerName FROM LUProfiles WHERE ProfileID='$profileID' ";
                            $result3=mysqli_query($connection, $query3);
                            $row3=mysqli_fetch_assoc($result3);
            
                            $userID=$row['UserID'];
                            $query4="SELECT UserFirstname, UserSurname FROM LUUsers WHERE UserID='$userID' ";
                            $result4=mysqli_query($connection, $query4);
                            $row4=mysqli_fetch_assoc($result4);
            
                            echo '<tr><td>'.$row4['UserFirstname']." ".$row4['UserSurname'].'</td><td>'.$row2['ServiceName'].'</td><td>'.$row3['WalkerName'].'</td><td>'.$row['BookingDate'].'</td><td>'.$row['ServiceDate'].'</td><td>'.$row['ServiceTime'].'</td><td>'.$row['EndDate'].'</td><td>'.$row['PetName'].'</td><td>'.$row['UserComment'].'</td><td>'.$row['PaymentMethod'].'</td><td>'.$row['Amount'].'</td><td><a href="editBooking.php?id='. $row['BookingID'].'">Allocate Dog Walker</a></td><td><a href="cancelBooking.php?id='. $row['BookingID'].'">Cancel Booking</a></td></tr>';
                        }
                        echo '</table>';
                ?>

            </section>
        </div>

        <footer>
            <p>All Rights Reserved Leads United</p>
            <a href="https://www.instagram.com/leadsunited2020/"><img alt="Instagram" src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAADIAAAAyCAYAAAAeP4ixAAAABmJLR0QA/wD/AP+gvaeTAAADx0lEQVRoge2au08UURTGD8YHBhDXErREMBY+wE4xJppITAAbW0Ji+A9QqX20BEIpobdQoxWs7w6tVUALZYlWugYEKvlZzLnZEZmde+/cWRq+ZDKb2XO+8525Z+5rRmQHO8gFdS7GQLuI9IvIJRFpFZEjItIQSMuqiJREZElEiiLyuK6ubiEQdwSgC3hO7fEM6AyRwB5gAthQ4h/AfaAXaAdCtYYADcrZB0xqLDT2OLDbl7gAvFCyVeA2cCCUcIv4B4A7wFqsdQ66kuyhUkpLQFdOem20nAC+qJbXwF4X5wl1XARactRpq6cFKKmmMVunLq3LVeBUzhqtAZzWMvsDnLZxMCV1uwb6nADcVW3FNMP2WO9Uswc7Fv+KPpMloGeL/5uBn6qxrRrRTTWazFVxcnzzHAAsJthM6f/D8eu7Ntld1POTPIQGgtF2KdECmNdsj/pG0fFnEHgMzAG/9ZgDHul/hQTfHm2VReBygo0p/7lqIpbVqMkjgf3ACPCLdJSBW0C9R5wm5ViuZgSAB3kL8C4mdBq4rnevQY8OvTYTs3uLxziVqtMnEU1i0TQ3cNbC5xyVMnYedIMnouVkWuIlDnMhomfplfrOupRZHomMqMtHlyRi/oVYy9x08AuXiIowD3ZqOVXhOa8cZRJ6M2edjokMqvm0peZqXEXlGrC0/0/n5gHRBb16fpCBw8Bw9Fa1soVji5jabg8Qt0O5kge5f+2DltaKmjda6q3G1ahcK5b2QUsrJIyOjawEPvim59YMHAZmQPzuS5AlkQ96PpeBw6Bbz+99CbIkYqbT1zJwGBiOMMsHjwGxrC7d6R6JPBdiA6LV7CBor6X2Zooybzsqb/IvAAvKMZzuYanTI5F6oqk4RBNA62SAQ8Ab9d3eSaP6xKfxC8B5C58LwCf12f5pfMyvRe+qQREYAo4RDXaN+nuIaOvTYNY1CdtEsix164l2YcqkowzcAPZ5xLFa6obYfDgIDAAPidYpK3p81GsDeKxdYvxWmw9mOt3nGyhvAFdV4z/Lh80DotmKDDOdzgfmJs8kWrDNW6ZpwHbLVI1Nr3KnRvqsAdzbqqySjDuJXiusYbN9XyMQve5YJ3qtcNLWaVwzLwEhpumZALRS2eAedXHcHSuxJeBMjjrTtJwEvqqWIq4vRXU8MMmsEb1kac5J71bxm/WZWFcNM97jj7bMmNYl2mNMAf1EGwaZ1+uxWI3KeVVjmN7pDzDq3BIJQY4DT6k9ilh2OK6fcLRJ5ROOIyJyWERCtcpviT7hKEnlE47Pgbh3sANf/AXz7u+5M19CfgAAAABJRU5ErkJggg==" height="30" width="30"> </a>
            <a href="https://twitter.com/united_leads"><img alt="Twitter" src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAADIAAAAyCAYAAAAeP4ixAAAABmJLR0QA/wD/AP+gvaeTAAAD3ElEQVRoge2ZS2gdVRjHf19S2kZM1VqqLVqrBaUJoqW4srpQS3HhwgfqQiHSlVgqCFYXFUHURXUj1oWgoKsaVMSFWiTtwkd91SIUSwo+EG2NFkNIWtM2TX4u5iYO986d3MdMIpgfXJh7zrnn+//vecycb2CBBRb4XxDzLUBdB6wDVgCjwG/A4YiYnFdhjaB2q0+pR83mT/XVism8fi5Vb8yquLY09f/GuFP9o46Bak6rz6qdVX2sVXer4+qG6gCr1FPq/SWa2KFONWgizXvqJvVJ9TN1slL+dlaQxyqVZ9TNJZh4sAUDeRxXV2YF+jDV6LR6T4Em1qh/F2jihNpb6ft8dUtHKl5P6noJ0K9uL8jLM0BXQX19BzwC3KTuAYZI777qSB33b6kXtBpVXVYZ4aKYrPr+eHXAoZwf/6Te0qKRews0Uc2u6TjpqfVzjp4rgX3qO+raJr30Ntm+EQR2RsSO6YK0kc8b6OBuYFB9zcpia4BVTQhshHPAXRHxXGatekOTwzqlfqw+pC6vF1V9uci5pI5mxVk0fRER36j7gUbXQgCbK58J9VPgAPA1cAg4HhECvzbYX6NM1RMzg9oDHKSYrfIs8DvJfF5bQH/THIuIy6oLOwDUAIiII8BW6rhuksXAFRRrApIn5BqmF3uneljdBgwADwDjBQsoil+yCmemlnqC5EwAybxeDFxSvq6meSUitlUXprffb1PXl/PfNAFwJKswbeSjORLSLgeyCtNT60KS+bdsrhS1wCiwPOsYPDMiETECPD+Xqlpgb72zfEfV9xeB/eXraZl361XUZFHUbpL1Unuon1/GgNURcTKrsnpEiIgx4FbgJYq5MRbFm/VMzIraq76hDhf84NcsU+o1eVoXZRWqG4E+YBj4C/iK5OGwM6v9HNAfEUfzGmRmGtUukrv7xWWoapIJoCcifshrVLNGACJiHHi6DFUtsHs2E5CT+zXJ7n0AbClSVZP8CFwXEadma5g5IgCVG899wBcFCmuGSWBrIyYaQu1SX7e1VGc7PFGIgQxDm9T31Yk5MNFv5bBXGiYJt9vVXdYmy4pgr7qkVBMVIx3qo+rJEkwMmGz9pRu4Q/2yBAOaPEGUNxLqavVhdbAkAxMWsLBDvZ4kZTMGdAMXkaRIN5LkuNa3GySH74G+iDjYdk/qSpPXWGdL+sezGFF3qkvb/y9qDV2t7jF5Y1WmgRfU8p/h1BXqdvVQQeLPqZ+ofep5ZenOvemo64HbgJuBDcBVs/2GJEEwSPJmaQDYFxHD7UvNp6m7p8kev4bkVUE3sBQ4Q7JRjAJDEXGsaJELLDCP/ANy4Cd5pzcP8AAAAABJRU5ErkJggg==" height="30" width="30"> </a>
            <a href="https://www.facebook.com/LeadsUnited2020/"><img alt="Facebook" src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAADIAAAAyCAYAAAAeP4ixAAAABmJLR0QA/wD/AP+gvaeTAAABbklEQVRoge2Zv0oDQRDGvxEbUSxt7HyE6BtYarBQ8Dn0FULAyhfRwsJK8M8DaGsptrbmEAvhswjCuVnD3VxudoT5lcPu7PdjcnshAYIgUEHygOQDyYrlqUjekxy2lTgrm3su41xmyU0CwJVujmYMReS6XljKLDoxCtOF07SQm8gEwJpJHD0TEVmvF3IitMujR0R+Zc99tP4lIeKNEOlIBWAEYIDpDbkKYAvAMYAbTcMSt9YrgF0ReflrQZMMpW+tLwBH8yS0WItcishTH42tRS76amwt8pgWSB6SfCb58fP1VtPY+mFfEZHP5Lw3ABttG6UPu6lIeniX80rfWr0RIk2QhIZrNjVneZzItmZTiPTIjmaTR5GBZtPyolPUSd8Ri3yPpHiciIoQ8UaIeCNEvBEi3ggRb+REKvMU7XlPCzmRmZ9sHDKTMSdybhCkK80ykhyb/NGsY9RKmeQ+yTuSk8LByWmGW5J7mvEFQQB8A7wTurytysqXAAAAAElFTkSuQmCC" height="30" width="30"> </a>
        </footer>
    </div>
</body>

</html>