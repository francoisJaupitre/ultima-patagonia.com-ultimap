<?php
include("../prm/fct.php");
$cbl=$_POST['cbl'];
$bss=$_POST['base'];
while(strpos($bss, ';')){
	$base[]=strstr($bss, ';',true);
	$pos=strpos($bss, ';');
	$bss=substr($bss, $pos+1);
}
$base[]=$bss;
foreach($base as $bas){
	if(strpos($bas, '-')!==false){
		$b1=intval(strstr($bas, '-',true));
		$pos=strpos($bas, '-');
		$b2=intval(substr($bas, $pos+1));
		if($b1 >0 and $b2 >0){
			for($i=$b1;$i<=$b2;$i++){$bs[]=$i;}
		}
	}
	elseif(intval($bas)>0){$bs[]=intval($bas);}
}
if(isset($bs)){
	foreach($bs as $base){
		$flg_bss=false;
		if($cbl=='crc'){
			$id_dev_crc=$_POST['id'];
			$rq_bss=select("base","dev_crc_bss","id_crc",$id_dev_crc);
			while($dt_bss=ftc_ass($rq_bss)){
				if($dt_bss['base']==$base){$flg_bss=true;}
			}
			if($flg_bss){
				$rq=select("id","dev_crc_bss","id_crc=".$id_dev_crc." AND base",$base);
				$dt=ftc_ass($rq);
				delete("dev_crc_bss","id",$dt['id']);
				$rq_mdl=select("id,trf","dev_mdl","id_crc",$id_dev_crc);
				while($dt_mdl=ftc_ass($rq_mdl)){
					if($dt_mdl['trf']==0){
						$id_dev_mdl=$dt_mdl['id'];
						include("sup_trf_srv.php");
					}
				}
			}
		}
		elseif($cbl=='mdl'){
			$id_dev_mdl=$_POST['id'];
			$rq_bss=select("base","dev_mdl_bss","id_mdl",$id_dev_mdl);
			while($dt_bss=ftc_ass($rq_bss)){
				if($dt_bss['base']==$base){$flg_bss=true;}
			}
			if($flg_bss){
				$rq=select("id","dev_mdl_bss","id_mdl=".$id_dev_mdl." AND base",$base);
				$dt=ftc_ass($rq);
				delete("dev_mdl_bss","id",$dt['id']);
				include("sup_trf_srv.php");	
			}
		}
	}
}
?>