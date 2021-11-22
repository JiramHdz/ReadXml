<?php
$file = $_FILES["fact"];
//probando SimpleXMLElement
//$xml = new SimpleXMLElement($file);
//foreach ( $xml->children() as $child ) {
//    print_r( $child );
//}

$xml_Content = file_get_contents($file["tmp_name"]);
//$xml_Content = str_replace("<tfd:", "<cfdi:", $xml_Content);
$xml_Content = str_replace("<cfdi:", "<", $xml_Content);
$xml_Content = str_replace("</cfdi:", "</", $xml_Content);
//convertir a array
$xml_Content = simplexml_load_string($xml_Content);

echo '<pre>';
var_dump($xml_Content);
echo '</pre>';

//$xmldata = simplexml_load_file($file) or die("Failed to load");
//foreach($xmldata->children() as $empl) {         
 //var_dump($empl);
//} 
?>