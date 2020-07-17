<?php
session_start();
$i0= $_SESSION['i0'];
$gibbs= $_SESSION['gibbs'];
$s=$_SESSION['s'];
$Enernst=$_SESSION['Enernst'];
$Rohmic=$_SESSION['Rohmic'];
$NA=$_SESSION['NA'];
$_SESSION['nact'] = array();
$_SESSION['nconc'] = array();
$_SESSION['vfuel'] =array();
$_SESSION['nohm'] = array();
$_SESSION['i'] = array();
?>
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
                            <a class="nav-link" href="../index.php"><i class='fas fa-home'></i> Home</a>     
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="../fuelcells.html">Fuel cell fundamentals</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="../project.html">Model descriptions</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link active" href="../simulations.html">Simulations</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="../archive.html">Archives</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="../contactus.html">The Team</a>
                        </li>                               
                    </ul>
                </div>
            </div>
        </nav> 
		<!-- Sidebar -->
		<!-- <div class="sidebar">
            <a class="sidebar-item" href="model1.html" style="color:green;">Input</a> <br>
            <a href="#"  style="color:green;">Output</a> <br>
            <a href="#">Detailed values</a> <br>
            <a href="#">Download pdf report</a> <br>
    	</div> -->
	<div class="container" id="superbody"> <!--holds both blocks-->
    <div class="container" id="mainbody"> <!--block_1(formulae)-->
	<main>
		<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>

		<form align="center" action="v1.0.1.report.php" target="_blank" method="POST">
			<br>
			<p style="font-weight: 600; text-align: center;"> The values you have entered are : </p>
				<table class="my-special-table" border="4" bordercolor=white align="center">
					<tr style="font-weight: 700;">
						<td class="first-column"> Quantity </td>
						<td class="second-column"> Value </td>
						<td> Units </td>
					</tr> <br>
					<tr>
						<td class="first-column">Ideal gas constant (R) : </td>
						<td class="second-column"> <input class="constant-values" type="number" name="R" value = "<?php echo $R = $_POST["R"] ?>" readonly></td>
						<td> J/(mol K)</td>
					</tr>
					<tr>
						<td class="first-column">Faraday's constant (F) : </td>
						<td class="second-column"><input class="constant-values" type="number" name="F" value = "<?php echo $F = $_POST["F"] ?>" readonly></td>
						<td> As/mol</td>
					</tr>
					<tr>
						<td class="first-column">Number of moving electrons (z) : </td>
						<td class="second-column"><input class="constant-values" type="number" name="z" value = "<?php echo $z = $_POST["z"] ?>" readonly></td>
						<td> --- </td>
					</tr>
					<tr>
						<td class="first-column">Temperature (T) : </td>
						<td class="second-column"><input class="table-values" type="number" name="T" value = "<?php echo $T = $_POST["T"] ?>" readonly></td>
						<td> K </td>
					</tr>
					<tr>
						<td class="first-column">Charge transfer coefficient (alpha) : </td>
						<td class="second-column"><input class="table-values" type="number" name="alpha" value = "<?php echo $alpha = $_POST["alpha"] ?>" readonly></td>
						<td> --- </td>
					</tr>
					<tr>
						<td class="first-column">V1 : </td>
						<td class="second-column"><input class="table-values" type="number" name="V1" value = "<?php echo $V1 = $_POST["V1"] ?>"  readonly></td>
						<td> V </td>
					</tr>
					<tr>
						<td class="first-column">Vmin : </td>
						<td class="second-column"><input class="table-values" type="number" name="Vmin" value = "<?php echo $Vmin = $_POST["Vmin"] ?>"  readonly></td>
						<td> V </td>
					</tr>
					<tr>
						<td class="first-column">Vnom : </td>
						<td class="second-column"><input class="table-values" type="number" name="Vnom" value = "<?php echo $Vnom = $_POST["Vnom"] ?>"  readonly></td>
						<td> V </td>
					</tr>
					<tr>
						<td class="first-column">Imax : </td>
						<td class="second-column"><input class="table-values" type="number" name="Imax" value = "<?php echo $Imax = $_POST["Imax"] ?>"  readonly></td>
						<td> A </td>
					</tr>
					<tr>
						<td class="first-column">Inom : </td>
					 	<td class="second-column"><input class="table-values" type="number" name="Inom" value = "<?php echo $Inom = $_POST["Inom"] ?>"  readonly></td>
						<td> A </td>
					</tr>
					<tr>
						<td class="first-column">Eoc : </td>
						<td class="second-column"><input class="table-values" type="number" name="Eoc" value = "<?php echo $Eoc = $_POST["Eoc"] ?>"  readonly></td>
						<td> V </td>
					</tr>
					<tr>
						<td class="first-column">Pressure : </td>
						<td class="second-column"><input class="table-values" type="number" name="Pressure" value = "<?php echo $Pressure = $_POST["Pressure"] ?>"  readonly></td>
						<td> bar </td>
					</tr>
					<tr>
						<td class="first-column">Partial pressure of H2 (PH2) : </td>
						<td class="second-column"><input class="table-values" type="number" name="PH2" value = "<?php echo $PH2 = $_POST["PH2"] ?>"  readonly></td>
						<td> bar </td>
					</tr>
					<tr>
						<td class="first-column">Partial pressure of O2 (PO2) : </td>
						<td class="second-column"><input class="table-values" type="number" name="PO2" value = "<?php echo $PO2 = $_POST["PO2"] ?>"  readonly></td>
						<td> bar </td>
					</tr>
					<tr>
						<td class="first-column">Partial pressure of H2O (PH2O) : </td>
						<td class="second-column"><input class="table-values" type="number" name="PH20" value = "<?php echo $PH2O = $_POST["PH2O"] ?>"  readonly></td>
						<td> bar </td>
					</tr>
					<tr>
						<td class="first-column">Area: </td>
						<td class="second-column"><input class="table-values" type="number" name="A" value = "<?php echo $A = $_POST["A"] ?>"  readonly></td>
						<td> cm2 </td>
					</tr>
				</table> <br>
