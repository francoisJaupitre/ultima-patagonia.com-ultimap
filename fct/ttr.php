<?php
if($cbl=='dev'){
	if(empty($ttr)){
		if($id_clt==1){$ttr = str_replace(array(" ","/","'"),"_",stripslashes($groupe));}
		else{$ttr = str_replace(array(" ","/","'"),"_",stripslashes($clt[$id_clt].'_'.$groupe));}
	}
	else{
		if($id_clt==1){$ttr = str_replace(array(" ","/","'"),"_",stripslashes($ttr.'_'.$nomgrp));}
		else{$ttr = str_replace(array(" ","/","'"),"_",stripslashes($clt[$id_clt].'_'.$ttr.'_'.$nomgrp));}
	}
}
else{
	$ttr = str_replace(array(" ","/","'"),"_",stripslashes($ttr));
	if(empty($ttr)){$ttr = str_replace(array(" ","/","'"),"_",stripslashes($nom));}
	$ttr .= '_('.$duree.'j)';
}
?>
