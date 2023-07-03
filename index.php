<?php
$txt = simplexml_load_file('txt.xml');
include("prm/fct.php");
include("prm/aut.php");
include("cfg/lng.php");
?>
<!DOCTYPE html>
<html>
	<head>
		<link rel="shortcut icon" type='image/png' href="prm/img/<?php echo $dir ?>/ico.png" />
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
		<link rel="stylesheet" type="text/css" href="forme.css?version=<?php echo date('Y-m-d-H-i-s', filemtime('forme.css'))  ?>" />
		<script type="text/javascript" src="vendor/jquery/jquery-3.5.1.min.js"></script>
		<link rel="stylesheet" href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/themes/smoothness/jquery-ui.css">
		<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
		<script><?php include("script.js"); ?></script>
		<title>U.L.T.I.M.A.P</title>
	</head>
	<body onload="lstn_fs();">
<?php
if(!empty($id_lng)){
?>
		<div id="tabs">

			<ul id="ul_tab">
<?php
	if($_SERVER['REMOTE_USER']=='f6kpLc3wXrWl'){
?>
				<input type="button" value="LOGOUT" onclick="logout()"/>
<?php
	}
?>
				<li id="li_fs" onclick="toggleFullScreen()">FS</li>
				<li id="li_acc" class="li_tab" onclick="vue_frm('acc');"><?php echo $txt->menu->$id_lng ?></li>
<?php
	$rq_cfg_mel = sel_quo("*","cfg_usr_mel","id_usr",$id_usr);
	if(num_rows($rq_cfg_mel)>0){
 ?>
				<li id="li_mel" class="li_hid" onclick="vue_frm('mel');"><?php echo $txt->mel->$id_lng ?><span id="unseen"></div></li>
<?php
	}
?>
			</ul>
		</div>
		<div id="dt_frm">
			<iframe id="acc" class="frm" src="acc/ctr.php"></iframe>
<?php
	if(num_rows($rq_cfg_mel)>0){
 ?>
			<iframe id="mel" class="frm" src="mel/ctr.php"></iframe>
<?php
	}
?>
		</div>
<?php
	$lst = scandir("tmp/".$dir."/");
	foreach($lst as $file){
		$filename = "tmp/".$dir."/".$file;
		if(file_exists($filename)) {
			$file_date = date ("F d Y H:i:s.", filemtime($filename));
			if(strtotime($file_date)<strtotime('1 month ago') and $file!="." and $file!=".."){unlink($filename);}
		}
	}
}
elseif($aut['mmbr']){
?>
		<div id="dt_frm"><?php include("deb.php"); ?></div>
<?php
}
?>
	</body>
</html>
