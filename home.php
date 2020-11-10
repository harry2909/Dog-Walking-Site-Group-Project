<!DOCTYPE html>
<html>

<head>
    <link href="Stylesheet/stylesheet.css" rel="stylesheet" type="text/css" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://fonts.googleapis.com/css?family=Montserrat&display=swap" rel="stylesheet">
    <link rel="icon" href="images/leadsunited.ico" type="image/x-icon" />

    <title>Leads United</title>
</head>

<body>
    <div class="grid">
        <div class="logo"><img src="images/leadsunited.png" alt="Leads United Logo" /></div>
        <div class="navbar">
            <a href="home.php" class="active">Home</a></li>
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
        <div class="homeContainer">
            <section id="homeContent">

                <!-- Slideshow container -->
                <div class="slideshow-container">
                    <div class="slides">
                        <img src="images/dogWalk1.png?random=1" alt="slide image" class="slide">
                        <img src="images/dogWalk2.jpg?random=2" alt="slide image" class="slide">
                        <img src="images/dogWalk3.jpg?random=3" alt="slide image" class="slide">
                    </div>
                    <div class="controls">
                        <div class="control prev-slide">&#9668;</div>
                        <div class="control next-slide">&#9658;</div>
                    </div>
            </section>
            </div>

            <script>
                const delay = 3000; //ms

                const slides = document.querySelector(".slides");
                const slidesCount = slides.childElementCount;
                const maxLeft = (slidesCount - 1) * 100 * -1;

                let current = 0;

                function changeSlide(next = true) {
                    if (next) {
                        current += current > maxLeft ? -100 : current * -1;
                    } else {
                        current = current < 0 ? current + 100 : maxLeft;
                    }

                    slides.style.left = current + "%";
                }

                let autoChange = setInterval(changeSlide, delay);
                const restart = function() {
                    clearInterval(autoChange);
                    autoChange = setInterval(changeSlide, delay);
                };

                // Controls
                document.querySelector(".next-slide").addEventListener("click", function() {
                    changeSlide();
                    restart();
                });

                document.querySelector(".prev-slide").addEventListener("click", function() {
                    changeSlide(false);
                    restart();
                });
            </script>

            <div class="homeContainer2">
                <section id="homeContent">
                    <h2> About us<h2>
  <p>Leads United are a community where dog owners can find dog walkers who are flexible, local to your area, and have been quality checked by our team to ensure a fabulous walking experience.<p>
  <br>
  <p>We have created this site with our customers in mind. As such, you will find excellent services, including a rating system for our walkers, a paw-some gallery, and an easy to understand tarrif!<p>
  <br>
  <p>Visit our "services" section to get started!<p>
  </section>
  </div>
  <div class = "homeWrapper"> 
  <h2>Top Walkers</h2>
                    <content>
                        <?php
                            include 'connection.php';
                            //Selects the top 3 rated walkers from LUProfiles Table
                            $query="SELECT WalkerName, WalkerImg , WalkerBio, WalkerRating FROM LUProfiles ORDER BY WalkerRating DESC LIMIT 0,3";
                            $result=mysqli_query($connection, $query);
                            //Loops through each profile and creates profile card
                            while($row=mysqli_fetch_assoc($result)){
                        ?>
                            <div class="card-conatiner">
                                <div class="card">
                                    <div class="avatar">
                                        <?php 
                                            //Gets Image
                                            session_start();
                                            echo '<img src="profilePictures/'.$row['WalkerImg'].'" class= "profilePictures"/>'; 
                                            ?>
                                    </div>
                                    <div class="rating">
                                        <?php
                                            //Gets rating
                                            session_start();
                                            echo $row['WalkerRating'];
                                            echo '<img src="images/260px-Five_Pointed_Star_Solid.svg.png"/>';
                                        ?>
                                    </div>
                                    <div class="name">
                                        <?php
                                            //Gets Walker name
                                            session_start();
                                            echo $row['WalkerName'];
                                        ?>
                                    </div>
                                    <div class="bio">
                                        <?php
                                            // Gets walker bio
                                            session_start();
                                            echo $row['WalkerBio'];
                                        ?>
                                    </div>
                                </div>
                            </div>
                            <?php 
                                //Ends while loop
                                } 
                            ?>
                    </content>
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