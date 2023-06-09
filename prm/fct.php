<?php
function ftc_ass($req){
	if(is_object($req)) {
		return $req->fetch(PDO::FETCH_ASSOC);
	}	else{
		return null;
	}
}

function ftc_num($req){return $req->fetch(PDO::FETCH_NUM);}

function ftc_all($req){return $req->fetchAll(PDO::FETCH_ASSOC);}

function num_rows($req){return $req->rowCount();}

function select($var,$tab,$col="",$val="",$ord="",$opt=""){	//FONCTION A REMPLACER PAR VARIANTES sel_quo(priorité QUOTES POUR EVITER INJECTION SQL!) ou sel_whe.
	if (!empty($var) and !empty($tab) and !(empty($col) xor empty($val))){
		include("pdo_connect.php");
		$sql = "SELECT ".$opt." ".$var." FROM ".$tab;
		if (!empty($col) and !empty($val)){$sql .= " WHERE ".$col." = ".$db->quote($val);}
		if (!empty($ord)){$sql .= " ORDER BY ".$ord;}
		try {
			$req = $db->prepare($sql);
			$req->execute();
			return $req;
		}
		catch(PDOException $ex){
			console_log("Erreur SQL!".$ex->getMessage());
			return null;
		}
	}
}

function sel_quo($var,$tab,$col="",$val="",$ord="",$opt=""){
	if (!empty($var) and !empty($tab) and !(empty($col) xor empty($val))){
		include("pdo_connect.php");
		$whe = "";
		if(is_array($val)){
			foreach($val as $i=>$str){$whe .= $col[$i].'='.$db->quote($str).' AND ';}
			$whe = substr($whe, 0, -5);
		}
		elseif($col!=""){$whe = $col.'='.$db->quote($val);}
		$sql = "SELECT ".$opt." ".$var." FROM ".$tab;
		if (!empty($whe)){$sql .= " WHERE ".$whe;}
		if (!empty($ord)){$sql .= " ORDER BY ".$ord;}
		try {
			$req = $db->prepare($sql);
			$req->execute();
			/*
				$txt = date("d/m").' '.date("H:i").' '.$sql."\r\n";
				$fp = fopen("../tmp/".$dir."/fct.txt","a");
				if($fp){
					fwrite($fp, $txt);
					fclose($fp);
				}
			*/
			return $req;
		}
		catch(PDOException $ex){
			console_log("Erreur SQL!".$ex->getMessage());
			return null;
		}
	}
}

function sel_whe($var,$tab,$whe="",$ord="",$opt=""){
	if (!empty($var) and !empty($tab)){
		include("pdo_connect.php");
		$sql = "SELECT ".$opt." ".$var." FROM ".$tab;
		if (!empty($whe)){$sql .= " WHERE ".$whe;}
		if (!empty($ord)){$sql .= " ORDER BY ".$ord;}
		try {
			$req = $db->prepare($sql);
			$req->execute();
			return $req;
		}
		catch(PDOException $ex){
			console_log("Erreur SQL!".$ex->getMessage());
			return null;
		}
	}
}

function sel_grp($var,$tab,$col="",$val="",$grp="",$ord="",$opt=""){
	if (!empty($var) and !empty($tab) and !(empty($col) xor empty($val))){
		include("pdo_connect.php");
		$sql = "SELECT ".$opt." ".$var." FROM ".$tab;
		if (!empty($col) and !empty($val)){$sql .= " WHERE ".$col." = ".$db->quote($val);}
		if (!empty($grp)){$sql .= " GROUP BY ".$grp;}
		if (!empty($ord)){$sql .= " ORDER BY ".$ord;}
		try {
			$req = $db->prepare($sql);
			$req->execute();
			return $req;
		}
		catch(PDOException $ex){
			console_log("Erreur SQL!".$ex->getMessage());
			return null;
		}
	}
}

function sel_prm($var,$tab,$col="",$val="",$ord="",$opt=""){
	if (!empty($var) and !empty($tab)){
		try {
			include("pdo_connect_param.php");
			$sql = "SELECT ".$opt." ".$var." FROM ".$tab;
			if (!empty($col) and !empty($val)){$sql .= " WHERE ".$col." = ".$db->quote($val);}
			if (!empty($ord)){$sql .= " ORDER BY ".$ord;}
			$req = $db->prepare($sql);
			$req->execute();
			/*
			$txt = date("d/m").' '.date("H:i").' '.$sql."\r\n";
			$fp = fopen("../tmp/".$dir."/fct.txt","a");
			if($fp){
				fwrite($fp, $txt);
				fclose($fp);
			}*/
			return $req;
		}
		catch(PDOException $ex){
			console_log("Erreur SQL!".$ex->getMessage());
			return null;
		}
	}
}

