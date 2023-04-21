<?php
function replace($var){
	if (!empty($var)){
		$var = str_replace("’","'",$var);
		$var = str_replace("–","-",$var);
		$var = str_replace("&","-",$var);
		return html_entity_decode(iconv('UTF-8', 'windows-1252',$var));
		ltrim ($var);
	}
}

function replace_lnk($var){
	if (!empty($var)){
		$var = str_replace("’","'",$var);
		$var = str_replace("&","",$var);
		return html_entity_decode(iconv('UTF-8', 'windows-1252',$var));
		ltrim ($var);
	}
}
?>
