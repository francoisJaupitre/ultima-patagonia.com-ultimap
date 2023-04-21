<?php
if($trf_rck!=0) {
	$com = round((1-$trf_net/$trf_rck)*100);
	echo $com.'%';
}
else{echo '-';}
?>