function insert($tab,$col,$val){
	if (!empty($tab) and !empty($col) and !empty($val)){
		include("pdo_connect.php");
		if(is_array($val)){
			foreach($val as $str){$val_new[] = $db->quote($str);}
			$val = implode(",",$val_new);
			$col = implode(",",$col);
		}
		else{$val = $db->quote($val);}
		$sql = "INSERT INTO ".$tab." (".$col.") VALUES (".$val.")";
		try {
			$req = $db->prepare($sql);
			$req->execute();
			/*
			$txt = date("d/m").' '.date("H:i").' '.$sql.' -> '.$db->lastInsertId()."\r\n";
			$fp = fopen("../tmp/".$dir."/fct.txt","a");
			if($fp){
				fwrite($fp, $txt);
				fclose($fp);
			}*/
			return $db->lastInsertId();
		}
		catch(PDOException $ex){
			console_log("Erreur SQL!".$ex->getMessage());
			return null;
		}
	}
}

function ins_noq($tab,$col,$val){
	if (!empty($tab) and !empty($col) and !empty($val)){
		include("pdo_connect.php");
		if(is_array($val)){
			foreach($val as $str){$val_new[] = $str;}
			$val = implode(",",$val_new);
			$col = implode(",",$col);
		}
		$sql = "INSERT INTO ".$tab." (".$col.") VALUES ".$val;
		echo $sql;

		try {
			$req = $db->prepare($sql);
			$req->execute();
			/*
			$txt = date("d/m").' '.date("H:i").' '.$sql.' -> '.$db->lastInsertId()."\r\n";
			$fp = fopen("../tmp/".$dir."/fct.txt","a");
			if($fp){
				fwrite($fp, $txt);
				fclose($fp);
			}*/
			return $db->lastInsertId();
		}
		catch(PDOException $ex){
			console_log("Erreur SQL!".$ex->getMessage());
			return null;
		}
	}
}

function delete($tab,$col,$val){
	if (!empty($tab) and !empty($col) and !empty($val) and $val>0){
		include("pdo_connect.php");
		$sql = "DELETE FROM ".$tab." WHERE ".$col." = ".$val;
		try {
			$req = $db->prepare($sql);
			$req->execute();
			/*
			$txt = date("d/m").' '.date("H:i").' '.$sql."\r\n";
			$fp = fopen("../tmp/".$dir."/fct.txt","a");
			if($fp){
				fwrite($fp, $txt);
				fclose($fp);
			}*/
			return $req;
		}
		catch(PDOException $ex){
			console_log("Erreur SQL!".$ex->getMessage());
			return null;
		}
	}
}

function upd_quo($tab,$col,$val,$id){ //FONCTION UPDATE PRIORITAIRE ! QUOTES POUR EVITER INJECTION SQL!
	if (!empty($tab) and !empty($col) and !empty($id) and $id>0){
		include("pdo_connect.php");
		if(!is_array($val)){$set = $col."=".$db->quote($val);}
		else{
			foreach($val as $uid => $str){$set_new[] = $col[$uid].'='.$db->quote($str);}
			$set = implode(",",$set_new);
		}
		$sql = "UPDATE ".$tab." SET ".$set." WHERE id = ".$id;
		try {
			$req = $db->prepare($sql);
			$req->execute();
			/*
			$txt = date("d/m").' '.date("H:i").' '.$sql."\r\n";
			$fp = fopen("../tmp/".$dir."/fct.txt","a");
			if($fp){
				fwrite($fp, $txt);
				fclose($fp);
			}*/
			return 1;
		}
		catch(PDOException $ex){
			console_log("Erreur SQL!".$ex->getMessage());
			return null;
		}
	}
}

function upd_noq($tab,$col,$val,$id){
	if (!empty($tab) and !empty($col) and !empty($id) and $id>0){
		include("pdo_connect.php");
		if(!is_array($val)){$set = $col."=".$val;}
		else{
			foreach($val as  $uid => $str){$set_new[] = $col[$uid].'='.$str;}
			$set = implode(",",$set_new);
		}
		$sql = "UPDATE ".$tab." SET ".$set." WHERE id = ".$id;
		try {
			$req = $db->prepare($sql);
			$req->execute();
			return 1;
		}
		catch(PDOException $ex){
			console_log("Erreur SQL!".$ex->getMessage());
			return null;
		}
	}
}

