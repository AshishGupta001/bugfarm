	<style>
		div.dataTables_wrapper {
			margin-bottom: .5em;
			margin-left: 3em;
			margin-right: 3em;
			
			border: thin dotted white;
		}
	</style>

	<script>
		jQuery(document).ready(function () {
			$('#bugfield').keyup(function (e) {
				var charCode = e.which || e.keyCode; // for trans-browser compatibility
				txt = $('#bugfield').val(); 

				if (charCode === 13) {
					url="https://bug.oraclecorp.com/pls/bug/webbug_edit.edit_info_top?rptno=" + txt;
					window.open(url, 'mywin', 'left=100,top=50,width=1300,height=700,toolbar=1,resizable=0');
				}
			});
			
			$('#srfield').keyup(function (e) {
				var charCode = e.which || e.keyCode; // for trans-browser compatibility
				txt = $('#srfield').val(); 

				if (charCode === 13) {
					url="https://support.us.oracle.com/oip/faces/secure/ml3/sr/SRDetail.jspx?SRNumber=" + txt;
					window.open(url, 'mywin', 'left=100,top=50,width=1300,height=700,toolbar=1,resizable=0');
				}
			});
		});
	</script>

	<div class="dataTables_wrapper">
		<?php
			if(!isset($_SESSION)) { session_start(); }

			// Declare variable user and password
			$user = $pass = "";

			// Fetch user/pass from $_SESSION
			if (isset($_SESSION['authorization-user'])) {
				$user = $_SESSION['authorization-user'];
				header ("Cache-Control:no-cache");
			}
			if (isset($_SESSION['authorization-pass'])) {
				$pass = $_SESSION['authorization-pass'];
				header ("Cache-Control:no-cache");
			}
			//echo "header.php: Found user in _SESSION - $user <br>";
			//echo "header.php: Found pass in _SESSION - $pass <br>";

			// Check whether cookie with login details is set; if not redirect to login page	
			if ($user && $pass) {
				//echo "header.php: Found both user and pass - $user and $pass<br>";
				$host= gethostname();
				$ip = gethostbyname($host);

				echo "<table border=0 width='100%'><tr>";
				echo "<td width='90%' align='center' valign='middle'><h1>Bug Dashboard";
				if(isset($_PAGE_TITLE)) {echo " - $_PAGE_TITLE";}
				echo "</h1></td>";

				echo "<td width='10%' align='right'><h3>Welcome $user</h3></td>";
				echo "</tr></table>";
				//$cookie = $_COOKIE['my-secret-cookie'];
				//$content = base64_decode ($cookie);
				//list($username, $hashed_password) = explode (':', $hash);
			} else {
				$_SESSION['redirect_url'] = $_SERVER['REQUEST_URI']; //$_SERVER['PHP_SELF'];
				$x = $_SESSION['redirect_url'];
				$_SESSION['_err-msg'] = "header.php: Did not found user or pass in _SESSION. Redirecting to login.php. Will come back to $x";

				// redirect to "login" page
				header( "Location:login.php");
			}
		?>

		<form id="myform" style="margin-bottom:5px;">
			<p align="right" style="padding:0px; margin:0px;"> 
				<input id="bugfield" name="bugfield" placeholder="Bug Number" type="text" required />
				&nbsp;&nbsp;&nbsp;&nbsp;
				<input id="srfield" name="srfield" placeholder="SR Number" type="text" required /> 
			</p>
		</form>
		<hr style="padding:0px; margin:0px;" />
	</div>