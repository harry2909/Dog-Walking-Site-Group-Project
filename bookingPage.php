<!DOCTYPE html>
<html>
  <head>
  <link href="Stylesheet/stylesheet.css" rel="stylesheet" type="text/css" />
  <link href="https://fonts.googleapis.com/css?family=Montserrat&display=swap" rel="stylesheet"> 
    <link href="Stylesheet/stylesheet.css" rel="stylesheet" type="text/css" />
    <title>Leads United</title>
    <link rel="icon" href="images/leadsunited.ico" type="image/x-icon"/>
  </head>
  <body>
    <div class="grid">
<div class="logo"><img src="images/leadsunited.png"  alt="Leads United Logo" /></div>                
        <div class="navbar">
        <a href="home.php" >Home</a></li>
        <a href="services.php" class="active">Services</a>
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
          <?php
                session_start();
                if(!isset($_SESSION['user'])){
                header ('location: login.php');
                }
                //include init.php
                include 'connection.php';
                //Gather details submitted from the $_POST array and store in local vars
                $UserID=$_SESSION['userID'];
                $ServiceID=$_POST['Service'];
                $BookingDate=date("Y-m-d");
                $ServiceDate=$_POST['serviceDate'];
                $ServiceTime=$_POST['serviceTime'];
                $PetName=$_POST['txtPetName'];
                $Comment=$_POST['txtOther'];
                $PaymentMethod=$_POST['Payment'];
                //Resets Variables
                $petnameErr="";
                $dateErr="";
                
                if ($_SERVER["REQUEST_METHOD"] == "POST") {
                    //Validation
                    if(empty($_POST['txtPetName'])){
                        $petnameErr="Please enter your pets name";
                    }
                    if($BookingDate>$ServiceDate){
                        $dateErr="Date of service cannot be in the past";
                    }
                    if ($ServiceDate==""){
                        $dateErr="Please select a date";
                    }   
                }
        ?>
        <div class="container">
        <section id="content">
        <h3>Book Service:</h3>
        <form method="POST" action="bookingPage.php" align="left" autocomplete="off">           
                <p><label>Pet Name: </label><br /><input type="text" name="txtPetName"  value="<?php echo $PetName;?>" align="left"/><span class="error"> <?php echo $petnameErr;?></span></p>                         
                <p><label>Service Type: </label><br />
                <select name="Service" align="left" value="<?php echo $ServiceID;?>">
            <option value="1"<?php if ( $_POST['Service'] == '1'){ echo 'selected="selected"';} ?>>One to One Walk, 30 mins</option>
            <option value="2"<?php if ( $_POST['Service'] == '2'){ echo 'selected="selected"';} ?>>One to One Walk, 1 hour</option>
            <option value="3"<?php if ( $_POST['Service'] == '3'){ echo 'selected="selected"';} ?>>Group Walk, 1 Hour</option>
            <option value="4"<?php if ( $_POST['Service'] == '4'){ echo 'selected="selected"';} ?>>Group Walk x2, 1 Hour</option>
            <option value="5"<?php if ( $_POST['Service'] == '5'){ echo 'selected="selected"';} ?>>Morning Visit</option>
            <option value="6"<?php if ( $_POST['Service'] == '6'){ echo 'selected="selected"';} ?>>Afternoon Visit</option>
            <option value="7"<?php if ( $_POST['Service'] == '7'){ echo 'selected="selected"';} ?>>Evening Visit</option>
            <option value="8"<?php if ( $_POST['Service'] == '8'){ echo 'selected="selected"';} ?>>5 Day Visit Package</option>
            <option value="9"<?php if ( $_POST['Service'] == '9'){ echo 'selected="selected"';} ?>>5 Evening Visit Package</option>
            <option value="10"<?php if ( $_POST['Service'] == '10'){ echo 'selected="selected"';} ?>>Day Care</option>
            <option value="11"<?php if ( $_POST['Service'] == '11'){ echo 'selected="selected"';} ?>>Day Care and Overnight Stay</option>
            <option value="12"<?php if ( $_POST['Service'] == '12'){ echo 'selected="selected"';} ?>>One Week Holiday Package</option>
            <option value="13"<?php if ( $_POST['Service'] == '13'){ echo 'selected="selected"';} ?>>Two Week Holiday Package</option>
            <option value="14"<?php if ( $_POST['Service'] == '14'){ echo 'selected="selected"';} ?>>Puppy Visit</option>
    </select></p>
                                       
                <p><label>Date: </label><br /><input type="date" name="serviceDate" value="<?php echo $ServiceDate;?>" align="left"/> <span class="error"> <?php echo $dateErr;?></span></p>               
                <p><label>Time: </label><br />
                <select name="serviceTime"align="left" >
                <option value="Morning" <?php if ( $_POST['serviceTime'] == 'Morning'){ echo 'selected="selected"';} ?> > Morning (08:00-11:00)</option>
                <option value="Afternoon" <?php if ( $_POST['serviceTime'] == 'Afternoon'){ echo 'selected="selected"';} ?> > Afternoon (13:00-16:00)</option>
                <option value="Evening" <?php if ( $_POST['serviceTime'] == 'Evening'){ echo 'selected="selected"';} ?> >Evening (18:00-21:00)</option>
                </select></p>             
                <p><label>Payment method: </label><br />
                <select name="Payment" align="left" value "<?php echo $PaymentMethod;?>">
                <option value="invoice"<?php if ( $_POST['Payment'] == 'invoice'){ echo 'selected="selected"';} ?>> Invoice</option>
                <option value="paypal"<?php if ( $_POST['Payment'] == 'paypal'){ echo 'selected="selected"';} ?>> Paypal</option>
                </select></p> 
                <p><label>Other information e.g. breed: </label><br /><input type="text" name="txtOther" value="<?php echo $Comment;?>"align="left"/></p>  
                <input type="submit" value="Book" name="submit" align="left" class="reg"/><br />
                <input type="submit" value="Clear" name="clear" align="left" class="reg" /><br />
        </form>
        <?php
            if(isset($_POST['submit'])){
                $query="SELECT ServicePrice FROM LUServices WHERE ServiceID= '$ServiceID'";
                $result=mysqli_query($connection, $query);
                while($row=mysqli_fetch_assoc($result)){
                $Amount=$row['ServicePrice'];
                }
                $EndDate=$ServiceDate;
                //Changes the end date depending on which service is selected
                if($ServiceID==8 || $ServiceID==9){
                    $EndDate=date('Y-m-d', strtotime($EndDate. ' + 4 days'));
                }
                if($ServiceID==11){
                $EndDate=date('Y-m-d', strtotime($EndDate. ' + 1 days'));
                }
                if($ServiceID==12){
                    $EndDate=date('Y-m-d', strtotime($EndDate. ' + 7 days'));
                }
                if($ServiceID==13){
                    $EndDate=date('Y-m-d', strtotime($EndDate. ' + 14 days'));
                }
                //Checks validation
                if($petnameErr=="" && $dateErr==""){
                    //Updates MYSQL
                    $query="INSERT INTO LUBookings (UserID, ServiceID, ProfileID, BookingDate,ServiceDate, EndDate, ServiceTime, PetName, UserComment, PaymentMethod, Amount,BookingRating) VALUES ('$UserID','$ServiceID',0,'$BookingDate','$ServiceDate','$EndDate','$ServiceTime','$PetName','$Comment','$PaymentMethod',$Amount,0)";
                    mysqli_query($connection, $query);
                    
                    //Updates APEX
                    require 'oci_connect_zeus.php';
                    $BookingDate=date('m-d-Y', strtotime($BookingDate));
                    $ServiceDate=date('m-d-Y', strtotime($ServiceDate));
                    $EndDate=date('m-d-Y', strtotime($EndDate)); 
                    $query_str1="INSERT INTO LUBOOKINGS (BOOKINGID,USERID, SERVICEID, PROFILEID, BOOKINGDATE,SERVICEDATE, ENDDATE, SERVICETIME, PETNAME, USERCOMMENT, PAYMENTMETHOD, AMOUNT,BOOKINGRATING) VALUES (SEQ_BOOKING.nextval,$UserID,$ServiceID,0,TO_DATE('$BookingDate','MM-DD-YYYY'),TO_DATE('$ServiceDate','MM-DD-YYYY'),TO_DATE('$EndDate','MM-DD-YYYY'),'$ServiceTime','$PetName','$Comment','$PaymentMethod',$Amount,0)";
                    $stid = oci_parse($connection2,$query_str1);   
                    oci_execute($stid);
    
                    $_SESSION['Booking']= "BOOKING COMPLETE:  Booking Date:  '$BookingDate'  Start date: '$ServiceDate'  End date: '$EndDate'  Service Time: '$ServiceTime'  Pet Name: '$PetName'  Comments: '$Comment'  Payment Method: '$PaymentMethod'  Amount: '$Amount' ";
                    header('location: services.php');//sends the user back to services page
                }
        }
        if(isset($_POST['clear'])){
            header ('location: bookingPage.php');
        }
    ?>
        </section>
        </div>
    <footer>
			<p>All Rights Reserved Leads United</p>
			<a href="https://www.instagram.com/leadsunited2020/"><img alt="Instagram" src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAADIAAAAyCAYAAAAeP4ixAAAABmJLR0QA/wD/AP+gvaeTAAADx0lEQVRoge2au08UURTGD8YHBhDXErREMBY+wE4xJppITAAbW0Ji+A9QqX20BEIpobdQoxWs7w6tVUALZYlWugYEKvlZzLnZEZmde+/cWRq+ZDKb2XO+8525Z+5rRmQHO8gFdS7GQLuI9IvIJRFpFZEjItIQSMuqiJREZElEiiLyuK6ubiEQdwSgC3hO7fEM6AyRwB5gAthQ4h/AfaAXaAdCtYYADcrZB0xqLDT2OLDbl7gAvFCyVeA2cCCUcIv4B4A7wFqsdQ66kuyhUkpLQFdOem20nAC+qJbXwF4X5wl1XARactRpq6cFKKmmMVunLq3LVeBUzhqtAZzWMvsDnLZxMCV1uwb6nADcVW3FNMP2WO9Uswc7Fv+KPpMloGeL/5uBn6qxrRrRTTWazFVxcnzzHAAsJthM6f/D8eu7Ntld1POTPIQGgtF2KdECmNdsj/pG0fFnEHgMzAG/9ZgDHul/hQTfHm2VReBygo0p/7lqIpbVqMkjgf3ACPCLdJSBW0C9R5wm5ViuZgSAB3kL8C4mdBq4rnevQY8OvTYTs3uLxziVqtMnEU1i0TQ3cNbC5xyVMnYedIMnouVkWuIlDnMhomfplfrOupRZHomMqMtHlyRi/oVYy9x08AuXiIowD3ZqOVXhOa8cZRJ6M2edjokMqvm0peZqXEXlGrC0/0/n5gHRBb16fpCBw8Bw9Fa1soVji5jabg8Qt0O5kge5f+2DltaKmjda6q3G1ahcK5b2QUsrJIyOjawEPvim59YMHAZmQPzuS5AlkQ96PpeBw6Bbz+99CbIkYqbT1zJwGBiOMMsHjwGxrC7d6R6JPBdiA6LV7CBor6X2Zooybzsqb/IvAAvKMZzuYanTI5F6oqk4RBNA62SAQ8Ab9d3eSaP6xKfxC8B5C58LwCf12f5pfMyvRe+qQREYAo4RDXaN+nuIaOvTYNY1CdtEsix164l2YcqkowzcAPZ5xLFa6obYfDgIDAAPidYpK3p81GsDeKxdYvxWmw9mOt3nGyhvAFdV4z/Lh80DotmKDDOdzgfmJs8kWrDNW6ZpwHbLVI1Nr3KnRvqsAdzbqqySjDuJXiusYbN9XyMQve5YJ3qtcNLWaVwzLwEhpumZALRS2eAedXHcHSuxJeBMjjrTtJwEvqqWIq4vRXU8MMmsEb1kac5J71bxm/WZWFcNM97jj7bMmNYl2mNMAf1EGwaZ1+uxWI3KeVVjmN7pDzDq3BIJQY4DT6k9ilh2OK6fcLRJ5ROOIyJyWERCtcpviT7hKEnlE47Pgbh3sANf/AXz7u+5M19CfgAAAABJRU5ErkJggg=="height="30" width="30"> </a>
            <a href="https://twitter.com/united_leads"><img alt="Twitter" src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAADIAAAAyCAYAAAAeP4ixAAAABmJLR0QA/wD/AP+gvaeTAAAD3ElEQVRoge2ZS2gdVRjHf19S2kZM1VqqLVqrBaUJoqW4srpQS3HhwgfqQiHSlVgqCFYXFUHURXUj1oWgoKsaVMSFWiTtwkd91SIUSwo+EG2NFkNIWtM2TX4u5iYO986d3MdMIpgfXJh7zrnn+//vecycb2CBBRb4XxDzLUBdB6wDVgCjwG/A4YiYnFdhjaB2q0+pR83mT/XVism8fi5Vb8yquLY09f/GuFP9o46Bak6rz6qdVX2sVXer4+qG6gCr1FPq/SWa2KFONWgizXvqJvVJ9TN1slL+dlaQxyqVZ9TNJZh4sAUDeRxXV2YF+jDV6LR6T4Em1qh/F2jihNpb6ft8dUtHKl5P6noJ0K9uL8jLM0BXQX19BzwC3KTuAYZI777qSB33b6kXtBpVXVYZ4aKYrPr+eHXAoZwf/6Te0qKRews0Uc2u6TjpqfVzjp4rgX3qO+raJr30Ntm+EQR2RsSO6YK0kc8b6OBuYFB9zcpia4BVTQhshHPAXRHxXGatekOTwzqlfqw+pC6vF1V9uci5pI5mxVk0fRER36j7gUbXQgCbK58J9VPgAPA1cAg4HhECvzbYX6NM1RMzg9oDHKSYrfIs8DvJfF5bQH/THIuIy6oLOwDUAIiII8BW6rhuksXAFRRrApIn5BqmF3uneljdBgwADwDjBQsoil+yCmemlnqC5EwAybxeDFxSvq6meSUitlUXprffb1PXl/PfNAFwJKswbeSjORLSLgeyCtNT60KS+bdsrhS1wCiwPOsYPDMiETECPD+Xqlpgb72zfEfV9xeB/eXraZl361XUZFHUbpL1Unuon1/GgNURcTKrsnpEiIgx4FbgJYq5MRbFm/VMzIraq76hDhf84NcsU+o1eVoXZRWqG4E+YBj4C/iK5OGwM6v9HNAfEUfzGmRmGtUukrv7xWWoapIJoCcifshrVLNGACJiHHi6DFUtsHs2E5CT+zXJ7n0AbClSVZP8CFwXEadma5g5IgCVG899wBcFCmuGSWBrIyYaQu1SX7e1VGc7PFGIgQxDm9T31Yk5MNFv5bBXGiYJt9vVXdYmy4pgr7qkVBMVIx3qo+rJEkwMmGz9pRu4Q/2yBAOaPEGUNxLqavVhdbAkAxMWsLBDvZ4kZTMGdAMXkaRIN5LkuNa3GySH74G+iDjYdk/qSpPXWGdL+sezGFF3qkvb/y9qDV2t7jF5Y1WmgRfU8p/h1BXqdvVQQeLPqZ+ofep5ZenOvemo64HbgJuBDcBVs/2GJEEwSPJmaQDYFxHD7UvNp6m7p8kev4bkVUE3sBQ4Q7JRjAJDEXGsaJELLDCP/ANy4Cd5pzcP8AAAAABJRU5ErkJggg=="height="30" width="30"> </a> 
            <a href="https://www.facebook.com/LeadsUnited2020/"><img alt="Facebook" src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAADIAAAAyCAYAAAAeP4ixAAAABmJLR0QA/wD/AP+gvaeTAAABbklEQVRoge2Zv0oDQRDGvxEbUSxt7HyE6BtYarBQ8Dn0FULAyhfRwsJK8M8DaGsptrbmEAvhswjCuVnD3VxudoT5lcPu7PdjcnshAYIgUEHygOQDyYrlqUjekxy2lTgrm3su41xmyU0CwJVujmYMReS6XljKLDoxCtOF07SQm8gEwJpJHD0TEVmvF3IitMujR0R+Zc99tP4lIeKNEOlIBWAEYIDpDbkKYAvAMYAbTcMSt9YrgF0ReflrQZMMpW+tLwBH8yS0WItcishTH42tRS76amwt8pgWSB6SfCb58fP1VtPY+mFfEZHP5Lw3ABttG6UPu6lIeniX80rfWr0RIk2QhIZrNjVneZzItmZTiPTIjmaTR5GBZtPyolPUSd8Ri3yPpHiciIoQ8UaIeCNEvBEi3ggRb+REKvMU7XlPCzmRmZ9sHDKTMSdybhCkK80ykhyb/NGsY9RKmeQ+yTuSk8LByWmGW5J7mvEFQQB8A7wTurytysqXAAAAAElFTkSuQmCC"height="30" width="30"> </a>
        </footer>	
		</div>
  </body>
</html>