function upd_var_quo($tab,$col,$val,$var,$id){ //FONCTION UPDATE AVEC CHOIX VARIABLES PRIORITAIRE ! QUOTES POUR EVITER INJECTION SQL!
	if (!empty($tab) and !empty($col) and !empty($var) and !empty($id) and $id>0){
		include("pdo_connect.php");
		if(!is_array($val)){$set = $col."=".$db->quote($val);}
		else{
			foreach($val as  $uid => $str){$set_new[] = $col[$uid].'='.$db->quote($str);}
			$set = implode(",",$set_new);
		}
		if(!is_array($id)){$whe = $var."=".$db->quote($id);}
		else{
			foreach($id as $uid => $str){$whe_new[] = $var[$uid].'='.$db->quote($str);}
			$whe = implode(" AND ",$whe_new);
		}
		$sql = "UPDATE ".$tab." SET ".$set." WHERE ".$whe;
		try {
			$req = $db->prepare($sql);
			$req->execute();
			return 1;
		}
		catch(PDOException $ex){
			console_log("Erreur SQL!".$ex->getMessage());
			return null;
		}
	}
}

function upd_var_noq($tab,$col,$val,$var,$id){
	if (!empty($tab) and !empty($col) and !empty($var) and !empty($id) and $id>0){
		include("pdo_connect.php");
		if(!is_array($val)){$set = $col."=".$val;}
		else{
			foreach($val as  $uid => $str){$set_new[] = $col[$uid].'='.$str;}
			$set = implode(",",$set_new);
		}
		$sql = "UPDATE ".$tab." SET ".$set." WHERE ".$var."='".$id."'";
		try {
			$req = $db->prepare($sql);
			$req->execute();
			return 1;
		}
		catch(PDOException $ex){
			console_log("Erreur SQL!".$ex->getMessage());
			return null;
		}
	}
}

function upd_cat($tab,$id){
	if(!empty($tab) and !empty($id) and $id>0){
		include("pdo_connect.php");
		if($tab=="dev_hbr"){
			$sql = "UPDATE ".$tab." SET id_cat_chm=0 WHERE id_cat = '".$id."'";
			try {
				$req = $db->prepare($sql);
				$req->execute();
			}
			catch(PDOException $ex){
				console_log("Erreur SQL!".$ex->getMessage());
				return null;
			}
		}
		$sql = "UPDATE ".$tab." SET id_cat=0 WHERE id_cat = '".$id."'";
		try {
			$req = $db->prepare($sql);
			$req->execute();
			return 1;
		}
		catch(PDOException $ex){
			console_log("Erreur SQL!".$ex->getMessage());
			return null;
		}
	}
}

function upd_nul($tab,$col,$id){
	if (!empty($tab) and !empty($col) and !empty($id) and $id>0){
		include("pdo_connect.php");
		$sql = "UPDATE ".$tab." SET ".$col."=NULL WHERE id = ".$id;
		try {
			$req = $db->prepare($sql);
			$req->execute();
			return 1;
		}
		catch(PDOException $ex){
			console_log("Erreur SQL!".$ex->getMessage());
			return null;
		}
	}
}

function upnoac($var) {
	$var = str_replace(
		array(
			'à', 'â', 'ä', 'á', 'ã', 'å',
			'î', 'ï', 'ì', 'í',
			'ô', 'ö', 'ò', 'ó', 'õ', 'ø',
			'ù', 'û', 'ü', 'ú',
			'é', 'è', 'ê', 'ë',
			'ç', 'ÿ',
			'À', 'Â', 'Ä', 'Á', 'Ã', 'Å',
			'Î', 'Ï', 'Ì', 'Í',
			'Ô', 'Ö', 'Ò', 'Ó', 'Õ', 'Ø',
			'Ù', 'Û', 'Ü', 'Ú',
			'É', 'È', 'Ê', 'Ë',
			'Ç', 'Ÿ',
		),
		array(
			'a', 'a', 'a', 'a', 'a', 'a',
			'i', 'i', 'i', 'i',
			'o', 'o', 'o', 'o', 'o', 'o',
			'u', 'u', 'u', 'u',
			'e', 'e', 'e', 'e',
			'c', 'y',
			'A', 'A', 'A', 'A', 'A', 'A',
			'I', 'I', 'I', 'I',
			'O', 'O', 'O', 'O', 'O', 'O',
			'U', 'U', 'U', 'U',
			'E', 'E', 'E', 'E',
			'C', 'Y',
		),$var
	);
	return strtoupper($var);
}

function console_log ($output, $with_script_tags = true) {
	$js_code = 'console. log('.json_encode ($output, JSON_HEX_TAG).');';
	if ($with_script_tags) {
		$js_code = '<script>'.$js_code.'</script>';
	}
	echo $js_code;
}
?>
