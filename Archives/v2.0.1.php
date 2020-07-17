<?php
session_start();
$_SESSION['nact'] = array();
			$_SESSION['nconc'] = array();
			$_SESSION['vfuel'] =array();
			$_SESSION['Power'] = array();
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
    <div class="container" id="superbody"> 
	<div class="container" id="mainbody">
	<main>
		<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
		<form align="center" action="v2.0.1.report.php" target="_blank" method="POST">
		<form align="center">
		<br>
		<p style="font-size: large;"><strong> The values you have entered are : </strong></p>
			<table class="my-special-table" align="center" bordercolor="white" border="4">
				<tr style="font-weight: 700;">
							<td class="first-column"> Quantity </td>
							<td> Value </td>
							<td> Units </td>
						</tr> <br> 
						<tr>
							<td class="first-column">Ideal gas constant (R) : </td>
							<td class="second-column"><input class="constant-values" type="number" name="R" value = "<?php echo $R = $_POST["R"]?>" readonly></td>
							<td> J/(mol K)</td> 
						</tr>
						<tr>
							<td class="first-column">Faraday's constant (F) : </td>
							<td class="second-column"><input class="constant-values" type="number" name="F" value = "<?php echo $F = $_POST["F"]?>" readonly></td>
							<td> As/mol</td>
						</tr>
						<tr>
							<td class="first-column">Number of moving electrons (z) : </td>
							<td class="second-column"><input class="constant-values" type="number" name="z" value = "<?php echo $z = $_POST["z"]?>" readonly></td>
							<td> --- </td>
						</tr>
						<tr>
							<td class="first-column">Temperature (T) : </td>
							<td class="second-column"><input class="table-values" type="number" name="T" value = "<?php echo $T = $_POST["T"]?>" readonly></td>
							<td> K </td>
						</tr>
						<tr>
							<td class="first-column">Charge transfer coefficient (alpha) : </td>
							<td class="second-column"><input class="table-values" type="number" name="alpha" value = "<?php echo $alpha = $_POST["alpha"]?>"  readonly></td>
							<td> --- </td>
						</tr>	
						<tr>
							<td class="first-column">Exchange current (i0) : </td>
							<td class="second-column"><input class="table-values" type="number" name="i0" value = "<?php echo $i0 = $_POST["i0"]?>" readonly></td>
							<td> A/cm2 </td>
						</tr>
						<tr>
							<td class="first-column">Limiting current (iL) : </td>
							<td class="second-column"><input class="table-values" type="number" name="il" value = "<?php echo $il = $_POST["il"]?>" readonly></td>
							<td> A/cm2 </td>
						</tr>
						<tr>
							<td class="first-column">Internal resistance (Rohmic) : </td>
							<td class="second-column"><input class="table-values" type="number" name="Rohmic" value = "<?php echo $Rohmic = $_POST["Rohmic"]?>" readonly></td>
							<td> Ohm cm2 </td>
						</tr>
						<tr>
							<td class="first-column">Partial pressure of H2 (PH2) : </td>
							<td class="second-column"><input class="table-values" type="number" name="PH2" value = "<?php echo $PH2 = $_POST["PH2"]?>" readonly></td>
							<td> Bar </td>
						</tr>
						<tr>
							<td class="first-column">Partial pressure of O2 (PO2) : </td>
							<td class="second-column"><input class="table-values" type="number" name="PO2" value = "<?php echo $PO2 = $_POST["PO2"]?>" readonly></td>
							<td> Bar </td>
						</tr>
				</table>
				 <br>
