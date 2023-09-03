<?php //CREATE A .EML EMAIL FILE
switch($act)
{
	case 'nv':
		$body = html_entity_decode(utf8_encode($msg));
		if(isset($atxt) and file_exists('../prm/mel/'.$dir.'/'.$atxt.'.html'))
		{
			$body .= file_get_contents('../prm/mel/'.$dir.'/'.$atxt.'.html');
		}
		$eml = file_get_contents("../fct/template.eml");
		if(file_exists('../prm/mel/'.$dir.'/'.$from.'.html'))
		{
			$body .= file_get_contents('../prm/mel/'.$dir.'/'.$from.'.html');
			$eml = str_replace("TEMPLATE_ATTACH_CONTENT", '', $eml);
		}else{
			$eml = str_replace("TEMPLATE_ATTACH_CONTENT", '', $eml);
		}
		break;
	case 're':
		if(substr(strtoupper($subj), 0, 3) != 'RE:')
		{
			$subj = 'RE: '.$subj;
		}
		$body = '';
		if(isset($atxt) and file_exists('../prm/mel/'.$dir.'/'.$atxt.'.html'))
		{
			$body .= file_get_contents('../prm/mel/'.$dir.'/'.$atxt.'.html');
		}
		$eml = file_get_contents("../fct/template.eml");
		if(file_exists('../prm/mel/'.$dir.'/'.$from.'.html'))
		{
			$body .= file_get_contents('../prm/mel/'.$dir.'/'.$from.'.html');
			$eml = str_replace("TEMPLATE_ATTACH_CONTENT", '', $eml);
		}else{
			$eml = str_replace("TEMPLATE_ATTACH_CONTENT", '', $eml);
		}
		$body .= file_get_contents("../../tmp/".$dir."/body.html");
		break;
	case 'rv':
		if(substr(strtoupper($subj), 0, 3) != 'RV:')
		{
			$subj = 'RV: '.$subj;
		}
		$eml = file_get_contents("../fct/template_rv.eml");
		$body = file_get_contents("../../tmp/".$dir."/body.html");
		if(isset($att))
		{
			$attachments = explode('|', $att);
			$attach_template .= '';
			foreach($attachments as $attname)
			{
				$attach = file_get_contents("attach_template.eml");
				$file = "../../tmp/".$dir."/".str_replace("_", " ", mb_decode_mimeheader($attname));
				$attachment = file_get_contents($file);
				$attach = str_replace("TEMPLATE_MIME_TYPE", mime_content_type($file), $attach);
				$attach = str_replace("TEMPLATE_ATTACH_FILENAME", str_replace("_", " ", mb_decode_mimeheader($attname)), $attach);
				$attach = str_replace("TEMPLATE_ATTACH_CONTENT", base64_encode($attachment), $attach);
				$attach_template .= $attach;
			}
			$eml = str_replace("TEMPLATE_ATTACHMENT", $attach_template, $eml);
		}else{
			$eml = str_replace("TEMPLATE_ATTACHMENT", '', $eml);
		}
		break;
}
$eml = str_replace("TEMPLATE_FROM_ADDRESS", $from, $eml);
if(isset($melto))
{
	$eml = str_replace("TEMPLATE_TO_ADDRESS", $melto, $eml);
}else{
	$eml = str_replace("TEMPLATE_TO_ADDRESS", '', $eml);
}
$eml = str_replace("TEMPLATE_CC_ADDRESS", $ccrt, $eml);
$eml = str_replace("TEMPLATE_RT_ADDRESS", $ccrt, $eml);
$encsubj = '=?utf-8?B?'.base64_encode($subj).'?=';
$eml = str_replace("TEMPLATE_SUBJECT", $encsubj, $eml);
$eml = str_replace("TEMPLATE_PLAIN", strip_tags($body), $eml);
$eml = str_replace("TEMPLATE_BODY", $body, $eml);
$file = "../../tmp/".$dir."/".str_replace(array(" ", "/"), "_", $subj).".eml";
file_put_contents($file, $eml);
//file_put_contents($file, mb_convert_encoding($eml, 'ISO-8859-15', 'utf-8')); // FOR THUNDERBIRD
?>
