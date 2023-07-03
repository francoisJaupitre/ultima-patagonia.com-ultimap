<?php
if(!isset($db)) {
	include("pdo_connect_param.php");
	$sql_mmbr = "SELECT mmbr,agent FROM prm_usr INNER JOIN prm_agt ON prm_usr.id_agt = prm_agt.id WHERE log ='".$_SERVER['REMOTE_USER']."'";
	try {
		$req_mmbr = $db->query($sql_mmbr);
		$data_mmbr = $req_mmbr->fetch(PDO::FETCH_ASSOC);
		if($data_mmbr['mmbr']){
			//$db = new PDO('mysql:host=localhost;dbname=ultimapa_'.$data_mmbr['agent'].';charset=utf8mb4', 'ultimapa_jgBqQZ7', '5ZiuaWgwZ2sgIw');
			$db = new PDO('mysql:host=localhost;dbname=ultimap_'.$data_mmbr['agent'].';charset=utf8mb4', 'root', '');
			$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			$db->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
			}
		else{echo 'Error id_agt or log'.$_SERVER['REMOTE_USER'];}
	}
	catch(PDOException $ex){
		console_log("Erreur SQL!".$ex->getMessage());
		return null;
	}
}
?>
