<!DOCTYPE html>
<html>
<head>
    <title>Fuel cell perusal</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="HandheldFriendly" content="true">   
    <!--bootstrap links-->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>    
    <link rel="stylesheet" href="styles.css">
    <link rel="icon" type="image/jpg" sizes="32x32" href="Images/fcp_logo.jpg">
    <script src='https://kit.fontawesome.com/a076d05399.js'></script>
</head>
<body class="body-index">
    <header>
        <div id="top">
            <img height = "10%"width = "100%" src="/Images/title_bg1.png">
        </div>
    </header>
        <nav id="head">
            <div class="navbar navbar-expand-md bg-dark navbar-dark" id="navigator">
                    <!--navbar name-->
                <!-- Toggler/collapsibe Button -->
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#collapsibleNavbar">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <!-- Navbar links -->
                <div class="collapse navbar-collapse" id="collapsibleNavbar">
                    <ul class="navbar-nav">
                        <li class="nav-item">
                            <a class="nav-link active" href="index.php"><i class='fas fa-home'></i> Home</a>     
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="fuelcells.html">Fuel cell fundamentals</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="project.html">Model descriptions</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="simulations.html">Simulations</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="archive.html">Archives</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="contactus.html">The Team</a>
                        </li>                               
                    </ul>
                </div>
            </div>
        </nav> 
        <div class='container-fluid'>
           
           <marquee style ="font-size: 21px;" behavior = "scroll" direction = "left"><strong>Running Versions [v1.1.1] and [v2.2.1]  ||					   Previous versions can be accessed from Archives</strong></marquee>
        </div>

    <div class="container" id="super">
        <h1 class="title-text">What have I stumbled upon?</h1> <br> <br>
        <h5 class="body-text">
            <u>Fuel Cell Perusal</u> is a website that educates the user on the importance of the renewable and clean source of energy - fuel cells. This website allows the user to simulate and compare various models of the PEMFC online. It helps the user improve their understanding of fuel cells and also learn about the various parameters that affect its operation.
        </h5>    <br><br><br><br><br><br><br><br>            
    </div>

    <footer class="footer">
        <br>
        <h4 class = footer-info> 
            <img width ="20%" height ="25%" style="opacity: 0.7;" src="/Images/fcp_logo.png">Fuel Cell Perusal 
            <br> <br> <br>
        </h4>
         <h4 class="footer-contact"><br><br>
            Contact us : 
            <br> 
            <img height="3%" width="6%"src="/Images/email.png"> team.fuelcell.perusal@gmail.com 
            <br>    
            <img height="7%" width="6%"src="/Images/phone.png"> +91 9738465015
        </h4>
        <h4 class="visitor"> <br><br>
        Visitor count : <img src="Counter_images/counter.png" border="0" alt="web counter">
        <?php
        $handle = fopen("counter.txt", "r"); 
            if(!$handle){ 
                echo "could not open the file" ; 
            } 
            else { 
                $counter = (int ) fread ($handle,20); 
                fclose ($handle); 
                $counter++; 
                $handle = fopen("counter.txt", "w" ); 
                fwrite($handle,$counter) ; 
                fclose ($handle) ; 
            } 
        function convertEmailToImg ($aValue, $aRed, $aGreen, $aBlue, $aAlphaF=0, $aAlphaB=127, $aFontSize=4)

        {
            $img= imagecreatetruecolor (imagefontwidth ($aFontSize) * strlen ($aValue), imagefontheight ($aFontSize));
            imagesavealpha ($img, true);
            imagefill ($img, 0, 0, imagecolorallocatealpha ($img, 0, 0, 0, $aAlphaB));
            imagestring ($img, $aFontSize, 0, 0, $aValue, imagecolorallocatealpha ($img, $aRed, $aGreen, $aBlue, $aAlphaF));
            ob_start ();
            imagepng ($img);
            imagedestroy ($img);
            return base64_encode (ob_get_clean ());
        }
        $imgString= convertEmailToImg ($counter, 255, 255, 255, 0, 127, 4);
        $data = base64_decode($imgString);

        file_put_contents('Counter_images/'."counter".'.png', $data);
        ?>
                
            </h4>
       
    </footer>
</body>

</html>