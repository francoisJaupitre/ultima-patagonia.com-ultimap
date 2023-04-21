<?php
$limit = 30;
$j=0;
if(isset($_POST['rang'])){
	$txt = simplexml_load_file('txt.xml');
	include("../prm/fct.php");
	include("../prm/aut.php");
	include("../cfg/crr.php");
	include("../cfg/fin.php");
	include("../cfg/itm.php");
	$rang = $_POST['rang'];
	$nom_rai = $_POST['nom_rai'];
	$nom_imp = $_POST['nom_imp'];
	$id_vnt= $_POST['id_vnt'];
	$id_ctr= $_POST['id_ctr'];
	$id_itm = $_POST['id_itm'];
	$id_grp = $_POST['id_grp'];
	$dt_mx = $_POST['dat_max'];
	$dt_mn = $_POST['dat_min'];
	$_POST = array();
	$dt = explode('/',$dt_mx);
	if(isset($dt[2])){$dat_max = $dt[2].'-'.$dt[1].'-'.$dt[0];}
	$dt = explode('/',$dt_mn);
	$dat_min = $dt[2].'-'.$dt[1].'-'.$dt[0];
}
$var = "cmp_fac.*";
$tab = "cmp_fac";
if($id_itm!=0 or $id_grp!=0){$tab .= " LEFT JOIN cmp_itm ON cmp_fac.id=cmp_itm.id_fac";}
$ord = "date DESC,fac DESC,nom,cmp_fac.id LIMIT ";
if($rang==1){$ord .= $limit;}
else{$ord .= (($limit*($rang-1))).",".$limit;}
$col = "date >= '".$dat_min."'";
if(isset($dat_max)){$col .= " AND date <= '".$dat_max."'";}
if($nom_rai!='*'){$col .= " AND nom='".addslashes($nom_rai)."'";}
if($nom_imp!='*'){$col .= " AND imp='".addslashes($nom_imp)."'";}
if($id_vnt!=-1){$col .= " AND vnt=".$id_vnt;}
if($id_ctr!=-1){$col .= " AND ctr=".$id_ctr;}
if($id_itm!=0){
	if($id_itm>0){$col .= " AND id_itm=".$id_itm;}
	else{$col .= " AND id_itm=0";}
}
if($id_grp!=0){
	if($id_grp>-2){$col .= " AND id_grp=".$id_grp;}
	elseif($id_grp==-2){$col .= " AND id_grp=0";}
}
$col .= " AND 1";
$val = 1;
$rq_fac = sel_quo($var,$tab,$col,$val,$ord,"DISTINCT");
while($dt_fac = ftc_ass($rq_fac)){
	$j++;
	if($rang==1){
?>
	<tr id="fac_itm<?php echo $dt_fac['id'] ?>">
<?php
	}
	else{echo "fac_itm".$dt_fac['id'].'$$';}
	include("vue_fac_itm.php");
	if($rang==1){
?>
	</tr>
<?php
	}
	elseif($j<$limit){echo '|';}
}
if($j==0 and $rang>1){echo '0';}
?>