<p><?php
			$Enernst = 1.229 + ($T-298.15)*(-44.43/($z*$F))+($R*$T*log($PH2*$PO2)/($z*$F));
			echo "The calculated Nernst voltage is : $Enernst V <br>";
			$nact = array();
			$nohm = array();
			$nconc = array();
			$Vfuel = array();
			$Power = array();
			$j = 0;
			for($cur=0.05;$cur<$il-0.05;$cur+=0.05)
			{
				$i[$j] = $cur;
				$nact[$j] = $R*$T*log($i[$j]/$i0)/($z*$alpha*$F);
				$nohm[$j] = $i[$j]*$Rohmic;
				$nconc[$j] = $R*$T*log($il/($il-$i[$j]))/($z*$F);
				$Vfuel[$j] = $Enernst - $nact[$j] - $nohm[$j] - $nconc[$j];
				$Power[$j] = $Vfuel[$j]*$i[$j];
				$j+=1;
			}
			for ($b=0; $b<=$j-1; $b+=1)
			{
				$i[$b] = round($i[$b],5);
				$nact[$b] = round($nact[$b],5);
				$nohm[$b] = round($nohm[$b],5);
				$nconc[$b] = round($nconc[$b],5);
				$Vfuel[$b] = round($Vfuel[$b],5);
				$Power[$b] = round($Power[$b],5);
			}
			echo '<table class="my-special-table" border="4" bordercolor="white"  align="center">';
    			echo '<tr>';
    				echo '<th> Fuel Cell Current: </th>';
    				echo '<th> Activation Loss: </th>';
    				echo '<th> Ohmic Loss: </th>';
    				echo '<th> Concentration Loss: </th>';
	    			echo '<th> Fuel Cell Voltage: </th>';
	    			echo '<th> Fuel Cell Power:  </th>';
	    		echo '</tr>';
	    		for ($b=0;$b<=$j-1;$b+=1) { 
	    			echo '<tr class="table-indent">';
	    				echo '<td>'.$i[$b]. '</td>';
	    				echo '<td>'.$nact[$b].'</td>';
	    				echo '<td>'.$nohm[$b].'</td>';
	    				echo '<td>'.$nconc[$b].'</td>';
	    				echo '<td>'.$Vfuel[$b].'</td>';
	    				echo '<td>'.$Power[$b].'</td>';
	    			echo '</tr>';
	    		}
	    	echo '</table>';
			$s=$j-1;
			$_SESSION['nact'] = $nact;
			$_SESSION['nconc'] = $nconc;
			$_SESSION['vfuel'] = $Vfuel;
			$_SESSION['Power'] = $Power;
			$_SESSION['nohm'] = $nohm;
			$_SESSION['i'] = $i;
			$_SESSION['s']=$s;
			$_SESSION['Enernst']=$Enernst;
			?></p>

