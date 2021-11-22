<?php
$file = $_FILES["fact"];
//probando SimpleXMLElement
$xml = new SimpleXMLElement($file);
foreach ( $xml->children() as $child ) {
    print_r( $child );
}
?>