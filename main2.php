<!doctype html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<!-- <link rel="SHORTCUT ICON" href="http://devops.oraclecorp.com/static/favicon.ico"> -->
	<link rel="SHORTCUT ICON" href="./images/bug3.ico">
	<title>IDM BugDB Dashboard</title>

	<script type="text/javascript" src="../3rdParty/DataTables-1.10.3/media/js/jquery.js"></script>
	
	<!-- Style Sheets -->
	<link rel="stylesheet" href="css/jq.css" type="text/css" media="print, projection, screen" />
	<link rel="stylesheet" href="../3rdParty/DataTables-1.10.3/media/css/jquery.dataTables.css" type="text/css" media="print, projection, screen" />
	<style>
		form fieldset {
			-webkit-border-radius: 8px;
			-moz-border-radius: 8px;
			border-radius: 8px;
			margin-right:3em;
			padding:0 10px 10px;
			border:1px solid #666;
			box-shadow:0 0 10px #666;
			padding-top:10px;
		}
		legend {
			border: solid 1px black;
			-webkit-border-radius: 8px;
			-moz-border-radius: 8px;
			border-radius: 8px;
			font-weight: bold;
			font-size: 1.5em;
		}
	</style>
	
    <!--Load the AJAX API-->
    <script type="text/javascript" src="https://www.google.com/jsapi"></script>
