<?php
$file = $_FILES["fact"];

$xml_Content = file_get_contents($file["tmp_name"]);
$xml_Content = str_replace("<tfd:", "<cfdi:", $xml_Content);
$xml_Content = str_replace("<cfdi:", "<", $xml_Content);
$xml_Content = str_replace("</cfdi:", "</", $xml_Content);
//convertir a array
$xml_Content = simplexml_load_string($xml_Content);
$xml_Content = (array) $xml_Content;

//atributos
if (array_key_exists("Serie", $xml_Content["@attributes"])) {
    $xml_data['Serie'] = $xml_Content["@attributes"]["Serie"]; //no trae serie  $xml_Content["@attributes"]["Serie"]; //no trae serie 
} else {
    $xml_data['Serie'] = 'Sin serie';
}

if (array_key_exists("Folio", $xml_Content["@attributes"])) {
    $xml_data['Folio'] = $xml_Content["@attributes"]["Folio"]; //no trae folio  $xml_data['Folio'] = $xml_Content["@attributes"]["Folio"]; //no trae serie 
} else {
    $xml_data['Folio'] = 'Sin folio';
}

$xml_data['TipoDeComprobante'] = $xml_Content["@attributes"]["TipoDeComprobante"];
$xml_data['MetodoPago'] = $xml_Content["@attributes"]["MetodoPago"];
$xml_data['FormaPago'] = $xml_Content["@attributes"]["FormaPago"];
$xml_data['Moneda'] = $xml_Content["@attributes"]["Moneda"];
$xml_data['SubTotal'] = $xml_Content["@attributes"]["SubTotal"];
$xml_data['Total'] = $xml_Content["@attributes"]["Total"];

//datos de Emisor
$xml_Content["Emisor"] = (array) $xml_Content["Emisor"];
$xml_data['Rfc'] = $xml_Content["Emisor"]["@attributes"]["Rfc"];
$xml_data['Nombre'] = $xml_Content["Emisor"]["@attributes"]["Nombre"];
$xml_data['RegimenFiscal'] = $xml_Content["Emisor"]["@attributes"]["RegimenFiscal"];

//datos uuid
$xml_Content["Complemento"] = (array) $xml_Content["Complemento"];
$xml_Content["Complemento"]["TimbreFiscalDigital"] = (array) $xml_Content["Complemento"]["TimbreFiscalDigital"];
$xml_data['UUID'] = $xml_Content["Complemento"]["TimbreFiscalDigital"]["@attributes"]["UUID"];

//datos receptor
$xml_Content["Receptor"] = (array) $xml_Content["Receptor"];
$xml_data['UsoCFDI'] = $xml_Content["Receptor"]["@attributes"]["UsoCFDI"];

//impuestos
if (array_key_exists("Impuestos", $xml_Content)) {
    $xml_Content["Impuestos"] = (array) $xml_Content["Impuestos"]; // no trae ARRAY impuestos 

    if (array_key_exists("Retenciones", $xml_Content["Impuestos"])) {
        $xml_Content["Impuestos"]["Retenciones"] = (array) $xml_Content["Impuestos"]["Retenciones"];
        if (count($xml_Content["Impuestos"]["Retenciones"]["Retencion"]) > 1) {
            for ($i = 0; $i < count($xml_Content["Impuestos"]["Retenciones"]["Retencion"]); $i++) {
                $xml_Content["Impuestos"]["Retenciones"]["Retencion"][$i] = (array)$xml_Content["Impuestos"]["Retenciones"]["Retencion"][$i];
                $xml_data['Retencion'][$i]["attributes"]['Impuesto'] = $xml_Content["Impuestos"]["Retenciones"]["Retencion"][$i]["@attributes"]["Impuesto"];
                $xml_data['Retencion'][$i]["attributes"]['Importe'] = $xml_Content["Impuestos"]["Retenciones"]["Retencion"][$i]["@attributes"]["Importe"];
            }
        } else {
            $xml_data['Retencion']["attributes"]['Impuesto'] = $xml_Content["Impuestos"]["Retenciones"]["Retencion"]["@attributes"]["Impuesto"];
            $xml_data['Retencion']["attributes"]['Importe'] = $xml_Content["Impuestos"]["Retenciones"]["Retencion"]["@attributes"]["Importe"];
        }
        $xml_data['TotalImpuestosRetenidos'] = $xml_Content["Impuestos"]["@attributes"]["TotalImpuestosRetenidos"];
    } else {
        $xml_data['TotalImpuestosRetenidos'] = 0;
    }

    if (array_key_exists("Traslados", $xml_Content["Impuestos"])) {
        $xml_Content["Impuestos"]["Traslados"] = (array) $xml_Content["Impuestos"]["Traslados"];
        $xml_Content["Impuestos"]["Traslados"]["Traslado"] = (array) $xml_Content["Impuestos"]["Traslados"]["Traslado"];

        if (count($xml_Content["Impuestos"]["Traslados"]["Traslado"]) > 1) {
            for ($i = 0; $i < count($xml_Content["Impuestos"]["Traslados"]["Traslado"]); $i++) {
                $xml_Content["Impuestos"]["Traslados"]["Traslado"][$i] = (array)$xml_Content["Impuestos"]["Traslados"]["Traslado"][$i];
                $xml_data['Traslado'][$i]["attributes"]['Impuesto'] = $xml_Content["Impuestos"]["Traslados"]["Traslado"][$i]["@attributes"]["Impuesto"];
                $xml_data['Traslado'][$i]["attributes"]['Importe'] = $xml_Content["Impuestos"]["Traslados"]["Traslado"][$i]["@attributes"]["Importe"];
            }
        } else {
            $xml_data['Traslado']["attributes"]['Impuesto'] = $xml_Content["Impuestos"]["Traslados"]["Traslado"]["@attributes"]["Impuesto"];
            $xml_data['Traslado']["attributes"]['Importe'] = $xml_Content["Impuestos"]["Traslados"]["Traslado"]["@attributes"]["Importe"];
        }
        $xml_data['TotalImpuestosTrasladados'] = $xml_Content["Impuestos"]["@attributes"]["TotalImpuestosTrasladados"];
    } else {

        $xml_data['TotalImpuestosTrasladados'] = 0;
    }
}else{

   // $xml_data['Retencion']["attributes"]['Impuesto'] = 0;
    //$xml_data['Retencion']["attributes"]['Importe'] = 0;
    $xml_data['TotalImpuestosRetenidos'] = 0;
    //$xml_data['Traslado']["attributes"]['Impuesto'] =0;
    //$xml_data['Traslado']["attributes"]['Importe'] =0;
    $xml_data['TotalImpuestosTrasladados'] = 0;
}


//no trae impuestos llenar variables con 0
?>
<pre>
<?php
echo "Archivo leido y en un arreglo";
print('<br/>');
print('<br/>');
print_r( $xml_data);
print('<br/>');
print('<br/>');
echo "Archivo leido del original";
print('<br/>');
print('<br/>');
//print_r( $xml_Content);
print('<br/>');
print('<br/>');
?>
</pre>