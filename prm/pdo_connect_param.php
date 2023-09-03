<?php
if(!isset($databaseParamConnection))
{
  try
  {
    //$databaseParamConnection = new PDO('mysql:host=localhost;dbname=ultimapa_param;charset=utf8mb4', 'ultimapa_IXxCs52', '-!7tRChm)b(!');
    $databaseParamConnection = new PDO('mysql:host=localhost;dbname=ultimap_prm;charset=utf8mb4', 'root', '');
    $databaseParamConnection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $databaseParamConnection->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
  }catch(PDOException $ex)
  {
    console_log("Erreur SQL!".$ex->getMessage());
  	return null;
  }
}
?>
