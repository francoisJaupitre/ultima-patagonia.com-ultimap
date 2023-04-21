<?php
if(($trf_rck)!=0 and $trf_net/$trf_rck <1){echo(number_format((1-$trf_net/$trf_rck)*100,0)."%");}
else{echo '-';}
?>
