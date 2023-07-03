<?php
include("../prm/fct.php");
include("../prm/aut.php");
include("emoji_regex.php");
$ttr = rawurldecode($_GET['ttr']);
$file = file_get_contents("../tmp/".$dir."/".$ttr.".html","r");
$file = trim(preg_replace($emoji_regex, '-',$file)); //remove emojis
$file = str_replace($emoji,' ',$file);
$html = urldecode($file);
require_once('../vendor/dompdf/autoload.inc.php');
use Dompdf\Dompdf;
use Dompdf\Options;
$options = new Options();
$options->set('isRemoteEnabled', true);
$dompdf = new Dompdf($options);
$dompdf->setPaper("A4", "portrait");
$dompdf->setBasePath('');
$dompdf->loadHtml($html);
$dompdf->render();
$dompdf->stream($ttr.".pdf");
?>
