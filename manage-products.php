<?php
	// Read list of products from the XML file
	$productXML = simplexml_load_file('data/product.xml');

	// Render read data in a tabular form
	echo "<form>";
	echo "<table border=0 width='100%'><tr><th size=5>Produc Code</th><th>Full Name</th><th>Comments</th></tr>";
	foreach ($productXML->product as $prod) {
		echo "
		<tr>
			<td>$prod->code</td>
			<td><input size=50  style=\"border-style:none;\" type=text value=\"$prod->abbr\" ></td>
			<td><input size=50  style=\"border-style:none;\" type=text value=\"$prod->name\" ></td>
			<td><input size=100 style=\"border-style:none;\" type=text value=\"$prod->comments\" ></td>
		</tr>";
	}
	echo "</table>";
	echo "<input type='submit' name='save' value='Save'>";
	echo "</form>";

	//if(isset($_POST['save'])) {
		$data=simplexml_load_file('data/product.xml');
		//print_r($data); echo "<br>";
		//$data->item->name=$_POST['name'];
		$handle=fopen("data/product.xml","wb");
		fwrite($handle,$data->asXML());
		fclose($handle);
	//}
?>