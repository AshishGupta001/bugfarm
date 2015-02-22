<!DOCTYPE html>
<html lang="en">
	<head><meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
		<!-- <meta content="text/html; charset=UTF-8" http-equiv="content-type"/> -->
		<link rel="SHORTCUT ICON" href="http://devops.oraclecorp.com/static/favicon.ico">
		<title>IDM BugDB DashBoard</title>
		
		<!-- Style Sheets -->
		<link rel="stylesheet" href="css/jq.css" type="text/css" media="print, projection, screen" />
		<link rel="stylesheet" href="../3rdParty/DataTables-1.10.3/media/css/jquery.dataTables.css" type="text/css" media="print, projection, screen" />

		<!-- Java Script Libraries -->
		<script type="text/javascript" src="../3rdParty/DataTables-1.10.3/media/js/jquery.js"></script>
		<script type="text/javascript" src="../3rdParty/DataTables-1.10.3/media/js/jquery.dataTables.js"></script>

		<!-- Java Scripts to support export data to Excel -->
		<script src="js/jquery.btechco.excelexport.js"></script>
		<script src="js/jquery.base64.js"></script>

<!-- XXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXX -->
		<script>
			$(document).ready(function() {
				$("[id^=dvData]").dataTable( {
					"lengthMenu": [[10, 25, 50, 75, -1], [10, 25, 50, 75, "All"]],
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
<!--
 		// Script to implement 'text' search at each column
 		<script>
			$(document).ready(function() {

				// Setup - add a text input to each footer cell
				$('#example tfoot th').each( function () {
					var title = $('table.display thead th').eq( $(this).index() ).text();
					$(this).html( '<input type="text" placeholder="Search '+title+'" />' );
				} );

				// DataTable
				var table = $('table.display').DataTable();
			 
				// Apply the search
				table.columns().eq( 0 ).each( function ( colIdx ) {
					$( 'input', table.column( colIdx ).footer() ).on( 'keyup change', function () {
						table
							.column( colIdx )
							.search( this.value )
							.draw();
					} );
				} );
			} );
		</script>
		<style>
			tfoot input {
				width: 100%;
				padding: 3px;
				box-sizing: border-box;
			}
		</style>
-->
<!--
		<script>
		// Script to implement 'drop down' search at each column
			$(document).ready(function() {
				var table = $('#example').DataTable();
			 
				$("#example tfoot th").each( function ( i ) {
					var select = $('<select><option value=""></option></select>')
						.appendTo( $(this).empty() )
						.on( 'change', function () {
							var val = $(this).val();
			 
							table.column( i )
								.search( val ? '^'+$(this).val()+'$' : val, true, false )
								.draw();
						} );
			 
					table.column( i ).data().unique().sort().each( function ( d, j ) {
						select.append( '<option value="'+d+'">'+d+'</option>' )
					} );
				} );
			} );
		</script>
-->

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
			set_time_limit(0); // Set off time limit globally to avoid time out exception. TODO: There has be a better way to handle this.

			// Read the XML file containing the Bug DB queries for various products 
			// TODO: Convert this to a function so that reading the XML file is done once for all the product.
			$xml = simplexml_load_file('bugdb_dashboard_query.xml');

			// Loop over the list and get specific queries for given product
			$prodQueries = array();
			foreach($xml->product as $product) {
				if ($product['prodID'] == $varProdID) {
					array_push($prodQueries, $product);

					$id   = $product['id'] ? $product['id'] : "NULL";
					$prodID   = $product['prodID'] ? $product['prodID'] : "NULL";
					$prodName = $product['name'] ? $product['name'] : "NULL";
					$suiteName = $product['suite'] ? $product['suite'] : "NULL";
					
					// There should be only 1 entry for any given product id; else the last one will overwrite every other entry
					$queries = $product->queries->children();
				}
			}

			// Set the page title
			$_PAGE_TITLE = "$prodName [$prodID]";

			include "header.php";

			//print_r2(print_r($prodQueries, true));

			foreach($queries as $query) {
				// Fetch details for a selected query
				$qrySeq = $query['sequence'];
				$title = $query->title;
				$qryStr = $query->queryStr;
				$colNames = $query->columns->children();

				//time_elapsed("Starting to fetch data for query $qrySeq");
				echo "
				<div class='dataTables_wrapper'>
				<table border=0 style='color=lightgrey; border-collapse:collapse' width='100%'><tbody>
					<tr style='outline: thin solid' bgcolor='lightgrey'>
						<td width='2%' align='center' valign='center'><img src='./images/hide.jpg' class='hideImg' id=$qrySeq title='Hide' style='cursor: pointer;' height='20' width='20' /></td>
						<td nowrap width='24%'><h1> $title </h1></td>
						<td width='2%' align='center'>&nbsp;<a href=\"query.php?prodID=$prodID&querySeq=$qrySeq\" target=_blank><img src='./images/backred.png' title='Open in new tab' height='30' width='30' /></a></td>
						
						<td width='70%'><div class='sql' style='display: none; font-size:10px' id=SQL$qrySeq>$qryStr</div></td>
						<td width='2%' align='center' valign='center'><img src='./images/plus.jpg' class='rightImg' id=SQL$qrySeq title='Show SQL' style='cursor: pointer;' height='20' width='20' /></td>
					</tr>
				</tbody></table> </div>";

				//echo "<div class='dataTables_wrapper' border=1>";
				// Layout the table for selected query
				echo "<table id='dvData$qrySeq'; class='display hower compact' cellspacing='0' width='100%'>";

				// Fetch the column names that need to be displayed for a selected query
				$colArray = array();
				foreach($colNames as $col) {
					array_push($colArray, $col); //echo "$col |";
				}

				// Layout the table header.
				echo "<thead><tr>";
				foreach ($colNames as $c) {
					echo "<th>$c</th>";
				}
				echo '</tr></thead>';
				
				/*
				// Layout the table footer.
				echo '<tfoot><tr>';
				foreach ($colNames as $c) {echo "<th>$c</th>";}				
				echo '</tr></tfoot>';
				*/
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

				//echo '</p>';
				echo '</tbody></table>';
				//echo '</div>';
				//echo '<div class="dataTables_wrapper"><hr /></div>';
				//time_elapsed("Done fetching data for query $qrySeq");
			}
		?>
	</body>
</html>