<script type="text/javascript">
	var k = <?php echo json_encode($j);?>;
	var i = [];
	var nact = [];
	var nohm = [];
	var nconc = [];
	var Vfuel = [];
	var Power = [];
	i = <?php echo json_encode($i);?>;
	nact = <?php echo json_encode($nact);?>;
	nohm = <?php echo json_encode($nohm);?>;
	nconc = <?php echo json_encode($nconc);?>;
	Vfuel = <?php echo json_encode($Vfuel);?>;
	Power = <?php echo json_encode($Power);?>;

	google.charts.load('current', {'packages':['corechart']});

	// Set a callback to run when the Google Visualization API is loaded.
	google.charts.setOnLoadCallback(polarization);
	google.charts.setOnLoadCallback(power);
	google.charts.setOnLoadCallback(powerandpolarization);
	google.charts.setOnLoadCallback(everything);



	function polarization() {

		// Create the data table.
		var data = new google.visualization.DataTable();
		data.addColumn('number', 'Fuel cell current density (A/cm2)');
		data.addColumn('number', 'Fuel cell voltage (V)');
		for(var temp=0;temp<=k;temp++)
		{
			data.addRow([Number(i[temp]),Number(Vfuel[temp])]); //Adding the time vector and sine function arrays as a row in google charts
		}

	    // Set chart options
		var options = {'title':'Polarization curve',
						'width':1000,
						'height':500,
						'hAxis': {title : 'Fuel cell current density (A/cm2)'},
						'vAxis': {title : 'Fuel cell voltage (V)'}
					};

		// Instantiate and draw our chart, passing in some options.
		var chart = new google.visualization.LineChart(document.getElementById('polarization'));
		chart.draw(data, options);

		//To print image
		var my_div = document.getElementById('polarization');
		var chart = new google.visualization.LineChart(my_div);
		google.visualization.events.addListener(chart, 'ready', function () {
		      var app1=(chart.getImageURI());
		      $.post("1a.php",{postapp: app1},
		      function(){});
		    });

		chart.draw(data, options);
		}


	function power() {

		// Create the data table.
		var data = new google.visualization.DataTable();
		data.addColumn('number', 'Fuel cell current density (A/cm2)');
		data.addColumn('number', 'Power (W)');
		for(var temp=0;temp<=k;temp++)
		{
			data.addRow([Number(i[temp]),Number(Power[temp])]); //Adding the time vector and sine function arrays as a row in google charts
		}

	    // Set chart options
		var options = {'title':'Power output curve',
						'width':1000,
						'height':500,
						'hAxis': {title : 'Fuel cell current density (A/cm2)'},
						'vAxis': {title : 'Power output(W)'}};

		// Instantiate and draw our chart, passing in some options.
		var chart = new google.visualization.LineChart(document.getElementById('power'));
		chart.draw(data, options);

		//To print image
		google.visualization.events.addListener(chart, 'ready', function () {
		      var app1=(chart.getImageURI());
		      $.post("1b.php",{postapp: app1},
		      function(){});
		    });

		chart.draw(data, options);
		}


	function powerandpolarization() {

		// Create the data table.
		var data = new google.visualization.DataTable();
		data.addColumn('number', 'Fuel cell current density (A/cm2)');
		data.addColumn('number', 'Power (W)');
		data.addColumn('number', 'Fuel cell current density (A/cm2)');
		for(var temp=0;temp<=k;temp++)
		{
			data.addRow([Number(i[temp]),Number(Power[temp]),Number(Vfuel[temp])]); //Adding the time vector and sine function arrays as a row in google charts
		}

	    // Set chart options
		var options = {'title':'Polarization and power output curve',
						'width':1000,
						'height':500,
						'hAxis': {title : 'Fuel cell current density (A/cm2)'},
						'vAxis': {title : 'Fuel cell voltage (V)'}
					};

		// Instantiate and draw our chart, passing in some options.
		var chart = new google.visualization.LineChart(document.getElementById('powerandpolarization'));
		chart.draw(data, options);

		//To print image
		google.visualization.events.addListener(chart, 'ready', function () {
		      var app1=(chart.getImageURI());
		      $.post("1c.php",{postapp: app1},
		      function(){});
		    });

		chart.draw(data, options);
		}

	function everything() {

		// Create the data table.
		var data = new google.visualization.DataTable();
		data.addColumn('number', 'Fuel cell current density (A/cm2)');
		data.addColumn('number', 'Power (W)');
		data.addColumn('number', 'Voltage (V)');
		data.addColumn('number', 'Activation losses');
		data.addColumn('number', 'Ohmic losses');
		data.addColumn('number', 'Concentration losses');
		for(var temp=0;temp<=k;temp++)
		{
			data.addRow([Number(i[temp]),Number(Power[temp]),Number(Vfuel[temp]),Number(nact[temp]),Number(nohm[temp]),Number(nconc[temp])]); //Adding the time vector and sine function arrays as a row in google charts
		}

	    // Set chart options
		var options = {'title':'Losses, fuel cell voltage and power',
						'width':1000,
						'height':500,
					    'hAxis': {title : 'Fuel cell current density (A/cm2)'},
					    'vAxis': {title : 'Fuel cell voltage (V)'}
					};

		// Instantiate and draw our chart, passing in some options.
		var chart = new google.visualization.LineChart(document.getElementById('everything'));
		chart.draw(data, options);

		//To print image
		google.visualization.events.addListener(chart, 'ready', function () {
		      var app1=(chart.getImageURI());
		      $.post("1d.php",{postapp: app1},
		      function(){});
		    });

		chart.draw(data, options);
		}
	
</script>
	<h3 style="text-align: center; "> Polarization curve [Fig 1]</h3>
	<div id="polarization"> </div> <br>
	<h3 style="text-align: center;"> Power output curve [Fig 2] </h3>
	<div id="power"> </div> <br>
	<h3 style="text-align: center;"> Polarization and power output curve [Fig 3] </h3>
	<div id="powerandpolarization"> </div> <br>
	<h3 style="text-align: center;"> Losses, fuel cell voltage and power [Fig 4] </h3>
	<div id="everything"> </div> <br>
	<div style="text-align: center;">
	<input id="subut" type="submit" value="Download pdf report">
	</div>	
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