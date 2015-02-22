<!doctype html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<link rel="SHORTCUT ICON" href="http://devops.oraclecorp.com/static/favicon.ico">
	<title>IDM BugDB Dashboard</title>

	<script type="text/javascript" src="../3rdParty/DataTables-1.10.3/media/js/jquery.js"></script>
	
	<!-- Style Sheets -->
	<link rel="stylesheet" href="css/jq.css" type="text/css" media="print, projection, screen" />
	<link rel="stylesheet" href="../3rdParty/DataTables-1.10.3/media/css/jquery.dataTables.css" type="text/css" media="print, projection, screen" />
		
	<style>
		.xl74498
		{padding-top:1px;
		padding-right:1px;
		padding-left:1px;
		mso-ignore:padding;
		color:black;
		font-size:14.0pt;
		font-weight:700;
		font-style:normal;
		text-decoration:none;
		font-family:Calibri, sans-serif;
		mso-font-charset:0;
		mso-number-format:General;
		text-align:center;
		vertical-align:center;
		border-top:2.0pt solid windowtext;
		border-right:2.0pt solid windowtext;
		border-bottom:2.0pt solid windowtext;
		border-left:2.0pt solid windowtext;
		mso-background-source:auto;
		mso-pattern:auto;
		white-space:nowrap;}

		.tr-Sts-1140
		{padding-top:1px;
		padding-right:1px;
		padding-left:1px;
		mso-ignore:padding;
		color:black;
		font-size:12.0pt;
		font-weight:700;
		font-style:normal;
		text-decoration:none;
		font-family:Calibri, sans-serif;
		mso-font-charset:0;
		mso-number-format:General;
		text-align:center;
		vertical-align:center;
		border-top:1.0pt solid windowtext;
		border-right:1.0pt solid windowtext;
		border-bottom:0pt solid windowtext;
		border-left:1.0pt solid windowtext;
		background-color: #E8FFFF;
		mso-background-source:auto;
		mso-pattern:auto;
		white-space:nowrap;}

		.tr-Sts-8035
		{padding-top:1px;
		padding-right:1px;
		padding-left:1px;
		mso-ignore:padding;
		color:black;
		font-size:12.0pt;
		font-weight:700;
		font-style:normal;
		text-decoration:none;
		font-family:Calibri, sans-serif;
		mso-font-charset:0;
		mso-number-format:General;
		text-align:center;
		vertical-align:center;
		border-top:1.0pt solid windowtext;
		border-right:1.0pt solid windowtext;
		border-bottom:0pt solid windowtext;
		border-left:1.0pt solid windowtext;
		background-color: #D1C2B2;
		mso-background-source:auto;
		mso-pattern:auto;
		white-space:nowrap;}
		
		.tr-Sts-3x
		{padding-top:1px;
		padding-right:1px;
		padding-left:1px;
		mso-ignore:padding;
		color:black;
		font-size:12.0pt;
		font-weight:700;
		font-style:normal;
		text-decoration:none;
		font-family:Calibri, sans-serif;
		mso-font-charset:0;
		mso-number-format:General;
		text-align:center;
		vertical-align:center;
		border-top:1.0pt solid windowtext;
		border-right:1.0pt solid windowtext;
		border-bottom:2.0pt solid windowtext;
		border-left:1.0pt solid windowtext;
		background-color: #FFFFCC;
		mso-background-source:auto;
		mso-pattern:auto;
		white-space:nowrap;}
	</style>
