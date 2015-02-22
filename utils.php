<?php 
// ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ Helper Functions ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
/*
	// DB connection object
	function db_connection() {
		// Connects to the XE service (i.e. database) on the "localhost" machine
		$db = "(DESCRIPTION=(ADDRESS=(PROTOCOL=TCP)(HOST=amogridxp01-scan.us.oracle.com)(PORT=1523))(CONNECT_DATA=(SERVER=DEDICATED)(SERVICE_NAME=bugap_adx.us.oracle.com)))";
		//global $conn;
		$conn = oci_connect('ASHGUPT', 'PA2$7ZFFA', $db);
		if (!$conn) {
			$e = oci_error();
			trigger_error(htmlentities($e['message'], ENT_QUOTES), E_USER_ERROR);
		} else {
			//echo "DB Connection successful! <br/>";
		}
	}
*/
	function execute_sql($sqlQuery) {
			include "bugdb_connect.php"; 			//include_once "bugdb_connect.php";
			//time_elapsed(" >>>>>>>>>>>>>> Incude File: ");
			//echo $sqlQuery . "<br />";
			$rs = oci_parse($conn, $sqlQuery);
			//time_elapsed(" >>>>>>>>>>>>>> OCI Parse: ");
			oci_execute($rs);
			//time_elapsed(" >>>>>>>>>>>>>> OCI Execute: ");
			
			return $rs;
		}
	
	function get_count($inputStr) {
		//$sqlQuery = "select 1 as cnt from dual";
		$pos1 = strpos($inputStr, "^");
		$pos2 = strpos($inputStr, "^", $pos1+1);
		$whereClause = substr($inputStr, 0, $pos1);
		$title = substr($inputStr, $pos1+1, $pos2 - $pos1-1);
		$pageTitle = substr($inputStr, $pos2+1);
		//echo $pos1 . " - " . $pos2; echo "<br>";
		
		$cntQuery = "select count(*) as cnt from rpthead h where " . $whereClause;
		//$linkSQL = "select " . $bugNo . ", h.rptdate,h.rptd_by,h.programmer,h.status, h.category, h.version_fixed,h.fixed_date, round(sysdate - h.fixed_date, 0),h.subject,h.product_id from rpthead h where " . $whereClause;
		$rs = execute_sql($cntQuery);
		//time_elapsed(" >>>>>> Execute SQL: ");
		//$rsOIM_Sts1140_All = execute_sql($qryOIM_Sts1140_All);
		$row = oci_fetch_array($rs, OCI_ASSOC);
		//time_elapsed(" >>>>>> Fetch Array : ");
		//time_elapsed(" ~~~~~~~~~~~~ DONE ~~~~~~~~~~~~ ");
		
		//return $row['CNT'];
		$count = $row['CNT'];
		//$str = "<a href=\"query2.php?whereClause=" . urlencode($whereClause) . "&title=" . urlencode($title) . "\" target=_blank>$count</a>";
		$str = "<a href=\"query2.php?whereClause=" . urlencode($whereClause) . "&title=" . urlencode($title) . "&pageTitle=" . urlencode($pageTitle) . "\" target=_blank>$count</a>";
		//$str = "<a href=\"query2.php?whereClause=" . urlencode($whereClause) . "\" target=_blank>$count</a>";
		//echo $str;
		//if ($rtnType = 0) {return $count;} else if (($rtnType = 1)) {return $str;}
		//return $count; 
		return $str;
	}

	function get_count_n($inputStr) {
		//$sqlQuery = "select 1 as cnt from dual";
		$pos1 = strpos($inputStr, "^");
		$pos2 = strpos($inputStr, "^", $pos1+1);
		$whereClause = substr($inputStr, 0, $pos1);
		$title = substr($inputStr, $pos1+1, $pos2 - $pos1-1);
		$pageTitle = substr($inputStr, $pos2+1);
		//echo $pos1 . " - " . $pos2; echo "<br>";
		
		$cntQuery = "select count(*) as cnt from rpthead h where " . $whereClause;
		//$linkSQL = "select " . $bugNo . ", h.rptdate,h.rptd_by,h.programmer,h.status, h.category, h.version_fixed,h.fixed_date, round(sysdate - h.fixed_date, 0),h.subject,h.product_id from rpthead h where " . $whereClause;
		$rs = execute_sql($cntQuery);
		//time_elapsed(" >>>>>> Execute SQL: ");
		//$rsOIM_Sts1140_All = execute_sql($qryOIM_Sts1140_All);
		$row = oci_fetch_array($rs, OCI_ASSOC);
		//time_elapsed(" >>>>>> Fetch Array : ");
		//time_elapsed(" ~~~~~~~~~~~~ DONE ~~~~~~~~~~~~ ");
		
		//return $row['CNT'];
		$count = $row['CNT'];
		//$str = "<a href=\"query2.php?whereClause=" . urlencode($whereClause) . "&title=" . urlencode($title) . "\" target=_blank>$count</a>";
		$str = "<a href=\"query2.php?whereClause=" . urlencode($whereClause) . "&title=" . urlencode($title) . "&pageTitle=" . urlencode($pageTitle) . "\" target=_blank>$count</a>";
		//$str = "<a href=\"query2.php?whereClause=" . urlencode($whereClause) . "\" target=_blank>$count</a>";

		return $count; 
	}
	
	function get_count_num_url($inputStr) {
		$pos1 = strpos($inputStr, "^");
		$pos2 = strpos($inputStr, "^", $pos1+1);

		$whereClause = substr($inputStr, 0, $pos1);
		$title = substr($inputStr, $pos1+1, $pos2 - $pos1-1);
		$pageTitle = substr($inputStr, $pos2+1);
		//echo $pos1 . " - " . $pos2; echo "<br>";
		
		$cntQuery = "select count(*) as cnt from rpthead h where " . $whereClause;
		//$linkSQL = "select " . $bugNo . ", h.rptdate,h.rptd_by,h.programmer,h.status, h.category, h.version_fixed,h.fixed_date, round(sysdate - h.fixed_date, 0),h.subject,h.product_id from rpthead h where " . $whereClause;
		$rs = execute_sql($cntQuery);
		//time_elapsed(" >>>>>> Execute SQL: ");
		
		$row = oci_fetch_array($rs, OCI_ASSOC);
		//time_elapsed(" >>>>>> Fetch Array : "); //time_elapsed(" ~~~~~~~~~~~~ DONE ~~~~~~~~~~~~ ");
		
		$count = $row['CNT'];
		$str =   "query2.php?whereClause=" . urlencode($whereClause) . "&title=" . urlencode($title) . "&pageTitle=" . urlencode($pageTitle); 
		//echo "URL is $str <br>";

		return array ("count" => $count, "url" => $str);
	}

	function get_count_orig($sqlQuery) {
		//$sqlQuery = "select 1 as cnt from dual";
		$rs = execute_sql($sqlQuery);
		//time_elapsed(" >>>>>> Execute SQL: ");
		//$rsOIM_Sts1140_All = execute_sql($qryOIM_Sts1140_All);
		$row = oci_fetch_array($rs, OCI_ASSOC);
		//time_elapsed(" >>>>>> Fetch Array : ");
		//time_elapsed(" ~~~~~~~~~~~~ DONE ~~~~~~~~~~~~ ");
		return $row['CNT'];
	}

    function time_elapsed($comment) {
        static $time_elapsed_last = null;
        static $time_elapsed_start = null;

        $unit="s"; $scale=1000000; // output in seconds
        //$unit="ms"; $scale=1000; // output in milliseconds
        //$unit="μs"; $scale=1; // output in microseconds

        $now = microtime(true);

        if ($time_elapsed_last != null) {
            echo "\n";
            //echo '<!-- ';
			echo '<pre>';
            echo "$comment: Time elapsed: <b>";
            echo round(($now - $time_elapsed_last)*1000000)/$scale;
            echo "</b> $unit, total time: <b>";
            echo round(($now - $time_elapsed_start)*1000000)/$scale;
            echo " $unit </b>";
			echo '</pre>';
			//echo " -->";
            echo "\n";
        } else {
            $time_elapsed_start=$now;
        }

        $time_elapsed_last = $now;
    } 

	function print_r2($val){
			echo '<pre>';
			print_r($val);
			echo  '</pre>';
	}

	function object2array($printr) {                    
		$newarray = array();        
		$a[0] = &$newarray;        
		if (preg_match_all('/^\s+\[(\w+).*\] => (.*)\n/m', $printr, $match)) {                        
			foreach ($match[0] as $key => $value) {    
				(int)$tabs = substr_count(substr($value, 0, strpos($value, "[")), "        ");                
				if ($match[2][$key] == 'Array' || substr($match[2][$key], -6) == 'Object') {                    
					$a[$tabs+1] = &$a[$tabs][$match[1][$key]];
				}                            
				else {
					$a[$tabs][$match[1][$key]] = $match[2][$key];                    
				}
			}
		}    
		return $newarray;    
	}
	
	function decho ($string, $level) {
		$cutoffLvl = 3;
		if ($level <= $cutoffLvl) {
			echo ($string . "<br \>");
		}
	}
/*	
	function checkArrays( arrA, arrB ){
		//console.log('arrA length : ' + arrA.length); console.log('arrB length : ' + arrB.length);

		//check if lengths are different
		if(arrA.length !== arrB.length) console.log('different length');


		for(var i=0;i<arrA.length;i++){
			console.log('arrA [' + i + '] : ' + arrA[i] + '; Length '+ arrA[i].length); console.log('arrB [' + i + '] : ' + arrB[i]  + '; Length '+ arrB[i].length);
			// if (arrA[i] instanceof Array) console.log('arrA [' + i + '] : is an Array'); if (arrB[i] instanceof Array) console.log('arrB [' + i + '] : is an Array');

			 if(arrA[i]!==arrB[i]) console.log('different element');
		}
	}
*/
?>