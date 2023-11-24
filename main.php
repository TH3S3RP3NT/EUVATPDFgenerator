<?php

$cc = readline('Enter country code: ');
$vn = readline('Enter VAT number: ');
$cc = strtoupper($cc);

$sc = new SoapClient('https://ec.europa.eu/taxation_customs/vies/checkVatService.wsdl');

$r = $sc->checkVat([
    'countryCode' => $cc,
    'vatNumber' => $vn
]);



require_once __DIR__ . '/vendor/autoload.php';

$mpdf = new \Mpdf\Mpdf();

$data = '';

$data .= '<img src="https://ec.europa.eu/taxation_customs/vies/assets/images/ecl/ec/logo/logo-ec--en.svg" width="193.59px" height="48px">';
$data .= '<h1>Data from given VAT-number</h1>';
$data .= '<strong>Date and Time of the request: </strong>' . $r->requestDate . '<br>';
$data .= '<strong>Country Code: </strong>' . $r->countryCode . '<br>';
$data .= '<strong>VAT-Number: </strong>' . $r->vatNumber . '<br>';
$data .= '<strong>Company name: </strong>' . $r->name . '<br>';
$data .= '<strong>Address: </strong>' . $r->address . '<br>';

$mpdf->WriteHTML($data);

$mpdf->Output('Response.pdf', 'F');

print_r($r);
