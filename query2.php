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
		<script type="text/javascript" src="../3rdParty/DataTables-Plugins/dataTables.colReorder.js"></script>

		<!-- Java Scripts to support export data to Excel -->
		<script src="js/jquery.base64.js"></script>
		<script src="js/jquery.btechco.excelexport.js"></script>  <!-- <script src="js/jquery.battatech.excelexport.min.js"> </script> -->

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
<!--
		<script>
			$(document).ready(function() {
    			$('#dvData').DataTable({
        			dom: 'Rlfrtip'
    			});
			});
		</script>
-->
		<!-- For enabling column re-ordering  END -->

		<script>
			$(document).ready(function() {
				$('#dvData').dataTable( {
					"lengthMenu": [[25, 50, -1], [25, 50, "All"]],
					dom: 'Rlfrtip' <!-- For enabling column re-ordering -->
				} );
			} );
		</script>
 
 
 		<script>
			// Script to implement 'text' search at each column
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


		<script>
		// Script to implement 'drop down' search at each column
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


		<!--
		// For enabling X & Y scrolling {START}
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
		// For enabling X & Y scrolling {END}
		-->

		<!-- For enabling multi table pagination -->
		<style>
			div.dataTables_wrapper {
				margin-bottom: 1em;
				margin-left: 3em;
				margin-right: 3em;
			}
		</style>
		
		<!-- Export HTML Table to XLS -->
		<script>
			$(document).ready(function () {
				$("#exportBugs2XLS").click(function () {
					try {
						//$("#dvData > tfoot").hide(); //does not work
						var foot = $("#dvData > tfoot").html();
						//alert (foot);
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
						/*
						var uri = $("#dvData").btechco_excelexport({
							containerid: "dvData", 
							datatype: $datatype.Table,
							returnUri: true
						});
						$(this).attr('download', 'ExportToExcel.xls') // set file name (you want to put formatted date here)
							   .attr('href', uri)                     // data to download
							   .attr('target', '_blank')              // open in new window (optional)
						;
						*/
						
						$("#dvData").btechco_excelexport({
							containerid: "dvData", 
							datatype: $datatype.Table
						});
					} catch(err) {
						var_dump(err);
						alert('Caught exception: ' + err.message);
					}
					
					try {
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
		
		<script>
			$(document).ready(function () {
			try {
				$("#hide").click(function () {
					//alert('Button "Hide" got clicked');
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
					//alert('Button "Hide" DONE');
				})
			} catch (err) {
				alert('Caught exception: ' + err.message);
			}
			});
		</script>

		// ######## Page Loading animation {START} ########
		<script>		
			var $loading = $('#loadingDiv').hide();
			$(document)
			  .ajaxStart(function () {
				$loading.show();
			  })
			  .ajaxStop(function () {
				$loading.hide();
			  });
		</script>
		// ######## Page Loading animation {END} ########

		// ######## Dynamically Show/Hide columns in table START ########
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
		// ######## Dynamically Show/Hide columns in table {END} ########
		
		// ######## Toggle 'SQL Query' text {START} ########
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
		// ######## Toggle 'SQL Query' text {END} ########
	</head>
	
	<body>
		<?php
			include "utils.php";
			//include "header.php";

			//time_elapsed(" One time Incude File in Query.php: ");
			set_time_limit(0); // Set off time limit globally to avoid time out exception. TODO: There has be a better way to handle this.
			
			//echo '<div id="loadingDiv">Data is being loaded</div>';
			
			// Get the Product ID for which dashboard has to be displayed
			// ToDO: Block to fetch whereClause will not be required once the issue with encoder/decoder is resolved
			if(isset($_GET["whereClause"])) {
				$varWhereClause = $_GET["whereClause"];
			} else {
				echo "Please select a valid WHERE clause.";
				exit();
			}

			if(isset($_GET["title"])) {
				$varTitle = $_GET["title"];
			} else {
				$varTitle = "No title set";
			}

			if(isset($_GET["pageTitle"])) {
				$varPageTitle = $_GET["pageTitle"];
			} else {
				$varTitle = "No Page title set";
			}
			
			// Set the page title
			$_PAGE_TITLE = "$varPageTitle";

			include "header.php";

			//$title = $query->title;
			$bugNo = "				
				'<a href=\"https://bug.oraclecorp.com/pls/bug/webbug_edit.edit_info_top?rptno=' || h.rptno || '\" onclick=\"window.open(this.href, ''mywin'', ''left=100,top=50,width=1000,height=600,toolbar=1,resizable=0''); return false;\">' || h.rptno || '</a>' 		
			";
			
			$qryStr  = "select " . $bugNo . ", h.rptdate,h.rptd_by,h.programmer,h.status, h.category, h.utility_version, h.version_fixed,h.fixed_date, round(sysdate - h.fixed_date, 0),h.subject,h.product_id from rpthead h where " . $varWhereClause;
			
			$colNames = ["Bug ID","Reported", "Filer","Assignee", "Status", "Component", "Component Ver", "Fixed Ver","Fixed", "Days Fixed", "Subject", "Product ID"];

			echo "
				<div class='dataTables_wrapper'>
				<table border=0 width='100%'><tbody>
					<tr>
						<td nowrap width='25%'><h1> $varTitle </h1></td>
						<td width='5%'><img src='./images/plus.jpg' class='rightImg' id=1 title='Show SQL' style='cursor: pointer;' /></td>
						<td width='70%'><div class='sql' style='display: none; border: thin solid black;' id=1><h4 style='margin-left:10px;'>$qryStr</h4></div></td>
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
			echo "<table id='dvData'; class='display hower compact' cellspacing='0' width='100%'>";

			// Fetch the column names that need to be displayed for a selected query
			$colArray = array();
			foreach($colNames as $col) {
				//echo "$col |";
				array_push($colArray, $col);
			}
			//echo "Column names for query - $title are <br/>";

			// Layout the table header.
			echo "<thead><tr>";
			foreach ($colNames as $c) {
				echo "<th>$c</th>";
			}
			echo '</tr></thead>';

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
			
			echo '<div class="dataTables_wrapper"> <button id="exportBugs2XLS">Export Data</button> </div>';
		?>
	</body>
</html>