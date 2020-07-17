<?php
session_start();
			$_SESSION['ifc'] = array();
			$_SESSION['Vfc'] =array();
			$_SESSION['eff'] = array();
			$_SESSION['Pfc'] = array();
			$_SESSION['V_conc'] = array();
			$_SESSION['V_act'] = array();
			$_SESSION['V_ohmic'] = array();
			$_SESSION['fuel_util'] = array();
			$_SESSION['P_H2'] = array();
			$_SESSION['Cb'] = array();
			$_SESSION['iL'] = array();
			$_SESSION['i0'] = array();
			$_SESSION['En'] = array();
			$_SESSION['Eoc'] = array();
			$_SESSION['alpha'] = array();
			$Temp=$_SESSION['Temp'];
			$F=$_SESSION['F'];
			$R=$_SESSION['R'];
			$fuel_rate=$_SESSION['fuel_rate'];
			$P_anode=$_SESSION['P_anode'];
			$P_cathode=$_SESSION['P_cathode'];
			$R_ohm=$_SESSION['R_ohm'];
			$alpha=$_SESSION['alpha'];
			$ifc=$_SESSION['ifc'];

			
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
	<br>
	<p style="text-align: center"><strong>The following Parameters are required as input from the user</strong></p>
	<form action="v2.1.1.report.php" method="post"  target="_blank" align="center">
		<table class="my-special-table" border="4" align="center">
			<tr style="font-weight: 700;">
				<td class="first-column">Quantity</td>
				<td class="second-column">Value</td>
				<td>Units</td>
			</tr>
			<tr>
				<td class="first-column">Faraday's Constant:</td>
				<td class="second-column"><input class="constant-values" type="number" name="F" value = "96485" readonly></td>
				<td>A-s/mol</td>
			</tr>
			<tr>
				<td class="first-column">Universal Gas Constant:</td>
				<td class="second-column"><input class="constant-values" type="number" name="R" value = "8.314" readonly></td>
				<td>J/mol-K</td>
			</tr>
			<tr>
				<td class="first-column">Enter Temperature:</td>
				<td class="second-column"><input class="table-values" type="number" name="Temp" value = "<?php echo $Temp = $_POST['Temp'] ?>" readonly></td>
				<td>Kelvin(K)</td>
			</tr>
			<tr>
				<td class="first-column">Enter Fuel Flow Rate:</td>
				<td class="second-column"><input class="table-values" type="number" name="fuel_rate" value = "<?php echo $fuel_rate = $_POST['fuel_rate'] ?>" readonly></td>
				<td>Lpm</td>
			</tr>
			<tr>
				<td class="first-column">Enter Pressure at Anode:</td>
				<td class="second-column"><input class="table-values" type="number" name="P_anode" value = "<?php echo $P_anode = $_POST['P_anode'] ?>" readonly></td>
				<td>Bar</td>
			</tr>
			<tr>
				<td class="first-column">Enter Pressure at Cathode:</td>
				<td class="second-column"><input class="table-values" type="number" name="P_cathode" value = "<?php echo $P_cathode = $_POST['P_cathode'] ?>" readonly></td>
				<td>Bar</td> 
			</tr>
			<tr>
				<td class="first-column">Enter Internal Resistance (ASR):</td>
				<td class="second-column"><input class="table-values" type="number" name="R_ohm" value = "<?php echo $R_ohm = $_POST['R_ohm'] ?>" readonly></td>
				<td>Ohm.cm.sq</td>
			</tr>
		</table> <br>
	<p>
		<?php 
			$K = 1000;
			$F = 96485;
			$R = 8.314;
			$n = 2;
			$kc=1;
			$del = 0.01;
			$deff = 0.01;
			$P_O2 = $P_cathode;
			$ifc = array();
			$Vfc = array();
			$eff = array();
			$Pfc = array();
			$A = array();
			$V_conc = array();
			$V_act = array();
			$V_ohmic = array();
			$alpha = array();
			$fuel_util = array();
			$P_H2 = array();
			$Cb = array();
			$iL = array();
			$i0 = array();
			$En = array();
			$Eoc = array();
			$a = 0;
			for ($i = 0.25;$i<=4;$i+=0.25)
			{ 
    			$ifc[$a] = $i;
    			$fuel_util[$a] = (60000*$R*$Temp*$ifc[$a])/($n*$F*$P_anode*($fuel_rate)*0.9995); 
    			$P_H2[$a] = $P_anode*(1-($fuel_util[$a]/100));
    			$Cb[$a] = $P_H2[$a]/22400;
    			$iL[$a] = ($n*$F*$deff*$Cb[$a])/$del;
    			$i0[$a] = $iL[$a]/$K; 
    			$En[$a] = 1.229 + ($Temp-298)*(-44.43/($n*$F))+ ($R*$Temp*log($P_H2[$a]*sqrt($P_O2)))/($n*$F);
    			$Eoc[$a] = $kc*$En[$a];
    			$V_conc[$a] = -$R*$Temp*log(1-$ifc[$a]/$iL[$a])/($n*$F);
    			$V_ohmic[$a] = $ifc[$a]*$R_ohm;
    			$alpha[$a] = log($ifc[$a]/$i0[$a]);
    			$A[$a] = $R*$Temp/($alpha[$a]*$F*$n);
    			$V_act[$a] = $A[$a]*log($ifc[$a]/$i0[$a]);
    			$Vfc[$a] = $Eoc[$a] - ($V_conc[$a] +$V_ohmic[$a]+$V_act[$a]);
    			$Pfc[$a] = $Vfc[$a]*$ifc[$a];
    			$eff[$a] = (0.675*$Vfc[$a]*$fuel_util[$a])*100;
    			$a = $a+1;
    		}
    		for ($b=0; $b<=$a-1; $b+=1)
			{
				$ifc[$b] = round($ifc[$b],5);
				$V_act[$b] = round($V_act[$b],5);
				$V_ohmic[$b] = round($V_ohmic[$b],5);
				$V_conc[$b] = round($V_conc[$b],5);
				$Vfc[$b] = round($Vfc[$b],5);
				$Pfc[$b] = round($Pfc[$b],5);
			}
    		echo '<table class="my-special-table" border="4" bordercolor=white align="center">';
    			echo '<tr style="font-weight: 700;">';
    				echo '<th> Fuel Cell Current: </th>';
    				echo '<th> Activation Loss: </th>';
    				echo '<th> Ohmic Loss: </th>';
    				echo '<th> Concentration Loss: </th>';
	    			echo '<th> Fuel Cell Voltage: </th>';
	    			echo '<th> Fuel Cell Power:  </th>';
	    		echo '</tr>';
	    		for ($b=0;$b<=15;$b++) { 
	    			echo '<tr class="table-indent">';
	    				echo '<td>'.$ifc[$b].'</td>';
	    				echo '<td>'.$V_act[$b].'</td>';
	    				echo '<td>'.$V_ohmic[$b].'</td>';
	    				echo '<td>'.$V_conc[$b].'</td>';
	    				echo '<td>'.$Vfc[$b].'</td>';
	    				echo '<td>'.$Pfc[$b].'</td>';
	    			echo '</tr>';
	    		}
				$s=15;
	    	echo '</table>';
     $_SESSION['ifc'] = $ifc;
			$_SESSION['Vfc'] =$Vfc;
			isset($Vfc);
			$_SESSION['eff'] = $eff;
			$_SESSION['Pfc'] = $Pfc;
			$_SESSION['V_conc'] = $V_conc;
			$_SESSION['V_act'] = $V_act;
			$_SESSION['V_ohmic'] = $V_ohmic;
			$_SESSION['fuel_util'] = $fuel_util;
			$_SESSION['P_H2'] = $P_H2;
			$_SESSION['Cb'] = $Cb;
			$_SESSION['iL'] = $iL;
			$_SESSION['i0'] = $i0;
			$_SESSION['En'] = $En;
			$_SESSION['Eoc'] = $Eoc;
			$_SESSION['Temp'] = $Temp;
			$_SESSION['F'] = $F;
			$_SESSION['R'] = $R;
			$_SESSION['fuel_rate'] = $fuel_rate;
			$_SESSION['P_anode'] = $P_anode;
			$_SESSION['P_cathode'] = $P_cathode;
			$_SESSION['R_ohm'] = $R_ohm;
			$_SESSION['alpha'] = $alpha;
			$_SESSION['ifc'] = $ifc;




		?>
	</p>
	<script type="text/javascript">
	var k = <?php echo json_encode($a);?>;
	var i = [];
	var nact = [];
	var nohm = [];
	var nconc = [];
	var Vfuel = [];
	var Power = [];
	i = <?php echo json_encode($ifc);?>;
	nact = <?php echo json_encode($V_act);?>;
	nohm = <?php echo json_encode($V_ohmic);?>;
	nconc = <?php echo json_encode($V_conc);?>;
	Vfuel = <?php echo json_encode($Vfc);?>;
	Power = <?php echo json_encode($Pfc);?>;

	google.charts.load('current', {'packages':['corechart']});

	// Set a callback to run when the Google Visualization API is loaded.
	google.charts.setOnLoadCallback(polarization);
	google.charts.setOnLoadCallback(power);
	google.charts.setOnLoadCallback(powerandpolarization);



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
		google.visualization.events.addListener(chart, 'ready', function () {
		      var app1=(chart.getImageURI());
		      $.post("2a.php",{postapp: app1},
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
		      $.post("2b.php",{postapp: app1},
		      function(){});
		    });

		chart.draw(data, options);
		}


	function powerandpolarization() {

		// Create the data table.
		var data = new google.visualization.DataTable();
		data.addColumn('number', 'Fuel cell current density (A/cm2)');
		data.addColumn('number', 'Power (W)');
		data.addColumn('number', 'Voltage (V)');
		for(var temp=0;temp<=k;temp++)
		{
			data.addRow([Number(i[temp]),Number(Power[temp]),Number(Vfuel[temp])]); //Adding the time vector and sine function arrays as a row in google charts
		}

	    // Set chart options
		var options = {'title':'Polarization and Power output curve',
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
		      $.post("2c.php",{postapp: app1},
		      function(){});
		    });

		chart.draw(data, options);
		}
		</script>
	<h3 style="text-align: center"> Polarization curve [Fig 1]</h3>
	<div id="polarization"> </div> <br>
	<h3 style="text-align: center"> Power output curve [Fig 2] </h3>
	<div id="power"> </div> <br>
	<h3 style="text-align: center"> Polarization and power output curve [Fig 3] </h3>
	<div id="powerandpolarization"> </div> <br>
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