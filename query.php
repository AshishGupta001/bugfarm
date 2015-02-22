<!DOCTYPE html>
<html lang="en">
	<head><meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
		<!-- <meta content="text/html; charset=UTF-8" http-equiv="content-type"/> -->
		<link rel="SHORTCUT ICON" href="http://devops.oraclecorp.com/static/favicon.ico">
		<title>IDM BugDB DashBoard</title>
		
		<!-- Style Sheets -->
		<link rel="stylesheet" href="css/jq.css" type="text/css" media="print, projection, screen" />
		<link rel="stylesheet" href="../3rdParty/DataTables-1.10.3/media/css/jquery.dataTables.css" type="text/css" media="print, projection, screen" />
		<link rel="stylesheet" href="../3rdParty/jquery-ui-1.11.1/jquery-ui.theme.css" type="text/css" />
		
		<!-- Java Script Libraries -->
		<script type="text/javascript" src="../3rdParty/DataTables-1.10.3/media/js/jquery.js"></script> <!-- <script type="text/javascript" src="../DataTables-1.10.2/media/js/jquery.js"></script> -->
		<script type="text/javascript" src="../3rdParty/DataTables-1.10.3/media/js/jquery.dataTables.js"></script> <!-- <script type="text/javascript" src="../DataTables-1.10.2/media/js/jquery.dataTables.js"></script> -->
		
		<script type="text/javascript" src="../3rdParty/jquery-ui-1.11.1/jquery-ui.min.js"></script>
		<script type="text/javascript" src="../3rdParty/DataTables-Plugins/jquery.dataTables.columnFilter.js"></script>

		<!-- Java Scripts to support export data to Excel -->
		<script src="js/jquery.base64.js"></script>
		<script src="js/jquery.btechco.excelexport.js"></script>  <!-- <script src="js/jquery.battatech.excelexport.min.js"> </script> -->

		<!-- ######### Column Range filtering {START} ######### -->
 		<script type="text/javascript" class="init">
			$(document).ready(function() {
				var table = $('#dvData').DataTable( {
					"lengthMenu": [[10, 25, 50, 75, -1], [10, 25, 50, 75, "All"]],
					//"scrollY": "200px",
					//"paging": false
					
					"columnDefs": [ {
						"searchable": false,
						"orderable": false,
						"targets": 0
					} ] //,
					//"order": [[ 1, 'asc' ]]
				} );

				$.datepicker.regional[""].dateFormat = 'dd-M-y'; //'yy/mm/dd'
                $.datepicker.setDefaults($.datepicker.regional['']);

				$('#dvData').dataTable().columnFilter({
					//sPlaceHolder: "head:before",
					sPlaceHolder: "foot",
					aoColumns: [
						{ type: "number", sWidth: "0px" },
						{ type: "text", sWidth: "10px" },
						{ type: "date-range" },
						{ type: "text" },
						{ type: "text" },
						{ type: "number-range", sWidth: "10px" },
						{ type: "text" },
						{ type: "text" },
						{ type: "number" },
						{ type: "bigtext", sWidth: "150" },
						{ type: "text" }
					]
				});

				// Add static row number to the table
				table.on( 'order.dt search.dt', function () {
					table.column(0, {search:'applied', order:'applied'}).nodes().each( function (cell, i) {
						cell.innerHTML = i+1;
					} );
				} ).draw(); 

				// Add event listeners to the two range filtering inputs
				$('#min').keyup( function() { table.draw(); } );
				$('#max').keyup( function() { table.draw(); } );

			} );


		</script>
		
		<style>
			.date_range_filter {width:50px;}
			.number_range_filter {width:30px;}
			.text_filter {width:60px;}
			.big_text_filter {width:150px;}
			.number_filter {width:20px;}
		</style>
		<!-- ###### Column Range filtering {END} ###### -->

		<!-- ###### Script to implement 'text' search at each column {START} ###### -->
		<!-- 
		<script>
			$(document).ready(function() {

				// Setup - add a text input to each footer cell
				$('#dvData tfoot th').each( function () {
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
		<!-- ###### Script to implement 'text' search at each column {END} ###### --> 

		<!-- ##### Script to implement 'drop down' search at each column {START} ##### -->
		<!--
		<script>
			$(document).ready(function() {
				var table = $('#dvData').DataTable();
				$("#dvData1 tfoot th").each( function ( i ) {
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
		<!-- ##### Script to implement 'drop down' search at each column {END} ##### -->
		
		<!-- ###### Dynamically Show/Hide columns in table {START} ###### -->
		<script>
			$(document).ready(function() {
				var table = $('#dvData').DataTable();
				// Show/Hide columns
				$('a.toggle-vis').on( 'click', function (e) {
					e.preventDefault();

					// Get the column API object
					var column = table.column( $(this).attr('data-column') );
 
					// Toggle the visibility
					column.visible( ! column.visible() );
					
					if (! column.visible()) {
						$(this).css("background-color","yellow");
					} else {
						$(this).css("background-color","");
					}
				});

			} );
		</script>
		<!-- ###### Dynamically Show/Hide columns in table {END} ###### -->

		<!-- ###### For enabling X & Y scrolling {START} ###### -->
		<!--
		<script> 
			$(document).ready(function() {
				$('table.display').dataTable( {
					"scrollY": 100,
					"scrollX": true
				} );
			} );
		</script>

		<style>
			th, td { white-space: nowrap; }
				div.dataTables_wrapper {
				width: 1000px;
				margin: 0 auto;
			}
		</style>
		-->
		<!-- ##### For enabling X & Y scrolling {END} ##### -->

		<!-- ##### For enabling multi table pagination {START} ##### -->
		<!--
		<style>
			div.dataTables_wrapper {
				margin-bottom: 1em;
				margin-left: 3em;
				margin-right: 3em;
			}
		</style>
		-->
		<!-- ##### For enabling multi table pagination {END} ##### -->
		
		<!-- ##### Export HTML Table to XLS {START} ###### -->
		<script>
			$(document).ready(function () {
				$("#exportBugs2XLS").click(function () {
					try {
						//$("#dvData > tfoot").hide(); //does not work
						var foot = $("#dvData > tfoot").html();
						
						$("#dvData > tfoot").empty();
						$('#dvData').dataTable( {
							destroy: true,
							paging: false,
							searching: false,
							header: false
						});
					} catch (err) {
						alert('Caught exception: ' + err.message);
					}

					try {
						$("#dvData").btechco_excelexport({
							containerid: "dvData"
						   , datatype: $datatype.Table
						});
					} catch(err) {
						var_dump(err);
						alert('Caught exception: ' + err.message);
					}
					
					try {
						//$("#dvData > tfoot").show();
						$("#dvData > tfoot").html(foot);

						$('#dvData').dataTable( {
							destroy: true,
							paging: true,
							searching: true,
							header: true
						});
					} catch (err) {
						alert('Caught exception: ' + err.message);
					}
				});
			});
		</script>
		<!-- ##### Export HTML Table to XLS {END} ###### -->

		<script>
			$(document).ready(function () {
			try {
				$("#hide").click(function () {
					alert('Button "Hide" got clicked');
					$("#dvData > tfoot").empty();
					//$("select > option[value='-1']").attr("selected",true);

					$('#dvData').dataTable( {
						destroy: true,
						paging: false,
						searching: false,
						header: false
					});
					//var table = $('#dvData').dataTable();
					//table.page.len( -1 ).draw();
					alert('Button "Hide" DONE');
				})
			} catch (err) {
				alert('Caught exception: ' + err.message);
			}
			});
		</script>
		
		<!-- ##### Toggle 'SQL Query' text {START} ###### -->
		<script>
			$(document).ready(function() {
				$( "img" ).click(function() {
					var id = $(this).attr('id');
					var i = $("img#" + id);

					var p1 = $("div#" + id + ".sql");
					
					if ( i.attr('class') == 'rightImg') {
						//alert('I am NOT visible');
						p1.toggle("fast"); //$("p#" + id).toggle("fast");
						
						i.attr( 'src', './images/minus.jpg');
						i.attr('class', 'downImg');
						i.attr('title', 'Hide SQL');
					} else if ( i.attr('class') == 'downImg') {
						//alert('I am visible');
						p1.toggle("fast"); //$("p#" + id).toggle("fast");

						i.attr( 'src', './images/plus.jpg');
						i.attr('class', 'rightImg');
						i.attr('title', 'Show SQL');
					}
				});
			} );
		</script>
		<!-- ##### Toggle 'SQL Query' text {END} ###### -->
	</head>
	
	<body>
		<?php
			include "utils.php";

			//time_elapsed(" One time Incude File in Query.php: ");
			set_time_limit(0); // Set off time limit globally to avoid time out exception. TODO: There has be a better way to handle this.
			
			// Get the Product ID for which dashboard has to be displayed
			// ToDO: Block to fetch ProdID will not be required once the issue with encoder/decoder is resolved
			if(isset($_GET["prodID"])) {
				$varProdID = $_GET["prodID"];
				//echo "<h1 style='text-align:center'>Prod ID is $varProdID</h1><hr />";
			} else {
				echo "Please select a valid Product ID.";
				exit();
			}
			
			// Get the Query Seq for which dashboard has to be displayed
			if(isset($_GET["querySeq"])) {
				$varQuerySeq = $_GET["querySeq"];
				//echo "<h1 style='text-align:center'>Query Seq is $varQuerySeq</h1><hr />";
			} else {
				echo "Please select a valid Query Sequence.";
				exit();
			}

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
			
			//echo "$id --- $prodID --- $prodName --- $suiteName <br />";
			//print_r2(print_r($prodQueries, true));
/*
			// Fetch the query array from the session
			if (isset($_POST["query$varQuerySeq"])) {
				echo "query$varQuerySeq found ~~~~~~~~~~~~~~~~~~~~~~~~ <br />";
				var_dump(unserialize(base64_decode($_POST['query1'])));
				echo "##################### <br />";
				//$query = unserialize(base64_decode($_POST["query$varQuerySeq"]));
				//$query = unserialize(base64_decode($_POST["query1"]));
			} else {
				echo 'query$varQuerySeq not found';
				exit();
			}
*/
			foreach($queries as $query) {
				// Fetch details for a selected query
				$qrySeq = $query['sequence'];
				
				if ($qrySeq == $varQuerySeq) {
					$title = $query->title;
					$qryStr = $query->queryStr;
					$colNames = $query->columns->children();
					//echo "<pre>$qryStr</pre>";

					//time_elapsed("Starting to fetch data for query $qrySeq");
					
					// Fetch the column names that need to be displayed for a selected query
					$colArray = array();
					foreach($colNames as $col) {
						//echo "$col |";
						array_push($colArray, $col);
					}

					echo "
						<div class='dataTables_wrapper'>
						<table border=0 style='color=lightgrey; border-collapse:collapse' width='100%'><tbody>
							<tr style='outline: thin solid' bgcolor='lightgrey'>
								<td nowrap width='25%'><h1> $title </h1></td>
								<td width='5%'><img src='./images/plus.jpg' class='rightImg' id=qrySeq title='Show SQL' style='cursor: pointer;' height='20' width='20'/></td>
								<td width='70%'><div class='sql' style='display: none;' id=qrySeq>$qryStr</div></td>
							</tr>
						</tbody></table> </div>";

					// Layout list of all column names displayed in the table
					$ind = 0;
					echo '<div class="dataTables_wrapper"><h3>';
					echo '<b>Display Columns:</b> ';
					foreach ($colNames as $c) {
						echo "<a class=\"toggle-vis\" data-column=\"" . $ind++ ."\">$c</a> - ";
					}
					echo '</h3></div>';

					// Layout the table for selected query
					  echo "<table id='dvData';        class='display hower compact' cellspacing='0' width='100%'>";

					// Layout the table header.
					echo "<thead>";
					echo "<tr>";
					foreach ($colNames as $c) { echo "<th>$c</th>"; }
					echo "</tr>";
					
					// Layout the table header again.
/*
					echo "<tr>";
					foreach ($colNames as $c) { echo "<th>$c</th>"; }
					echo "</tr>";
					echo "</thead>";
*/	
					// Layout the table footer.
					echo '<tfoot><tr>';
					foreach ($colNames as $c) {
						echo "<th>$c</th>";
					}				
					echo '</tr></tfoot>';
	
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

					//time_elapsed("Done fetching data for query $qrySeq");
				}
			}
			
			echo '<div class="dataTables_wrapper"> <button id="exportBugs2XLS">Export Data</button> </div>';
		?>
	</body>
</html>