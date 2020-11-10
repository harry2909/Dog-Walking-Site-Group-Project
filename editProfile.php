<?php
    include 'connection.php';
    //Gets the selected row from stats
    $id=$_GET['id'];
    $query="SELECT * FROM LUProfiles WHERE ProfileID='$id' ";
    $result=mysqli_query($connection, $query);
    $row=mysqli_fetch_assoc($result);
?>
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
            <?php
                session_start();
                include 'connection.php';
                //Initialises variables
                $id=$row['ProfileID'];
                $Imagename=$row['WalkerImg'];
                $Age=$row['WalkerAge'];
                $Bio=$row['WalkerBio'];
                //Resets variables
                $imageErr="";
                $ageErr="";
                $bioErr="";
                if ($_SERVER["REQUEST_METHOD"] == "POST") {
                    if(isset($_POST['submit'])){
                        //Gets data from POST[] and stores in variables
                        $id=$_POST['txtProfileID'];
                        $Imagename=$_POST['txtImagename'];
                        $Age=$_POST['txtAge'];
                        $Bio=$_POST['txtBio'];
            
                        //Validation
                        
                        if(empty($_POST['txtImagename'])){
                            $imageErr="Please enter the name of the image e.g 'Dog.jpg'";
                        }
        
                        if ( $Age<16){
                            $ageErr="You must be 16 to apply";
                        }
                        if (empty($_POST['txtAge'])){
                            $ageErr="Please enter your age";
                        }
                        if (empty($_POST['txtBio'])){
                            $bioErr="Please enter your bio";
                        }   
                    }
    
                }

            ?>
                <div class="container">
                    <section id="content">
                        <h3>Edit Profile:</h3>
                        <?php
                            if(isset($_POST["upload"])) {
                                //Gets data from POST[] and stores in variables
                                $Age=$_POST['txtAge'];
                                $Bio=$_POST['txtBio'];
                                $Imagename=$_POST['txtImagename'];
                                $id=$_POST['txtProfileID'];
                                session_start();
                                //Gets target folder for image upload
                                $target_dir = "./profilePictures/";
                                $target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
                                $uploadOk = 1;
                                $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
                                // Check if image file is an actual image 
                                if(isset($_POST["submit"])) {
                                    $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
                                    if($check !== false) {
                                        $_SESSION['uploadMessage']= $_SESSION['uploadMessage']. " File is an image - " . $check["mime"] . ".";
                                        $uploadOk = 1;
                                    } 
                                    else {
                                        $_SESSION['uploadMessage']= $_SESSION['uploadMessage']. " File is not an image.";
                                        $uploadOk = 0;
                                    }
                                }
                            // Check if file already exists
                            if (file_exists($target_file)) {
                                $_SESSION['uploadMessage']= $_SESSION['uploadMessage']. " Sorry, file already exists.";
                                $uploadOk = 0;
                            }
                            // Check file size
                            if ($_FILES["fileToUpload"]["size"] > 500000) {
                                $_SESSION['uploadMessage']= $_SESSION['uploadMessage']. " Sorry, your file is too large.";
                                $uploadOk = 0;
                            }
                            // Allow certain file formats
                            if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
                            && $imageFileType != "gif" ) {
                                $_SESSION['uploadMessage']=$_SESSION['uploadMessage']." Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
                                $uploadOk = 0;
                            }
                            // Check if $uploadOk is set to 0 by an error
                            if ($uploadOk == 0) {
                                $_SESSION['uploadMessage']= $_SESSION['uploadMessage']." Sorry, your file was not uploaded.";
                                // if everything is ok, try to upload file
                            } 
                            else {
                                if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
                                    $_SESSION['uploadMessage']= $_SESSION['uploadMessage']." The file ". basename( $_FILES["fileToUpload"]["name"]). " has been uploaded.";
                                } 
                                else {
                                    $_SESSION['uploadMessage']= $_SESSION['uploadMessage']." Sorry, there was an error uploading your file.";
                                }
                            }
                            $Age=$_POST['txtAge'];
                            $Bio=$_POST['txtBio'];
                            }

                        ?>
                            <form method="POST" action="editProfile.php" autocomplete="off" enctype="multipart/form-data">
                                <legend> If you want to use a new image for the table please select the file and press upload before inserting a new row.</legend>

                                <input type="file" name="fileToUpload">
                                <input type="submit" value="Upload Image" name="upload" class="upload">
                                    <?php
                                        echo'<br>';
                                        echo $_SESSION['uploadMessage'];
                                        $_SESSION['uploadMessage']='';
                                        echo '<br>';
                                        echo '<br>';
                                    ?>

                                    <p>
                                        <input type="hidden" name="txtProfileID" value="<?php  echo $id; ?>" align="left" />
                                    </p>
                                    <p>
                                        <label>Image name: </label>
                                        <br />
                                        <input type="text" name="txtImagename" value="<?php echo $Imagename;?>" align="left" /><span class="error"> <?php echo $imageErr;?></span></p>

                                    <p>
                                        <label>Age: </label>
                                        <br />
                                        <input type="text" name="txtAge" value="<?php echo $Age;?>" align="left" /><span class="error"> <?php echo $ageErr;?></span></p>
                                    <p>
                                        <label>Walker Bio </label>
                                        <br />
                                        <input type="text" name="txtBio" value="<?php echo $Bio;?>" minlength="10" maxlength="250" align="left" /><span class="error"> <?php echo $bioErr;?></span></p>
                                    <input type="submit" value="Update" name="submit" align="left" class="reg" />
                                    <br />
                                    <input type="submit" value="Cancel" name="cancel" align="left" class="reg" />
                                    <br />
                            </form>
                            <?php
                                include 'connection.php';
                                //sets a query that updates the row with the values of the variables
                                if(isset($_POST['submit'])){
                                    $ProfileID=$_POST['txtProfileID'];
                                    //Checks validation
                                    if($imageErr=="" && $ageErr=="" && $bioErr==""){
                                            //Updates MYSQL
                                            $query="UPDATE LUProfiles SET WalkerImg = '$Imagename', WalkerAge = '$Age', WalkerBio = '$Bio' WHERE ProfileID ='$ProfileID' ;";
                                            mysqli_query($connection, $query);//runs query
                                            
                                            //Updates APEX
                                            require 'oci_connect_zeus.php';
                                            $query_str="UPDATE LUPROFILES SET WALKERIMG = '$Imagename', WALKERAGE = '$Age', WALKERBIO = '$Bio' WHERE PROFILEID ='$ProfileID'";
                                            $stid = oci_parse($connection2,$query_str);   
                                            oci_execute($stid);
                                           
                                            $_SESSION['EditProfiles']=true;
                                            header( "Location: account.php") ;
                                    }

                                }
                                if(isset($_POST['cancel'])){
                                    header( 'Location: account.php' ) ;
                                }

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