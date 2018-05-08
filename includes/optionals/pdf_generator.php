<?php
require_once('dompdf/autoload.inc.php');

// Example of HTML to PDF process 

// reference the Dompdf namespace
use Dompdf\Dompdf;

ob_start();
include("/home/respeadmin/public_html/wp-content/plugins/respe/templates/certificate.php");
$html = ob_get_clean();

$dompdf = new DOMPDF();
$dompdf->load_html($html);
$dompdf->render(); 
$output = $dompdf->output();
file_put_contents('/home/respeadmin/public_html/wp-content/plugins/respe/includes/certificates/certificate-' . $_SESSION['id'] . '.pdf', $output)

?>