</head>
<body>
	<?php
		include "utils.php";
		echo "<div id='Book1_498' align=center class=\"dataTables_wrapper\">";
		include "header.php";
				
		//include "bugdb_connect.php";
		//time_elapsed(" One time Incude File in Main.php: ");
		time_elapsed(" ~~~~~~~~~~~~ STARTING ~~~~~~~~~~~~ ");
		set_time_limit(0);

		//echo '<div class="loader"></div>';
		// OIM Queries
		$qryOIM_Sts1140_All = construct_qry_str("1980", "11.1.2.3%", "1140", "All");
		$qryOIM_Sts1140_QA = construct_qry_str("1980", "11.1.2.3%", "1140", "QA");
		$qryOIM_Sts1140_Dev = construct_qry_str("1980", "11.1.2.3%", "1140", "Dev");
		$qryOIM_Sts1140_UpgPort = construct_qry_str("1980", "11.1.2.3%", "1140", "Upg/Sys");
		$qryOIM_Sts1140_PSR = construct_qry_str("1980", "11.1.2.3%", "1140", "PSR");
		$qryOIM_Sts1140_NLS = construct_qry_str("1980", "11.1.2.3%", "1140", "NLS");
		$qryOIM_Sts1140_Sup = construct_qry_str("1980", "11.1.2.3%", "1140", "Support");
		
		$qryOIM_Sts8035_All = construct_qry_str("1980", "11.1.2.3%", "8035", "All");
		$qryOIM_Sts8035_QA = construct_qry_str("1980", "11.1.2.3%", "8035", "QA");
		$qryOIM_Sts8035_Dev = construct_qry_str("1980", "11.1.2.3%", "8035", "Dev");
		$qryOIM_Sts8035_UpgPort = construct_qry_str("1980", "11.1.2.3%", "8035", "Upg/Sys");
		$qryOIM_Sts8035_PSR = construct_qry_str("1980", "11.1.2.3%", "8035", "PSR");
		$qryOIM_Sts8035_NLS = construct_qry_str("1980", "11.1.2.3%", "8035", "NLS");
		$qryOIM_Sts8035_Sup = construct_qry_str("1980", "11.1.2.3%", "8035", "Support");

		$qryOIM_Sts3x_All = construct_qry_str("1980", "11.1.2.3%", "3x", "All");
		$qryOIM_Sts3x_QA = construct_qry_str("1980", "11.1.2.3%", "3x", "QA");
		$qryOIM_Sts3x_Dev = construct_qry_str("1980", "11.1.2.3%", "3x", "Dev");
		$qryOIM_Sts3x_UpgPort = construct_qry_str("1980", "11.1.2.3%", "3x", "Upg/Sys");
		$qryOIM_Sts3x_PSR = construct_qry_str("1980", "11.1.2.3%", "3x", "PSR");
		$qryOIM_Sts3x_NLS = construct_qry_str("1980", "11.1.2.3%", "3x", "NLS");
		$qryOIM_Sts3x_Sup = construct_qry_str("1980", "11.1.2.3%", "3x", "Support");

		// OPAM Queries
		$qryOPAM_Sts1140_All = construct_qry_str("9436", "11.1.2.3%", "1140", "All");
		$qryOPAM_Sts1140_QA = construct_qry_str("9436", "11.1.2.3%", "1140", "QA");
		$qryOPAM_Sts1140_Dev = construct_qry_str("9436", "11.1.2.3%", "1140", "Dev");
		$qryOPAM_Sts1140_UpgPort = construct_qry_str("9436", "11.1.2.3%", "1140", "Upg/Sys");
		$qryOPAM_Sts1140_PSR = construct_qry_str("9436", "11.1.2.3%", "1140", "PSR");
		$qryOPAM_Sts1140_NLS = construct_qry_str("9436", "11.1.2.3%", "1140", "NLS");
		$qryOPAM_Sts1140_Sup = construct_qry_str("9436", "11.1.2.3%", "1140", "Support");
		
		$qryOPAM_Sts8035_All = construct_qry_str("9436", "11.1.2.3%", "8035", "All");
		$qryOPAM_Sts8035_QA = construct_qry_str("9436", "11.1.2.3%", "8035", "QA");
		$qryOPAM_Sts8035_Dev = construct_qry_str("9436", "11.1.2.3%", "8035", "Dev");
		$qryOPAM_Sts8035_UpgPort = construct_qry_str("9436", "11.1.2.3%", "8035", "Upg/Sys");
		$qryOPAM_Sts8035_PSR = construct_qry_str("9436", "11.1.2.3%", "8035", "PSR");
		$qryOPAM_Sts8035_NLS = construct_qry_str("9436", "11.1.2.3%", "8035", "NLS");
		$qryOPAM_Sts8035_Sup = construct_qry_str("9436", "11.1.2.3%", "8035", "Support");

		$qryOPAM_Sts3x_All = construct_qry_str("9436", "11.1.2.3%", "3x", "All");
		$qryOPAM_Sts3x_QA = construct_qry_str("9436", "11.1.2.3%", "3x", "QA");
		$qryOPAM_Sts3x_Dev = construct_qry_str("9436", "11.1.2.3%", "3x", "Dev");
		$qryOPAM_Sts3x_UpgPort = construct_qry_str("9436", "11.1.2.3%", "3x", "Upg/Sys");
		$qryOPAM_Sts3x_PSR = construct_qry_str("9436", "11.1.2.3%", "3x", "PSR");
		$qryOPAM_Sts3x_NLS = construct_qry_str("9436", "11.1.2.3%", "3x", "NLS");
		$qryOPAM_Sts3x_Sup = construct_qry_str("9436", "11.1.2.3%", "3x", "Support");

		// OAM Queries
		$qryOAM_Sts1140_All = construct_qry_str("5565", "11.1.2.3%", "1140", "All");
		$qryOAM_Sts1140_QA = construct_qry_str("5565", "11.1.2.3%", "1140", "QA");
		$qryOAM_Sts1140_Dev = construct_qry_str("5565", "11.1.2.3%", "1140", "Dev");
		$qryOAM_Sts1140_UpgPort = construct_qry_str("5565", "11.1.2.3%", "1140", "Upg/Sys");
		$qryOAM_Sts1140_PSR = construct_qry_str("5565", "11.1.2.3%", "1140", "PSR");
		$qryOAM_Sts1140_NLS = construct_qry_str("5565", "11.1.2.3%", "1140", "NLS");
		$qryOAM_Sts1140_Sup = construct_qry_str("5565", "11.1.2.3%", "1140", "Support");

		$qryOAM_Sts8035_All = construct_qry_str("5565", "11.1.2.3%", "8035", "All");
		$qryOAM_Sts8035_QA = construct_qry_str("5565", "11.1.2.3%", "8035", "QA");
		$qryOAM_Sts8035_Dev = construct_qry_str("5565", "11.1.2.3%", "8035", "Dev");
		$qryOAM_Sts8035_UpgPort = construct_qry_str("5565", "11.1.2.3%", "8035", "Upg/Sys");
		$qryOAM_Sts8035_PSR = construct_qry_str("5565", "11.1.2.3%", "8035", "PSR");
		$qryOAM_Sts8035_NLS = construct_qry_str("5565", "11.1.2.3%", "8035", "NLS");
		$qryOAM_Sts8035_Sup = construct_qry_str("5565", "11.1.2.3%", "8035", "Support");

		$qryOAM_Sts3x_All = construct_qry_str("5565", "11.1.2.3%", "3x", "All");
		$qryOAM_Sts3x_QA = construct_qry_str("5565", "11.1.2.3%", "3x", "QA");
		$qryOAM_Sts3x_Dev = construct_qry_str("5565", "11.1.2.3%", "3x", "Dev");
		$qryOAM_Sts3x_UpgPort = construct_qry_str("5565", "11.1.2.3%", "3x", "Upg/Sys");
		$qryOAM_Sts3x_PSR = construct_qry_str("5565", "11.1.2.3%", "3x", "PSR");
		$qryOAM_Sts3x_NLS = construct_qry_str("5565", "11.1.2.3%", "3x", "NLS");
		$qryOAM_Sts3x_Sup = construct_qry_str("5565", "11.1.2.3%", "3x", "Support");
		
		// APS Queries
		$qryAPS_Sts1140_All = construct_qry_str("10878", "11.1.2.3%", "1140", "All");
		$qryAPS_Sts1140_QA = construct_qry_str("10878", "11.1.2.3%", "1140", "QA");
		$qryAPS_Sts1140_Dev = construct_qry_str("10878", "11.1.2.3%", "1140", "Dev");
		$qryAPS_Sts1140_UpgPort = construct_qry_str("10878", "11.1.2.3%", "1140", "Upg/Sys");
		$qryAPS_Sts1140_PSR = construct_qry_str("10878", "11.1.2.3%", "1140", "PSR");
		$qryAPS_Sts1140_NLS = construct_qry_str("10878", "11.1.2.3%", "1140", "NLS");
		$qryAPS_Sts1140_Sup = construct_qry_str("10878", "11.1.2.3%", "1140", "Support");

		$qryAPS_Sts8035_All = construct_qry_str("10878", "11.1.2.3%", "8035", "All");
		$qryAPS_Sts8035_QA = construct_qry_str("10878", "11.1.2.3%", "8035", "QA");
		$qryAPS_Sts8035_Dev = construct_qry_str("10878", "11.1.2.3%", "8035", "Dev");
		$qryAPS_Sts8035_UpgPort = construct_qry_str("10878", "11.1.2.3%", "8035", "Upg/Sys");
		$qryAPS_Sts8035_PSR = construct_qry_str("10878", "11.1.2.3%", "8035", "PSR");
		$qryAPS_Sts8035_NLS = construct_qry_str("10878", "11.1.2.3%", "8035", "NLS");
		$qryAPS_Sts8035_Sup = construct_qry_str("10878", "11.1.2.3%", "8035", "Support");

		$qryAPS_Sts3x_All = construct_qry_str("10878", "11.1.2.3%", "3x", "All");
		$qryAPS_Sts3x_QA = construct_qry_str("10878", "11.1.2.3%", "3x", "QA");
		$qryAPS_Sts3x_Dev = construct_qry_str("10878", "11.1.2.3%", "3x", "Dev");
		$qryAPS_Sts3x_UpgPort = construct_qry_str("10878", "11.1.2.3%", "3x", "Upg/Sys");
		$qryAPS_Sts3x_PSR = construct_qry_str("10878", "11.1.2.3%", "3x", "PSR");
		$qryAPS_Sts3x_NLS = construct_qry_str("10878", "11.1.2.3%", "3x", "NLS");
		$qryAPS_Sts3x_Sup = construct_qry_str("10878", "11.1.2.3%", "3x", "Support");

		// OESSO Queries
		$qryOESSO_Sts1140_All = construct_qry_str("2074", "11.1.2.3%", "1140", "All");
		$qryOESSO_Sts1140_QA = construct_qry_str("2074", "11.1.2.3%", "1140", "QA");
		$qryOESSO_Sts1140_Dev = construct_qry_str("2074", "11.1.2.3%", "1140", "Dev");
		$qryOESSO_Sts1140_UpgPort = construct_qry_str("2074", "11.1.2.3%", "1140", "Upg/Sys");
		$qryOESSO_Sts1140_PSR = construct_qry_str("2074", "11.1.2.3%", "1140", "PSR");
		$qryOESSO_Sts1140_NLS = construct_qry_str("2074", "11.1.2.3%", "1140", "NLS");
		$qryOESSO_Sts1140_Sup = construct_qry_str("2074", "11.1.2.3%", "1140", "Support");

		$qryOESSO_Sts8035_All = construct_qry_str("2074", "11.1.2.3%", "8035", "All");
		$qryOESSO_Sts8035_QA = construct_qry_str("2074", "11.1.2.3%", "8035", "QA");
		$qryOESSO_Sts8035_Dev = construct_qry_str("2074", "11.1.2.3%", "8035", "Dev");
		$qryOESSO_Sts8035_UpgPort = construct_qry_str("2074", "11.1.2.3%", "8035", "Upg/Sys");
		$qryOESSO_Sts8035_PSR = construct_qry_str("2074", "11.1.2.3%", "8035", "PSR");
		$qryOESSO_Sts8035_NLS = construct_qry_str("2074", "11.1.2.3%", "8035", "NLS");
		$qryOESSO_Sts8035_Sup = construct_qry_str("2074", "11.1.2.3%", "8035", "Support");

		$qryOESSO_Sts3x_All = construct_qry_str("2074", "11.1.2.3%", "3x", "All");
		$qryOESSO_Sts3x_QA = construct_qry_str("2074", "11.1.2.3%", "3x", "QA");
		$qryOESSO_Sts3x_Dev = construct_qry_str("2074", "11.1.2.3%", "3x", "Dev");
		$qryOESSO_Sts3x_UpgPort = construct_qry_str("2074", "11.1.2.3%", "3x", "Upg/Sys");
		$qryOESSO_Sts3x_PSR = construct_qry_str("2074", "11.1.2.3%", "3x", "PSR");
		$qryOESSO_Sts3x_NLS = construct_qry_str("2074", "11.1.2.3%", "3x", "NLS");
		$qryOESSO_Sts3x_Sup = construct_qry_str("2074", "11.1.2.3%", "3x", "Support");
		
		// OAAM Queries
		$qryOAAM_Sts1140_All = construct_qry_str("4419", "11.1.2.3%", "1140", "All");
		$qryOAAM_Sts1140_QA = construct_qry_str("4419", "11.1.2.3%", "1140", "QA");
		$qryOAAM_Sts1140_Dev = construct_qry_str("4419", "11.1.2.3%", "1140", "Dev");
		$qryOAAM_Sts1140_UpgPort = construct_qry_str("4419", "11.1.2.3%", "1140", "Upg/Sys");
		$qryOAAM_Sts1140_PSR = construct_qry_str("4419", "11.1.2.3%", "1140", "PSR");
		$qryOAAM_Sts1140_NLS = construct_qry_str("4419", "11.1.2.3%", "1140", "NLS");
		$qryOAAM_Sts1140_Sup = construct_qry_str("4419", "11.1.2.3%", "1140", "Support");

		$qryOAAM_Sts8035_All = construct_qry_str("4419", "11.1.2.3%", "8035", "All");
		$qryOAAM_Sts8035_QA = construct_qry_str("4419", "11.1.2.3%", "8035", "QA");
		$qryOAAM_Sts8035_Dev = construct_qry_str("4419", "11.1.2.3%", "8035", "Dev");
		$qryOAAM_Sts8035_UpgPort = construct_qry_str("4419", "11.1.2.3%", "8035", "Upg/Sys");
		$qryOAAM_Sts8035_PSR = construct_qry_str("4419", "11.1.2.3%", "8035", "PSR");
		$qryOAAM_Sts8035_NLS = construct_qry_str("4419", "11.1.2.3%", "8035", "NLS");
		$qryOAAM_Sts8035_Sup = construct_qry_str("4419", "11.1.2.3%", "8035", "Support");

		$qryOAAM_Sts3x_All = construct_qry_str("4419", "11.1.2.3%", "3x", "All");
		$qryOAAM_Sts3x_QA = construct_qry_str("4419", "11.1.2.3%", "3x", "QA");
		$qryOAAM_Sts3x_Dev = construct_qry_str("4419", "11.1.2.3%", "3x", "Dev");
		$qryOAAM_Sts3x_UpgPort = construct_qry_str("4419", "11.1.2.3%", "3x", "Upg/Sys");
		$qryOAAM_Sts3x_PSR = construct_qry_str("4419", "11.1.2.3%", "3x", "PSR");
		$qryOAAM_Sts3x_NLS = construct_qry_str("4419", "11.1.2.3%", "3x", "NLS");
		$qryOAAM_Sts3x_Sup = construct_qry_str("4419", "11.1.2.3%", "3x", "Support");
		
		// OIF Queries
		$qryOIF_Sts1140_All = construct_qry_str("1741", "11.1.2.3%", "1140", "All");
		$qryOIF_Sts1140_QA = construct_qry_str("1741", "11.1.2.3%", "1140", "QA");
		$qryOIF_Sts1140_Dev = construct_qry_str("1741", "11.1.2.3%", "1140", "Dev");
		$qryOIF_Sts1140_UpgPort = construct_qry_str("1741", "11.1.2.3%", "1140", "Upg/Sys");
		$qryOIF_Sts1140_PSR = construct_qry_str("1741", "11.1.2.3%", "1140", "PSR");
		$qryOIF_Sts1140_NLS = construct_qry_str("1741", "11.1.2.3%", "1140", "NLS");
		$qryOIF_Sts1140_Sup = construct_qry_str("1741", "11.1.2.3%", "1140", "Support");

		$qryOIF_Sts8035_All = construct_qry_str("1741", "11.1.2.3%", "8035", "All");
		$qryOIF_Sts8035_QA = construct_qry_str("1741", "11.1.2.3%", "8035", "QA");
		$qryOIF_Sts8035_Dev = construct_qry_str("1741", "11.1.2.3%", "8035", "Dev");
		$qryOIF_Sts8035_UpgPort = construct_qry_str("1741", "11.1.2.3%", "8035", "Upg/Sys");
		$qryOIF_Sts8035_PSR = construct_qry_str("1741", "11.1.2.3%", "8035", "PSR");
		$qryOIF_Sts8035_NLS = construct_qry_str("1741", "11.1.2.3%", "8035", "NLS");
		$qryOIF_Sts8035_Sup = construct_qry_str("1741", "11.1.2.3%", "8035", "Support");

		$qryOIF_Sts3x_All = construct_qry_str("1741", "11.1.2.3%", "3x", "All");
		$qryOIF_Sts3x_QA = construct_qry_str("1741", "11.1.2.3%", "3x", "QA");
		$qryOIF_Sts3x_Dev = construct_qry_str("1741", "11.1.2.3%", "3x", "Dev");
		$qryOIF_Sts3x_UpgPort = construct_qry_str("1741", "11.1.2.3%", "3x", "Upg/Sys");
		$qryOIF_Sts3x_PSR = construct_qry_str("1741", "11.1.2.3%", "3x", "PSR");
		$qryOIF_Sts3x_NLS = construct_qry_str("1741", "11.1.2.3%", "3x", "NLS");
		$qryOIF_Sts3x_Sup = construct_qry_str("1741", "11.1.2.3%", "3x", "Support");
		
		// Lay down the summary table
		echo "
			<table class='display hower compact' border=0 cellpadding=0 cellspacing=0 width=850 style='border-collapse:collapse;table-layout:fixed;'>

				<col width=125 style='mso-width-source:userset;mso-width-alt:4059;width:100pt'>
				<col width=125 style='width:125pt'>
				<col width=100 style='mso-width-source:userset;mso-width-alt:3693;width:100pt'>
				<col width=100 style='mso-width-source:userset;mso-width-alt:3291;width:100pt'>
				<col width=125 style='mso-width-source:userset;mso-width-alt:3108;width:100pt'>
				<col width=100 style='mso-width-source:userset;mso-width-alt:3949;width:125pt'>
				<col width=100 span=3 style='width:100pt'>

				<tr height=21 style='height:15.75pt'>
					<td height=21 class=xl74498 width=111 style='height:15.75pt;width:83pt'>&nbsp;</td>
					<td class=xl74498 width=64 style='border-left:none;width:48pt'>&nbsp;</td>
					<td class=xl74498 width=101 style='border-left:none;width:76pt'>&nbsp;</td>
					<td class=xl74498 width=90 style='border-left:none;width:68pt'>QA Team</td>
					<td class=xl74498 width=85 style='border-left:none;width:64pt'>Upgrade / Sys</td>
					<td class=xl74498 width=108 style='border-left:none;width:81pt'>Dev Team</td>
					<td class=xl74498 width=100 style='border-left:none;width:48pt'>PSR</td>
					<td class=xl74498 width=100 style='border-left:none;width:48pt'>NLS</td>
					<td class=xl74498 width=100 style='border-left:none;width:48pt'>Support</td>
					<td class=xl74498 width=100 style='border-left:none;width:48pt'>Total</td>
				</tr>
				<tr height=20 style='height:15.0pt'>
					<td rowspan=6 height=122 class=xl74498>Governance</td>
					<td rowspan=3 class=xl74498><a href='product.php?productID=1980' target=_blank>OIM (1980)</a></td>
					<td class=tr-Sts-1140>Sts 11, 40</td>
					<td class=tr-Sts-1140>" . get_count($qryOIM_Sts1140_QA) . "</td>
					<td class=tr-Sts-1140>" . get_count($qryOIM_Sts1140_UpgPort) . "</td>
					<td class=tr-Sts-1140>" . get_count($qryOIM_Sts1140_Dev) . "</td>
					<td class=tr-Sts-1140>" . get_count($qryOIM_Sts1140_PSR) . "</td>
					<td class=tr-Sts-1140>" . get_count($qryOIM_Sts1140_NLS) . "</td>
					<td class=tr-Sts-1140>" . get_count($qryOIM_Sts1140_Sup) . "</td>
					<td class=tr-Sts-1140>" . get_count($qryOIM_Sts1140_All) . "</td>
				</tr>
				<tr height=20 style='height:15.0pt'>
					<td height=20 class=tr-Sts-8035>Sts 80, 35</td>
					<td class=tr-Sts-8035>" . get_count($qryOIM_Sts8035_QA) . "</td>
					<td class=tr-Sts-8035>" . get_count($qryOIM_Sts8035_UpgPort) . "</td>
					<td class=tr-Sts-8035>" . get_count($qryOIM_Sts8035_Dev) . "</td>
					<td class=tr-Sts-8035>" . get_count($qryOIM_Sts8035_PSR) . "</td>
					<td class=tr-Sts-8035>" . get_count($qryOIM_Sts8035_NLS) . "</td>
					<td class=tr-Sts-8035>" . get_count($qryOIM_Sts8035_Sup) . "</td>
					<td class=tr-Sts-8035>" . get_count($qryOIM_Sts8035_All) . "</td>
				</tr>
				<tr height=21 style='height:15.75pt'>
					<td height=21 class=tr-Sts-3x>Sts 3x</td>
					<td class=tr-Sts-3x>" . get_count($qryOIM_Sts3x_QA) . "</td>
					<td class=tr-Sts-3x>" . get_count($qryOIM_Sts3x_UpgPort) . "</td>
					<td class=tr-Sts-3x>" . get_count($qryOIM_Sts3x_Dev) . "</td>
					<td class=tr-Sts-3x>" . get_count($qryOIM_Sts3x_PSR) . "</td>
					<td class=tr-Sts-3x>" . get_count($qryOIM_Sts3x_NLS) . "</td>
					<td class=tr-Sts-3x>" . get_count($qryOIM_Sts3x_Sup) . "</td>
					<td class=tr-Sts-3x>" . get_count($qryOIM_Sts3x_All) . "</td>
				</tr>

				<!-- ~~~~~~~~~~~~~~~~~~~~ OPAM ~~~~~~~~~~~~~~~~~~~~ -->
				<tr height=20 style='height:15.0pt'>
					<td rowspan=3 class=xl74498><a href='product.php?productID=9436' target=_blank>OPAM (9436)</a></td>
					<td class=tr-Sts-1140>Sts 11, 40</td>
					<td class=tr-Sts-1140>" . get_count($qryOPAM_Sts1140_QA) . "</td>
					<td class=tr-Sts-1140>" . get_count($qryOPAM_Sts1140_UpgPort) . "</td>
					<td class=tr-Sts-1140>" . get_count($qryOPAM_Sts1140_Dev) . "</td>
					<td class=tr-Sts-1140>" . get_count($qryOPAM_Sts1140_PSR) . "</td>
					<td class=tr-Sts-1140>" . get_count($qryOPAM_Sts1140_NLS) . "</td>
					<td class=tr-Sts-1140>" . get_count($qryOPAM_Sts1140_Sup) . "</td>
					<td class=tr-Sts-1140>" . get_count($qryOPAM_Sts1140_All) . "</td>
				</tr>
				<tr height=20 style='height:15.0pt'>
					<td height=20 class=tr-Sts-8035>Sts 80, 35</td>
					<td class=tr-Sts-8035>" . get_count($qryOPAM_Sts8035_QA) . "</td>
					<td class=tr-Sts-8035>" . get_count($qryOPAM_Sts8035_UpgPort) . "</td>
					<td class=tr-Sts-8035>" . get_count($qryOPAM_Sts8035_Dev) . "</td>
					<td class=tr-Sts-8035>" . get_count($qryOPAM_Sts8035_PSR) . "</td>
					<td class=tr-Sts-8035>" . get_count($qryOPAM_Sts8035_NLS) . "</td>
					<td class=tr-Sts-8035>" . get_count($qryOPAM_Sts8035_Sup) . "</td>
					<td class=tr-Sts-8035>" . get_count($qryOPAM_Sts8035_All) . "</td>
				</tr>
				<tr height=21 style='height:15.75pt'>
					<td height=21 class=tr-Sts-3x>Sts 3x</td>
					<td class=tr-Sts-3x>" . get_count($qryOPAM_Sts3x_QA) . "</td>
					<td class=tr-Sts-3x>" . get_count($qryOPAM_Sts3x_UpgPort) . "</td>
					<td class=tr-Sts-3x>" . get_count($qryOPAM_Sts3x_Dev) . "</td>
					<td class=tr-Sts-3x>" . get_count($qryOPAM_Sts3x_PSR) . "</td>
					<td class=tr-Sts-3x>" . get_count($qryOPAM_Sts3x_NLS) . "</td>
					<td class=tr-Sts-3x>" . get_count($qryOPAM_Sts3x_Sup) . "</td>
					<td class=tr-Sts-3x>" . get_count($qryOPAM_Sts3x_All) . "</td>
				</tr>

				<!-- ~~~~~~~~~~~~~~~~~~~~ OAM ~~~~~~~~~~~~~~~~~~~~ -->
				<tr height=20 style='height:15.0pt'>
					<td rowspan=15 height=122 class=xl74498>Access</td>
					<td rowspan=3 class=xl74498><a href='product.php?productID=5565' target=_blank>OAM (5565)</a></td>
					<td class=tr-Sts-1140>Sts 11, 40</td>
					<td class=tr-Sts-1140>" . get_count($qryOAM_Sts1140_QA) . "</td>
					<td class=tr-Sts-1140>" . get_count($qryOAM_Sts1140_UpgPort) . "</td>
					<td class=tr-Sts-1140>" . get_count($qryOAM_Sts1140_Dev) . "</td>
					<td class=tr-Sts-1140>" . get_count($qryOAM_Sts1140_PSR) . "</td>
					<td class=tr-Sts-1140>" . get_count($qryOAM_Sts1140_NLS) . "</td>
					<td class=tr-Sts-1140>" . get_count($qryOAM_Sts1140_Sup) . "</td>
					<td class=tr-Sts-1140>" . get_count($qryOAM_Sts1140_All) . "</td>
				</tr>
				<tr height=20 style='height:15.0pt'>
					<td height=20 class=tr-Sts-8035>Sts 80, 35</td>
					<td class=tr-Sts-8035>" . get_count($qryOAM_Sts8035_QA) . "</td>
					<td class=tr-Sts-8035>" . get_count($qryOAM_Sts8035_UpgPort) . "</td>
					<td class=tr-Sts-8035>" . get_count($qryOAM_Sts8035_Dev) . "</td>
					<td class=tr-Sts-8035>" . get_count($qryOAM_Sts8035_PSR) . "</td>
					<td class=tr-Sts-8035>" . get_count($qryOAM_Sts8035_NLS) . "</td>
					<td class=tr-Sts-8035>" . get_count($qryOAM_Sts8035_Sup) . "</td>
					<td class=tr-Sts-8035>" . get_count($qryOAM_Sts8035_All) . "</td>
				</tr>
				<tr height=21 style='height:15.75pt'>
					<td height=21 class=tr-Sts-3x>Sts 3x</td>
					<td class=tr-Sts-3x>" . get_count($qryOAM_Sts3x_QA) . "</td>
					<td class=tr-Sts-3x>" . get_count($qryOAM_Sts3x_UpgPort) . "</td>
					<td class=tr-Sts-3x>" . get_count($qryOAM_Sts3x_Dev) . "</td>
					<td class=tr-Sts-3x>" . get_count($qryOAM_Sts3x_PSR) . "</td>
					<td class=tr-Sts-3x>" . get_count($qryOAM_Sts3x_NLS) . "</td>
					<td class=tr-Sts-3x>" . get_count($qryOAM_Sts3x_Sup) . "</td>
					<td class=tr-Sts-3x>" . get_count($qryOAM_Sts3x_All) . "</td>
				</tr>
				<!-- ~~~~~~~~~~~~~~~~~~~~ APS ~~~~~~~~~~~~~~~~~~~~ -->
				<tr height=20 style='height:15.0pt'>
					<td rowspan=3 class=xl74498><a href='product.php?productID=10878' target=_blank>APS (10878)</a></td>
					<td class=tr-Sts-1140>Sts 11, 40</td>
					<td class=tr-Sts-1140>" . get_count($qryAPS_Sts1140_QA) . "</td>
					<td class=tr-Sts-1140>" . get_count($qryAPS_Sts1140_UpgPort) . "</td>
					<td class=tr-Sts-1140>" . get_count($qryAPS_Sts1140_Dev) . "</td>
					<td class=tr-Sts-1140>" . get_count($qryAPS_Sts1140_PSR) . "</td>
					<td class=tr-Sts-1140>" . get_count($qryAPS_Sts1140_NLS) . "</td>
					<td class=tr-Sts-1140>" . get_count($qryAPS_Sts1140_Sup) . "</td>
					<td class=tr-Sts-1140>" . get_count($qryAPS_Sts1140_All) . "</td>
				</tr>
				<tr height=20 style='height:15.0pt'>
					<td height=20 class=tr-Sts-8035>Sts 80, 35</td>
					<td class=tr-Sts-8035>" . get_count($qryAPS_Sts8035_QA) . "</td>
					<td class=tr-Sts-8035>" . get_count($qryAPS_Sts8035_UpgPort) . "</td>
					<td class=tr-Sts-8035>" . get_count($qryAPS_Sts8035_Dev) . "</td>
					<td class=tr-Sts-8035>" . get_count($qryAPS_Sts8035_PSR) . "</td>
					<td class=tr-Sts-8035>" . get_count($qryAPS_Sts8035_NLS) . "</td>
					<td class=tr-Sts-8035>" . get_count($qryAPS_Sts8035_Sup) . "</td>
					<td class=tr-Sts-8035>" . get_count($qryAPS_Sts8035_All) . "</td>
				</tr>
				<tr height=21 style='height:15.75pt'>
					<td height=21 class=tr-Sts-3x>Sts 3x</td>
					<td class=tr-Sts-3x>" . get_count($qryAPS_Sts3x_QA) . "</td>
					<td class=tr-Sts-3x>" . get_count($qryAPS_Sts3x_UpgPort) . "</td>
					<td class=tr-Sts-3x>" . get_count($qryAPS_Sts3x_Dev) . "</td>
					<td class=tr-Sts-3x>" . get_count($qryAPS_Sts3x_PSR) . "</td>
					<td class=tr-Sts-3x>" . get_count($qryAPS_Sts3x_NLS) . "</td>
					<td class=tr-Sts-3x>" . get_count($qryAPS_Sts3x_Sup) . "</td>
					<td class=tr-Sts-3x>" . get_count($qryAPS_Sts3x_All) . "</td>
				<!-- ~~~~~~~~~~~~~~~~~~~~ OESSO ~~~~~~~~~~~~~~~~~~~~ -->
				<tr height=20 style='height:15.0pt'>
					<td rowspan=3 class=xl74498><a href='product.php?productID=2074' target=_blank>OESSO (2074)</a></td>
					<td class=tr-Sts-1140>Sts 11, 40</td>
					<td class=tr-Sts-1140>" . get_count($qryOESSO_Sts1140_QA) . "</td>
					<td class=tr-Sts-1140>" . get_count($qryOESSO_Sts1140_UpgPort) . "</td>
					<td class=tr-Sts-1140>" . get_count($qryOESSO_Sts1140_Dev) . "</td>
					<td class=tr-Sts-1140>" . get_count($qryOESSO_Sts1140_PSR) . "</td>
					<td class=tr-Sts-1140>" . get_count($qryOESSO_Sts1140_NLS) . "</td>
					<td class=tr-Sts-1140>" . get_count($qryOESSO_Sts1140_Sup) . "</td>
					<td class=tr-Sts-1140>" . get_count($qryOESSO_Sts1140_All) . "</td>
				</tr>
				<tr height=20 style='height:15.0pt'>
					<td height=20 class=tr-Sts-8035>Sts 80, 35</td>
					<td class=tr-Sts-8035>" . get_count($qryOESSO_Sts8035_QA) . "</td>
					<td class=tr-Sts-8035>" . get_count($qryOESSO_Sts8035_UpgPort) . "</td>
					<td class=tr-Sts-8035>" . get_count($qryOESSO_Sts8035_Dev) . "</td>
					<td class=tr-Sts-8035>" . get_count($qryOESSO_Sts8035_PSR) . "</td>
					<td class=tr-Sts-8035>" . get_count($qryOESSO_Sts8035_NLS) . "</td>
					<td class=tr-Sts-8035>" . get_count($qryOESSO_Sts8035_Sup) . "</td>
					<td class=tr-Sts-8035>" . get_count($qryOESSO_Sts8035_All) . "</td>
				</tr>
				<tr height=21 style='height:15.75pt'>
					<td height=21 class=tr-Sts-3x>Sts 3x</td>
					<td class=tr-Sts-3x>" . get_count($qryOESSO_Sts3x_QA) . "</td>
					<td class=tr-Sts-3x>" . get_count($qryOESSO_Sts3x_UpgPort) . "</td>
					<td class=tr-Sts-3x>" . get_count($qryOESSO_Sts3x_Dev) . "</td>
					<td class=tr-Sts-3x>" . get_count($qryOESSO_Sts3x_PSR) . "</td>
					<td class=tr-Sts-3x>" . get_count($qryOESSO_Sts3x_NLS) . "</td>
					<td class=tr-Sts-3x>" . get_count($qryOESSO_Sts3x_Sup) . "</td>
					<td class=tr-Sts-3x>" . get_count($qryOESSO_Sts3x_All) . "</td>
				<!-- ~~~~~~~~~~~~~~~~~~~~ OAAM ~~~~~~~~~~~~~~~~~~~~ -->
				<tr height=20 style='height:15.0pt'>
					<td rowspan=3 class=xl74498><a href='product.php?productID=4419' target=_blank>OAAM (4419)</a></td>
					<td class=tr-Sts-1140>Sts 11, 40</td>
					<td class=tr-Sts-1140>" . get_count($qryOAAM_Sts1140_QA) . "</td>
					<td class=tr-Sts-1140>" . get_count($qryOAAM_Sts1140_UpgPort) . "</td>
					<td class=tr-Sts-1140>" . get_count($qryOAAM_Sts1140_Dev) . "</td>
					<td class=tr-Sts-1140>" . get_count($qryOAAM_Sts1140_PSR) . "</td>
					<td class=tr-Sts-1140>" . get_count($qryOAAM_Sts1140_NLS) . "</td>
					<td class=tr-Sts-1140>" . get_count($qryOAAM_Sts1140_Sup) . "</td>
					<td class=tr-Sts-1140>" . get_count($qryOAAM_Sts1140_All) . "</td>
				</tr>
				<tr height=20 style='height:15.0pt'>
					<td height=20 class=tr-Sts-8035>Sts 80, 35</td>
					<td class=tr-Sts-8035>" . get_count($qryOAAM_Sts8035_QA) . "</td>
					<td class=tr-Sts-8035>" . get_count($qryOAAM_Sts8035_UpgPort) . "</td>
					<td class=tr-Sts-8035>" . get_count($qryOAAM_Sts8035_Dev) . "</td>
					<td class=tr-Sts-8035>" . get_count($qryOAAM_Sts8035_PSR) . "</td>
					<td class=tr-Sts-8035>" . get_count($qryOAAM_Sts8035_NLS) . "</td>
					<td class=tr-Sts-8035>" . get_count($qryOAAM_Sts8035_Sup) . "</td>
					<td class=tr-Sts-8035>" . get_count($qryOAAM_Sts8035_All) . "</td>
				</tr>
				<tr height=21 style='height:15.75pt'>
					<td height=21 class=tr-Sts-3x>Sts 3x</td>
					<td class=tr-Sts-3x>" . get_count($qryOAAM_Sts3x_QA) . "</td>
					<td class=tr-Sts-3x>" . get_count($qryOAAM_Sts3x_UpgPort) . "</td>
					<td class=tr-Sts-3x>" . get_count($qryOAAM_Sts3x_Dev) . "</td>
					<td class=tr-Sts-3x>" . get_count($qryOAAM_Sts3x_PSR) . "</td>
					<td class=tr-Sts-3x>" . get_count($qryOAAM_Sts3x_NLS) . "</td>
					<td class=tr-Sts-3x>" . get_count($qryOAAM_Sts3x_Sup) . "</td>
					<td class=tr-Sts-3x>" . get_count($qryOAAM_Sts3x_All) . "</td>
				<!-- ~~~~~~~~~~~~~~~~~~~~ OIF ~~~~~~~~~~~~~~~~~~~~ -->
				<tr height=20 style='height:15.0pt'>
					<td rowspan=3 class=xl74498><a href='product.php?productID=1741' target=_blank>OIF (1741)</a></td>
					<td class=tr-Sts-1140>Sts 11, 40</td>
					<td class=tr-Sts-1140>" . get_count($qryOIF_Sts1140_QA) . "</td>
					<td class=tr-Sts-1140>" . get_count($qryOIF_Sts1140_UpgPort) . "</td>
					<td class=tr-Sts-1140>" . get_count($qryOIF_Sts1140_Dev) . "</td>
					<td class=tr-Sts-1140>" . get_count($qryOIF_Sts1140_PSR) . "</td>
					<td class=tr-Sts-1140>" . get_count($qryOIF_Sts1140_NLS) . "</td>
					<td class=tr-Sts-1140>" . get_count($qryOIF_Sts1140_Sup) . "</td>
					<td class=tr-Sts-1140>" . get_count($qryOIF_Sts1140_All) . "</td>
				</tr>
				<tr height=20 style='height:15.0pt'>
					<td height=20 class=tr-Sts-8035>Sts 80, 35</td>
					<td class=tr-Sts-8035>" . get_count($qryOIF_Sts8035_QA) . "</td>
					<td class=tr-Sts-8035>" . get_count($qryOIF_Sts8035_UpgPort) . "</td>
					<td class=tr-Sts-8035>" . get_count($qryOIF_Sts8035_Dev) . "</td>
					<td class=tr-Sts-8035>" . get_count($qryOIF_Sts8035_PSR) . "</td>
					<td class=tr-Sts-8035>" . get_count($qryOIF_Sts8035_NLS) . "</td>
					<td class=tr-Sts-8035>" . get_count($qryOIF_Sts8035_Sup) . "</td>
					<td class=tr-Sts-8035>" . get_count($qryOIF_Sts8035_All) . "</td>
				</tr>
				<tr height=21 style='height:15.75pt'>
					<td height=21 class=tr-Sts-3x>Sts 3x</td>
					<td class=tr-Sts-3x>" . get_count($qryOIF_Sts3x_QA) . "</td>
					<td class=tr-Sts-3x>" . get_count($qryOIF_Sts3x_UpgPort) . "</td>
					<td class=tr-Sts-3x>" . get_count($qryOIF_Sts3x_Dev) . "</td>
					<td class=tr-Sts-3x>" . get_count($qryOIF_Sts3x_PSR) . "</td>
					<td class=tr-Sts-3x>" . get_count($qryOIF_Sts3x_NLS) . "</td>
					<td class=tr-Sts-3x>" . get_count($qryOIF_Sts3x_Sup) . "</td>
					<td class=tr-Sts-3x>" . get_count($qryOIF_Sts3x_All) . "</td>
				</tr>
			</table>
		</div>";
		time_elapsed("");
	?>

	<?php
		function construct_qry_str($prodID, $compVer, $status, $org) {
			switch ($org) {
				case "QA": 
					$strOrg = " and h.rptd_by IN (SELECT bug_username FROM BUG_USER START WITH full_email=upper('mike.hwa') CONNECT BY PRIOR full_email=manager_email )";
					$titleOrg = "QA (mike.hwa)";
					break;
				case "Dev":
					$strOrg = " and h.rptd_by IN (SELECT bug_username FROM BUG_USER START WITH full_email=upper('shirish.puranik') CONNECT BY PRIOR full_email=manager_email union SELECT bug_username FROM BUG_USER START WITH full_email=upper('pervez.goiporia') CONNECT BY PRIOR full_email=manager_email )";
					$titleOrg = "Development (amit.jasuja)";
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
					$titleOrg = "Support (yongqing.jiang)";
					break;
			}

			switch ($status) {
				case "1140": 
					$strStatus = " and upper( h.utility_version) like upper('" . $compVer . "') and h.status in (11, 40)";
					$titleStatus = "11 & 40";
					break;
				case "8035":
					$strStatus = " and upper( h.version_fixed) like upper('" . $compVer . "') and h.status in (35, 80)";
					$titleStatus = "80 & 35";
					break;
				case "3x":
					$strStatus = " and upper( h.utility_version) like upper('" . $compVer . "') and h.status in (30, 31, 32, 36)";
					$titleStatus = "30, 31, 32 & 36";
					break;
			}

			$whereStr = "h.product_id = ". $prodID . $strStatus . $strOrg;
			$title = "Status " . $titleStatus . " - Org " . $titleOrg ;
			$pageTitle = "Product " . $prodID;

			return ($whereStr . " ^ " . $title . " ^ " . $pageTitle);
		}
	?>
</body>
</html>