<p><?php
	$Enernst = 1.229 + ($T-298.15)*(-44.43/(192970))+($R*$T*log($PH2*$PO2)/(192970));
	$gibbs=-$Eoc*$z*$F-1;
	$gibbs= -1*$gibbs;
	$NA=((($V1-$Vnom)*($Imax-1))-(($V1-$Vmin)*($Inom-1)))/((log($Inom)*($Imax-1))-log($Imax)*($Inom-1));
	$Rohmic=($V1-$Vnom-$NA*log($Inom))/($Inom-1);
	$_SESSION['Ra']=$R;
	$i0=($R/($z*$F)*(1/$Rohmic))*$A;
	echo "The calculated Nernst voltage is : $Enernst V<br>";
	$nact = array();
	$nohm = array();
	$nconc = array();
	$Vfuel = array();
	$i = array();
	$j = 0;
	for($cur=0.05;$cur<1;$cur+=0.05)
	{
		$i[$j] = $cur;
		$nact[$j] = ($R*$T*log($i[$j]/$i0))/($z*$alpha*$F);
		$nohm[$j] = $cur*$Rohmic;
		$nconc[$j] = 2.11*exp(-5)*exp(0.08*$cur);
		$Vfuel[$j] = $Enernst - $nact[$j] - $nohm[$j] - $nconc[$j];
		$j+=1;
	}
	$s=$j-1;
	for ($b=0; $b<=$j-1; $b+=1)
	{
		$i[$b] = round($i[$b],5);
		$nact[$b] = round($nact[$b],5);
		$nohm[$b] = round($nohm[$b],5);
		$nconc[$b] = round($nconc[$b],5);
		$Vfuel[$b] = round($Vfuel[$b],5);
	}
  	echo '<table class="my-special-table" border="4" bordercolor=white align="center">';
    echo '<tr style="font-weight: 700;">';
    echo '<th> Fuel Cell Current: </th>';
    echo '<th> Activation Loss: </th>';
    echo '<th> Ohmic Loss: </th>';
    echo '<th> Concentration Loss: </th>';
	echo '<th> Fuel Cell Voltage: </th>';
	echo '</tr>';
	for ($b=0;$b<=$j;$b+=1) 
	{ 
	echo '<tr class="table-indent">';
	echo '<td>'.$i[$b].'</td>';
	echo '<td>'.$nact[$b].'</td>';
	echo '<td>'.$nohm[$b].'</td>';
	echo '<td>'.$nconc[$b].'</td>';
	echo '<td>'.$Vfuel[$b].'</td>';
	echo '</tr>';
	}
	echo '</table>';
	$_SESSION['Ra']=$R;
	$_SESSION['nact']=$nact;
	$_SESSION['nohm']=$nohm;
	$_SESSION['vfuel']=$Vfuel;
	$_SESSION['nconc']=$nconc;
	$_SESSION['i0']=$i0;
	$_SESSION['gibbs']=$gibbs;
	$_SESSION['s']=$s;
	$_SESSION['Enernst']=$Enernst;
	$_SESSION['Rohmic']=$Rohmic;
	$_SESSION['NA']=$NA;
	$_SESSION['i']=$i;

?></p>
<input id="subut" type="submit" value="Download PDF report">
</form> 
</main>
</div>
</div>
<footer class="footer">
        <br>
        <h4 class = footer-info> 
            <img width ="20%" height ="25%"src="/Images/fcp_logo.png">Fuel Cell Perusal 
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
            Visitor count : <img src="../Counter_images/counter.png" border="0" alt="web counter">
        </h4>
       
	</footer>
</body>
</html>
