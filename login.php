<html>
<head>
	<title>Bug Dashboard - Login</title>
	<link rel="SHORTCUT ICON" href="./images/bug3.ico">
	
	<style>
		table {
			border: 2px dashed #856452;
			border-collapse: collapse;
			margin-top:30em;
		}

		#errMsg {
			color: red; 
  			font-family:arial; 
  			font-size: 15pt; 
		}
	</style>
	
	<style type="text/css">
		.watermark {
			background:url(./images/bug_farm.jpg) fixed top center no-repeat;
			z-index: -1;
			opacity: 0.5;
			width: 98%;
			height: 98%;
			top: -100px;
			position: absolute;
		}
	</style>
</head>

<body>
	<?php
		if(!isset($_SESSION)) { session_start(); } 

		if(isset($_POST['login_button'])) {
			$user = $_POST['username'];
			$pass = $_POST['password'];
			if(isset($_POST['rememberMe'])){$remMe = true;} else {$remMe = false;}
			if(isset($_SESSION['redirect_url'])) {$redirectURL = $_SESSION['redirect_url'];} else {$redirectURL = '/dashboard/main.pphp';}

			// Save user & password in the session
			$_SESSION['authorization-user'] = $user;
			$_SESSION['authorization-pass'] = $pass;

			if( $user && $pass ) {
				echo "login.php: Username and password are provided - $user and $pass<br>";
				if ($remMe) {
					echo "login.php: remMe is checked<br>";
					setcookie("authorization-user", $user );
					setcookie("authorization-pass", $pass );
				} else {
					echo "login.php: remMe is NOT checked<br>";
					setcookie("authorization-user", "", 1 );
					setcookie("authorization-pass", "", 1 );
				}

				// Load product details from product.xml
				$prodXML = simplexml_load_file('product.xml');
				$_SESSION['productsXML'] = $prodXML->asXML();

				echo "login.php on submit: Page to be redirected is - $redirectURL <br>";
				//header( "Location:header.php");
				//header( "Location:main.php");
				header("Location:$redirectURL");

				exit();				
			} else {
				echo "Username or password are not provided<br>";
			}
		}
	?>
	<div align="center" valign="center" >
		<?php 
			if(!isset($_SESSION)) { session_start(); }

			// Check whether cookie is set. If yes, fetch username and password
			if (isset($_COOKIE['authorization-user'])) {
				$user = $_COOKIE['authorization-user'];
				$_SESSION['authorization-user'] = $user;
				//echo "login.php: Found user in _COOKIE <br>";
			}
			if (isset($_COOKIE['authorization-pass'])) {
				$pass = $_COOKIE['authorization-pass'];
				$_SESSION['authorization-pass'] = $pass;
				//echo "login.php: Found passowrd in _COOKIE <br>";
			}
			header ("Cache-Control:no-cache");

			$errMsg = "&nbsp;";
			if(isset($_SESSION['_err-msg'])) {
				//echo "<div id=errMsg>" . $_SESSION['_err-msg'] . "</div>"; // . "<br>";
				$errMsg = $_SESSION['_err-msg'];
				unset($_SESSION['_err-msg']);
			}

			echo "<div id=errMsg>" . $errMsg . "</div>"; // . "<br>";
		?>

		<div class="watermark"></div>

		<form method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>"  >
			<table cellpadding=5>
				<tr><td colspan=2 align="center"><h2>Bug In</h2></td></tr> <tr><td colspan=2>&nbsp;</td></tr>
				<tr>
					<td align="right"><b>Username:</b></td> <td><input display="box" type="text" name="username" required value="<?php if(isset($user)) echo $user; ?>"> </td>
				</tr>
				<tr>
					<td align="right"><b>Password:</b></td> <td> <input display="box" type="password" name="password" required value="<?php if(isset($pass)) echo $pass; ?>"></td>
				</tr>
				<tr>
					<td align="right"><b>Remember Me:</b></td> <td><input type="checkbox" name="rememberMe" checked> </td>
				</tr>
				<tr>
					<td colspan=2 align="center"><input type="submit" name="login_button" value="Log In" style="height:25px; width:200px"> </td>
				</tr>
				<tr><td colspan=2>&nbsp;</td></tr> <tr><td colspan=2>&nbsp;</td></tr>
			</table>
		</form>

	</div>
</body>
</html>