</head>
<body>
	<?php	
		include "utils.php";
		include "header.php";

		time_elapsed(" ~~~~~~~~~~~~ STARTING ~~~~~~~~~~~~ ");
		set_time_limit(0);

		// ////////////// //
		// Initialization //
		// ////////////// //
		$products = array(
			"OIM" => 1980, 
			"OIM Connector" => 1999, 
			"OPAM" => 9436,
			"OAM" => 5565,
			"APS" => 10878,
			"OESSO" => 2074,
			"OAAM" => 4419,
			"OIF" => 1741);
		$groups = array("All", "QA", "Dev", "Upg/Sys", "PSR", "NLS", "Support", "SE", "ATeam");
		$status = array("1140", "8035", "3x", "1140-Def");

		$h = htmlentities($_SERVER['PHP_SELF']);
		$chkBox='';

		// //////////////////////// //
		// Layout the query section //
		// //////////////////////// //
		echo "
			<form id='myform' style='margin-bottom:5px;' action=$h method='post'>
			<table border=0 cellpadding=0 cellspacing=0 width=100% style='border-collapse:collapse' > 
				<tr size=15><td align='right'><b style='font-size:20px; color:black'>Select Product&nbsp;&nbsp;&nbsp;&nbsp;</b></td><td>
		";
		foreach ($products as $name => $code) {
			if (isset($_POST['productList'])) {
				if (in_array($code, $_POST['productList'])) {
					$chkBox ='checked';
				} else { 
					$chkBox = ''; 
				}
			}
			echo "<input type='checkbox' name='productList[]' value=$code $chkBox /> <font style='font-size:15px; color:black'>$name &nbsp; &nbsp;</font>";
		}
		
		echo "
				</td> <td rowspan=3><input type='submit' name='submit' value='Refresh Dashboard' /></td></tr>
				<tr size=12><td align='right'><b style='font-size:20px; color:black'>Select Group&nbsp;&nbsp;&nbsp;&nbsp;</b></td><td>
		";
		foreach ($groups as $g => $value) {
			if (isset($_POST['groupList'])) {
				if (in_array($groups[$g], $_POST['groupList'])) {
					$chkBox ='checked';
				} else { 
					$chkBox = ''; 
				}
			}
			echo "<input type='checkbox' name='groupList[]' value=$groups[$g] $chkBox /> <font style='font-size:15px; color:black'>$groups[$g] &nbsp; &nbsp;</font>";
		}
		
		echo "
				</td></tr>
				<tr size=12><td align='right'><b style='font-size:20px; color:black'>Select Status&nbsp;&nbsp;&nbsp;&nbsp;</b></td><td>
		";
		foreach ($status as $s => $value) {
			if (isset($_POST['statusList'])) {
				if (in_array($status[$s], $_POST['statusList'])) {
					$chkBox ='checked';
				} else { 
					$chkBox = ''; 
				}
			}
			echo "<input type='checkbox' name='statusList[]' value=$status[$s] $chkBox /> <font style='font-size:15px; color:black'>$status[$s] &nbsp; &nbsp;</font>";
		}
		echo "</td></tr></table>";
		echo "</form>";

		echo "<div id='Book1_498' align=center class=\"dataTables_wrapper\">";
		echo "<hr style='padding:0px; margin:0px;' />";
		
		// ////////////////////////////////////// //
		// Lay down the Dashboard / Chart section //
		// ////////////////////////////////////// //
		if (isset($_POST['productList'])){
			$selProdList = $_POST['productList'];			
			foreach ($selProdList as $p=>$code) {
				$name = array_search($code, $products);
				$x = draw_table($name, $code);
				echo "$x";
			}
		}

		time_elapsed("");

		// ///////// //
		// Functions //
		// ///////// //
		function draw_table($name, $code) {
		/*  // Implementation #1 ~~~ START ~~~
			$str2 = ""; //$str2 = "<tr>";
			if (isset($_POST['statusList'])){
				$selStsList = $_POST['statusList'];

				foreach ($selStsList as $hobys=>$value) {
					$y = draw_inner_table($code, $value);
					$x = "<td>$y</td>";
					$str2 = "$str2 $x";
				}
			}
			// Implementation #1 ~~~ END ~~~
		*/
			// Implementation #2 ~~~ START ~~~
			$str2 = "<tr >";
			if (isset($_POST['statusList'])) {
				$selStsList = $_POST['statusList']; $txt = "";

				foreach ($selStsList as $hobys=>$value) {
					$dt = build_chart_data($code, $value); //echo "~~~~~~~~~~~~~~~~~~~~~~~~\n"; print_r($dt); echo "********************\n";
					
					$txt = ""; //&nbsp;&nbsp;";
					for ($i=1, $cnt = sizeof($dt); $i<$cnt; $i++) {
						$url = $dt[$i][1]['url']; //echo "$url <br />";
						$txt = $txt . " <b style='font-size:12px; color:red;'>" . $dt[$i][0] . ":</b> <a href='" . $url . "' target=_blank>" . $dt[$i][1]['count'] . "</a>";
					}

					$x = "<td><div id='chart_div_" . $code . "_" . $value . "'> Chart for " . $code . "_" . $value . "</div>
						<div id='CountData'>$txt</div>
						</td>";
					$str2 = "$str2 $x";
				}
			}
			$str2 = "$str2</tr>";
			// Implementation #2 ~~~ END ~~~

			$str1 = "
				<table border=0 style='color=lightgrey; border-collapse:no-collapse' width='100%'>
					<tr style='outline: thin solid' bgcolor='lightgrey' color='#FFF'>
						<td colspan=6 align=center>
							<a href=\"product2.php?productID=$code\" target=_blank>
								<b style='font-size:25px; color:blue'>$name - $code</b>
							</a>
						</td>
					</tr>					
					" . $str2 . "
				</table>
			";
			
			return $str1;
		}
		
		function draw_inner_table($code, $status) { // This function is not in use
			// TODO: Abstract "$release" out as user input
			$release = "11.1.2.3%";
			//$qryStr = construct_qry_str("$code", "11.1.2.3%", "$status", "All");

			$str = "
				<table border=1 width='100%'>
					<tr style='outline: thin solid' bgcolor='lightgrey'>
						<td colspan=2 align=center><b>Status - $status</b></td>
					</tr>
					<tr>
						<td colspan=2 align=center><b>Total - " . get_count(construct_qry_str("$code", "$release", "$status", "All")) . "</b></td>
					</tr>
					<tr>
						<td align=center>QA - " . get_count(construct_qry_str("$code", "$release", "$status", "QA")) . "</td>
						<td align=center>Development - " . get_count(construct_qry_str("$code", "$release", "$status", "Dev")) . "</td>
					</tr>
					<tr>
						<td align=center>Upgrade/System - " . get_count(construct_qry_str("$code", "$release", "$status", "Upg/Sys")) . "</td>
						<td align=center>PSR - " . get_count(construct_qry_str("$code", "$release", "$status", "PSR")) . "</td>
					</tr>
					<tr>
						<td align=center>NLS - " . get_count(construct_qry_str("$code", "$release", "$status", "NLS")) . "</td>
						<td align=center>Support - " . get_count(construct_qry_str("$code", "$release", "$status", "Support")) . "</td>
					</tr>
				</table>
			";

			return $str;
		}

		function build_chart_data($code, $status) {
			$release = "11.1.2.3%"; // TODO: Abstract "$release" out as user input
			global $chart_data;
			$idx = $code . '_'. $status;

			//$data = array( array('Group', 'Count', "{ role: 'style' }"), array('Total', 230, 'red'), array('QA', 100, 'green'), array('Dev', 50, 'yellow'), array('Support', 80, 'blue'));
			/* $data = array( 
				array('Group', 'Count'), 
				array('Total', get_count_n(construct_qry_str("$code", "$release", "$status", "All"))), 
				array('QA', get_count_n(construct_qry_str("$code", "$release", "$status", "QA"))), 
				array('Dev', get_count_n(construct_qry_str("$code", "$release", "$status", "Dev"))), 
				array('Upg/Sys', get_count_n(construct_qry_str("$code", "$release", "$status", "Upg/Sys"))),
				array('PSR', get_count_n(construct_qry_str("$code", "$release", "$status", "PSR"))),
				array('NLS', get_count_n(construct_qry_str("$code", "$release", "$status", "NLS"))),
				array('Support', get_count_n(construct_qry_str("$code", "$release", "$status", "Support")))
			); */

			$total = get_count_num_url(construct_qry_str("$code", "$release", "$status", "All"));
			$qa = get_count_num_url(construct_qry_str("$code", "$release", "$status", "QA"));
			$dev = get_count_num_url(construct_qry_str("$code", "$release", "$status", "Dev"));
			$upgSys = get_count_num_url(construct_qry_str("$code", "$release", "$status", "Upg/Sys"));
			$psr = get_count_num_url(construct_qry_str("$code", "$release", "$status", "PSR"));
			$nls = get_count_num_url(construct_qry_str("$code", "$release", "$status", "NLS"));
			$sup = get_count_num_url(construct_qry_str("$code", "$release", "$status", "Support"));
			$se = get_count_num_url(construct_qry_str("$code", "$release", "$status", "SE"));
			$at = get_count_num_url(construct_qry_str("$code", "$release", "$status", "ATeam"));

			$data_cnt = array( 
				array('Group', 'Count'), 
				array('Total', $total['count']), 
				array('QA', $qa['count']), 
				array('Dev', $dev['count']), 
				array('Upg/Sys', $upgSys['count']),
				array('PSR', $psr['count']),
				array('NLS', $nls['count']),
				array('Support', $sup['count']),
				array('SE', $se['count']),
				array('ATeam', $at['count'])
			);
			$chart_data["$idx"] = $data_cnt; //$chart_data["$idx"] = json_encode($data);
			
			$data_cnt_url = array( 
				array('Group', 'Count'), 
				array('Total', $total), 
				array('QA', $qa), 
				array('Dev', $dev),
				array('Upg/Sys', $upgSys),
				array('PSR', $psr),
				array('NLS', $nls),
				array('Support', $sup),
				array('SE', $se),
				array('ATeam', $at)
			);
			return $data_cnt_url;
		}

		function construct_qry_str($prodID, $compVer, $status, $org) {
			switch ($org) {
				case "QA": 
					$strOrg = " and h.rptd_by IN (SELECT bug_username FROM BUG_USER START WITH full_email=upper('mike.hwa') CONNECT BY PRIOR full_email=manager_email )";
					$titleOrg = "QA (mike.hwa)";
					break;
				case "Dev":
					$strOrg = " and h.rptd_by IN (SELECT bug_username FROM BUG_USER START WITH full_email=upper('shirish.puranik') CONNECT BY PRIOR full_email=manager_email union SELECT bug_username FROM BUG_USER START WITH full_email=upper('pervez.goiporia') CONNECT BY PRIOR full_email=manager_email )";
					$titleOrg = "Development (in.singh)";
					break;
				case "All":
					$strOrg = "";
					$titleOrg = "All";
					break;
				case "PSR":
					$strOrg = " and h.rptd_by IN (SELECT bug_username FROM BUG_USER START WITH full_email=upper('mark.barbalat') CONNECT BY PRIOR full_email=manager_email )";
					$titleOrg = "PSR (mark.barbalat)";
					break;
				case "NLS":
					$strOrg = " and h.rptd_by IN (SELECT bug_username FROM BUG_USER START WITH full_email=upper('clement.lai') CONNECT BY PRIOR full_email=manager_email )";
					$titleOrg = "NLS (clement.lai)";
					break;
				case "Upg/Sys":
					$strOrg = " and h.rptd_by IN (SELECT bug_username FROM BUG_USER START WITH full_email=upper('michael.meiner') CONNECT BY PRIOR full_email=manager_email )";
					$titleOrg = "Upgrade & System (mark.barbalat)";
					break;
				case "EDG/HA":
					$strOrg = " and h.rptd_by IN (SELECT bug_username FROM BUG_USER START WITH full_email=upper('yongqing.jiang') CONNECT BY PRIOR full_email=manager_email )";
					$titleOrg = "EDG/HA/Cluster (yongqing.jiang)";
					break;
				case "Support":
					$strOrg = " and h.rptd_by IN (SELECT bug_username FROM BUG_USER START WITH full_email=upper('charles.rozwat') CONNECT BY PRIOR full_email=manager_email )";
					$titleOrg = "Support (charles.rozwat)";
					break;
				case "SE":
					$strOrg = " and h.rptd_by IN (SELECT bug_username FROM BUG_USER START WITH full_email=upper('anjala.mangal') CONNECT BY PRIOR full_email=manager_email )";
					$titleOrg = "SE (anjala.mangal)";
					break;
				case "ATeam":
					$strOrg = " and h.rptd_by IN (SELECT bug_username FROM BUG_USER START WITH full_email=upper('pardha.reddy') CONNECT BY PRIOR full_email=manager_email )";
					$titleOrg = "ATeam (pardha.reddy)";
					break;
			}

			switch ($status) {
				case "1140": 
					$strStatus = " and upper( h.utility_version) like upper('" . $compVer . "') and (h.DO_BY_RELEASE is null or h.DO_BY_RELEASE like upper('" . $compVer . "')) and h.status in (11, 40)";
					$titleStatus = "11 & 40";
					break;
				case "8035":
					$strStatus = " and upper( h.version_fixed) like upper('" . $compVer . "') and h.status in (80)"; //Feb 13, 2015: removed sts35
					$titleStatus = "80";
					break;
				case "3x":
					$strStatus = " and upper( h.utility_version) like upper('" . $compVer . "') and h.status in (30, 31, 32, 36)";
					$titleStatus = "30, 31, 32 & 36";
					break;
				case "1140-Def": 
					$strStatus = " and upper( h.utility_version) like upper('" . $compVer . "') and (h.DO_BY_RELEASE is not null or h.DO_BY_RELEASE not like upper('" . $compVer . "')) and h.status in (11, 40)";
					$titleStatus = "11 & 40";
					break;
			}

			$whereStr = "h.product_id = ". $prodID . $strStatus . $strOrg;
			$title = "Status " . $titleStatus . " - Org " . $titleOrg ;
			$pageTitle = "Product " . $prodID;
			//echo $whereStr . "<br/>";

			return ($whereStr . " ^ " . $title . " ^ " . $pageTitle);
		}

		//$data1 = array( array('Group', 'Count'),  array('Total', 230),array('QA', 100),  array('Dev', 50),array('Support', 80));
		//$data1 = json_encode($data1);

		if (isset($chart_data)) {
			$chart_data = json_encode($chart_data);
		}
		//echo "Non-associative array output as array: ", $chart_data, "<br \>";
		//echo "Non-associative array output as array: ", $chart_data[1], "<br \>";
		//echo "Non-associative array output as array: ", $data1, "<br \>";
	?>
	
	<script type="text/javascript">
		// Load the Visualization API and the piechart package.
		google.load('visualization', '1.0', {'packages':['corechart']});  //google.load('visualization', '1.0', {'packages':['columnchart']});

		// Set a callback to run when the Google Visualization API is loaded.
		google.setOnLoadCallback(drawChart);

		function drawChart() {
			var chart_data1 = <?php echo $chart_data; ?>;

			// Define and initialize an array object for 'style'
			var ColorObj = {}; ColorObj.role = "style";

			// Define and initialize an array object for 'annotation'
			var AnnotationObj = {}; AnnotationObj.role = "annotation";
			
	//console.log(chart_data1);
			for (var prop in chart_data1) {
	//console.log('for loop :' + prop + ' - ' + chart_data1[prop]);
				// Convert JSON object to an array
				var arrX = []; var arr = [];
				arrX.push(chart_data1[prop]);
				var elm = (chart_data1[prop]).toString();
	//console.log('elm : ' + elm);
				var Y = elm.split(",");
	//console.log('Y : ' + Y);
				for (var i=0, l = Y.length; i < l; i++, i++) {
	//console.log('arrX[' + i +'] : ' + arrX[i]);
	//console.log('Y1 : ' + Y[i] + ', Y2 : ' + Y[i+1] + ', Y3 : ' + Y[i+2]);
					var a = [];
					var a1, a2, a3;
	//console.log('i : ' + i);					
					a1 = Y[i]; 
					if (i == 0) {a2 = Y[i+1]} else {a2 = Number(Y[i+1])};
					//if (i == 0) {a3 = (Y[i+2]).replace(/"/g, '')} else {a3 = Y[i+2]};
					//if (i == 0) {a3 = (Y[i+2]).split("X")} else {a3 = Y[i+2]};
	//console.log('a1 : ' + a1 + ', a2 : ' + a2 + ', a3 : ' + a3);
					a = [a1, a2];
					
					// Colors from "http://www.colorpicker.com/"
					switch(i) {
						case 0: a.push(ColorObj); a.push(AnnotationObj); break;
						case 2: a.push("black"); a.push(a2); break;
						case 4: a.push("#19A862"); a.push(a2); break; // green
						case 6: a.push("#9E0B53"); a.push(a2); break; // rose
						case 8: a.push("#8C893A"); a.push(a2); break; // gold
						case 10: a.push("#0B309E"); a.push(a2); break; // blue
						case 12: a.push("#C42B0C"); a.push(a2); break; // brown
						case 14: a.push("#8011A8"); a.push(a2); break; // purple
						case 16: a.push("#EB1EEB"); a.push(a2); break; // magenta
						case 18: a.push("#72F78A"); a.push(a2); break; // lime
					}
					arr.push(a);
				}
	//console.log(arr);
	//console.log('arrX[0]: ' + arrX[0]); 

				// Create the data table.
				var cData = new google.visualization.arrayToDataTable(arr);
				var divID = 'chart_div_' + prop;

				// Set chart options
				var options = {'title':'Status - ' + (prop.split("_")).slice(1), fontSize:15, is3D:true, 'width':500, 'height':400, legend:'none', backgroundColor:'#F0EFDD', isStacked: true, backgroundColor: {stroke: 'black', strokeWidth:'0'}, bar: {groupWidth: '30'},
					titleTextStyle: {fontSize:25, color: '#C41A5A'}
					}; //EBD3DC

				// Instantiate and draw our chart, passing in some options.
				var chart = new google.visualization.ColumnChart(document.getElementById(divID));
				chart.draw(cData, options);
			}
		}
    </script>
</body>
</html>