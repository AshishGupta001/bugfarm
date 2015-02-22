<!DOCTYPE html>
<html lang="en">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
		<link rel="SHORTCUT ICON" href="http://devops.oraclecorp.com/static/favicon.ico">
		<title>BugDB DashBoard</title>
		
		<!-- Style Sheets -->
		<link rel="stylesheet" href="css/jq.css" type="text/css" media="print, projection, screen" />
		<link rel="stylesheet" href="../3rdParty/DataTables-1.10.3/media/css/jquery.dataTables.css" type="text/css" media="print, projection, screen" />

		<!-- Java Script Libraries -->
		<script type="text/javascript" src="../3rdParty/DataTables-1.10.3/media/js/jquery.js"></script>
		<script type="text/javascript" src="../3rdParty/DataTables-1.10.3/media/js/jquery.dataTables.js"></script>
		<script type="text/javascript" src="../3rdParty/DataTables-Plugins/dataTables.colReorder.js"></script>

		<!-- Java Scripts to support export data to Excel -->
		<script src="js/jquery.btechco.excelexport.js"></script>
		<script src="js/jquery.base64.js"></script>

		<!-- ###################################### -->
		<!-- For enabling column re-ordering  START -->
		<style>
			<!-- Namespace DTCR - "DataTables ColReorder" plug-in -->
			table.DTCR_clonedTable {
				background-color: rgba(255, 255, 255, 0.7);
				z-index: 202;
			}

			div.DTCR_pointer {
				width: 1px;
				background-color: #0259C4;
				z-index: 201;
			}
		</style>
		<!-- For enabling column re-ordering  END -->
		<!-- #################################### -->

		<!-- XXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXX -->
		<script>
			$(document).ready(function() {
				$("[id^=dvData]").dataTable( {
					"lengthMenu": [[10, 25, 50, 75, -1], [10, 25, 50, 75, "All"]],
					dom: 'Rlfrtip', <!-- For enabling column re-ordering -->
					//sPaginationType: "full_numbers",
					//bJQueryUI: true,
					"fnDrawCallback": function ( oSettings ) {
						// Need to redo the counters if filtered or sorted
						if ( oSettings.bSorted || oSettings.bFiltered ) {
							for ( var i=0, iLen=oSettings.aiDisplay.length ; i<iLen ; i++ ) {
								$('td:eq(0)', oSettings.aoData[ oSettings.aiDisplay[i] ].nTr ).html( i+1 );
							}
						}
					},
					"columnDefs": [ {
						"searchable": false,
						"orderable": false,
						"targets": 0
					} ] //,
					//"order": [[ 1, 'asc' ]]
				});
			} );
		</script>
		<!-- XXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXX -->

		<!-- ############################# -->
		<!-- Toggle 'SQL Query' text START -->
		<script>
			$(document).ready(function() {			
				$( "img" ).click(function() {
					var id = $(this).attr('id');
					var i = $("img#" + id);
					//alert('id is ' + id + ' and image obj is ' + i.attr('src') + i.attr('class') );

					var p1 = $("div#" + id + ".sql");
					var tbl = $("div#dvData" + id + "_wrapper");

					if ( i.attr('class') == 'rightImg') {
						//alert('Clicked on rightImg');
						p1.toggle("fast"); //$("p#" + id).toggle("fast");
						
						i.attr( 'src', './images/minus.jpg');
						i.attr('class', 'downImg');
						i.attr('title', 'Hide SQL');
					} else if ( i.attr('class') == 'downImg') {
						//alert('Clicked on downImg');
						p1.toggle("fast"); //$("p#" + id).toggle("fast");

						i.attr( 'src', './images/plus.jpg');
						i.attr('class', 'rightImg');
						i.attr('title', 'Show SQL');
					}

					// hide/show the tablular data
					if ( i.attr('class') == 'hideImg') {
						//alert('Clicked on hideImg');
						tbl.toggle("fast"); //$("p#" + id).toggle("fast");
						
						i.attr( 'src', './images/show.jpg');
						i.attr('class', 'showImg');
						i.attr('title', 'Show');
					} else if ( i.attr('class') == 'showImg') {
						//alert('Clicked on showImg');
						tbl.toggle("fast"); //$("p#" + id).toggle("fast");

						i.attr( 'src', './images/hide.jpg');
						i.attr('class', 'hideImg');
						i.attr('title', 'Hide');
					}
				});
			} );
		</script>
		<!-- Toggle 'SQL Query' text END -->
		<!-- ########################### -->
	</head>
	
	<body>
		<?php
			include "utils.php";

			// Get the product ID for which dashboard has to be displyed
			if(isset($_GET["productID"])) {
				$varProdID = $_GET["productID"];
				//echo "<h1 style='text-align:center'>Dashboard for " . $varProdID . "</h1>";
			} else {
				echo "Please select a valid Product ID.";
				exit;
			}

			// Fetch other info for the selected product id
			if(isset($_SESSION['productsXML'])) {
				//echo "productsXML found in SESSION";
				$prodXMLObj = new SimpleXMLElement($_SESSION['productsXML']);
				list($result) = $prodXMLObj->xpath('(//products/product[code = "' . $varProdID . '"])[1]');
				//var_dump($result);
				
			} else {echo "product.php: productsXML NOT found in SESSION<br>";}

			// Get the sequence for which dashboard has to be displyed
			if(isset($_GET["querySeq"])) {
				$varQuerySeq = $_GET["querySeq"];
			} else {$varQuerySeq = "";}

			// Read the XML file containing the Bug DB queries for various products 
			// TODO: Convert this to a function so that reading the XML file is done once for all the product.
			$xml = simplexml_load_file('bugdb_dashboard_query2.xml');

			// Loop over the list and get specific queries for given product
			$reports = array();
					
			//print_r2($xml->reports->children());
			$reports = $xml->reports->children();

			// Set the page title
			$_PAGE_TITLE = "[$varProdID]";

			include "header.php";

			foreach($reports as $rpt) {
				// initialize local variables
				$selectClause = "select ";
				$fromClause = "from ";
				$whereClause = "where ";
				$orderByClause = "order by ";

				// Fetch details for a selected report
				$qrySeq = $rpt['sequence'];
				$title = $rpt->title;
				$columns = $rpt->columns->children();

				if ($varQuerySeq == "" || $varQuerySeq == $qrySeq) {
					// Fetch the corresponding table column names to be fetched
					$cols = array();
					foreach($columns as $col) {
						//echo $col['colName'] . " - $col <br>";
						//array_push($colArray, $col);
						$cols[] = $col['field'];
					}

					$selectClause .= implode(', ', $cols); //echo "$selectClause <br>";

					$fromTbl = $rpt->from;
					$fromClause = $fromClause . $fromTbl; //echo "$fromClause <br>";

					$whereCols = $rpt->where->children();				
					foreach($whereCols as $col) {
						//echo $col['colName'] . " - $col <br>";
						
						$whereClause = $whereClause . " " . $col['befOp'] . " " . $col;
					}
					//echo "$whereClause <br>";

					$orderBy = $rpt->orderby;
					$orderByClause = $orderByClause . $orderBy;
					//echo "$orderByClause <br>";

					$qryStr = $selectClause . " " . $fromClause . " " . $whereClause . " " . $orderByClause;
					$qryStr = str_replace("@PODUCT_CODE@", $varProdID, $qryStr);

					echo "
					<div class='dataTables_wrapper'>
					<table border=0 style='color=lightgrey; border-collapse:collapse' width='100%'><tbody>
						<tr style='outline: thin solid' bgcolor='lightgrey'>
							<td width='2%' align='center' valign='center'><img src='./images/hide.jpg' class='hideImg' id=$qrySeq title='Hide' style='cursor: pointer;' height='20' width='20' /></td>
							<td nowrap width='24%' valign='center'><h1>
								$title
								<a href=\"product2.php?productID=$varProdID&querySeq=$qrySeq\" target=_blank><img src='./images/backred.png' title='Open in new tab' height='30' width='30' /></a>
							</h1></td>
							<td width='70%'><div class='sql' style='display: none; font-size:10px' id=SQL$qrySeq>$qryStr</div></td>
							<td width='2%' align='center' valign='center'><img src='./images/plus.jpg' class='rightImg' id=SQL$qrySeq title='Show SQL' style='cursor: pointer;' height='20' width='20' /></td>
						</tr>
					</tbody></table> </div>";

					// Layout the table for selected query
					echo "<table id='dvData$qrySeq'; class='display hower compact' cellspacing='0' width='100%'>";

					// Layout the table header.
					echo "<thead><tr>";
					foreach ($columns as $c) {
						echo "<th>$c</th>";
					}
					echo '</tr></thead>';
					echo '<tbody>';
					// Query BugDB and fetch the result set
					$resultSet = execute_sql($qryStr);
					
					while ($row = oci_fetch_array($resultSet, OCI_RETURN_NULLS+OCI_ASSOC )){
						echo '<tr>';
						foreach ($row as $item) {
							echo "<td>$item</td>";
						}
						echo '</tr>';
					}
					echo '</tbody></table>';
				}
			}
		?>
	</body>
</html>