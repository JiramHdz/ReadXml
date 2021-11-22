<?php
$file = $_FILES["fact"];
$xml = new SimpleXMLElement($file);
foreach ( $xml->children() as $child ) {
    print_r( $child );
}
?>