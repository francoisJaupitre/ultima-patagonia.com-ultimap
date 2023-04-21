<?php
try {
  //$db = new PDO('mysql:host=localhost;dbname=ultimapa_param;charset=utf8mb4', 'ultimapa_IXxCs52', '-!7tRChm)b(!');
  $db = new PDO('mysql:host=localhost;dbname=ultimap_prm;charset=utf8mb4', 'root', '');
  $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  $db->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
}
catch(PDOException $ex){
  console_log("Erreur SQL!".$ex->getMessage());
	return null;
}
?>
