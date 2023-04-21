<?php
$limit = 30;
$j=0;
if(isset($_POST['rang'])) {
	$txt = simplexml_load_file('txt.xml');
	include("../prm/fct.php");
	include("../prm/aut.php");
	include("../cfg/crr.php");
	include("../cfg/css.php");
	include("../cfg/fin.php");
	include("../cfg/pst.php");
	$rang = $_POST['rang'];
	$nom_nat = $_POST['nom_nat'];
	$id_css = $_POST['id_css'];
	$id_att = $_POST['id_att'];
	$id_pst = $_POST['id_pst'];
	$id_grp = $_POST['id_grp'];
	$dt_mx = $_POST['dat_max'];
	$dt_mn = $_POST['dat_min'];
	$_POST = array();
	$dt = explode('/',$dt_mx);
	if(isset($dt[2])) {$dat_max = $dt[2].'-'.$dt[1].'-'.$dt[0];}
	$dt = explode('/',$dt_mn);
	$dat_min = $dt[2].'-'.$dt[1].'-'.$dt[0];
}
$var = "fin_ecr.*";
$tab = "fin_ecr";
if($id_css!=0 or $id_att>=0) {$tab .= " INNER JOIN fin_trs ON fin_ecr.id=fin_trs.id_ecr";}
if($id_pst!=0 or $id_grp!=0) {$tab .= " INNER JOIN fin_bdg ON fin_ecr.id=fin_bdg.id_ecr";}
$ord = "date DESC,nature,fin_ecr.id LIMIT ";
if($rang==1) {$ord .= $limit;}
else{$ord .= (($limit*($rang-1))).",".$limit;}
$col = "date >= '".$dat_min."'";
if(isset($dat_max)) {$col .= " AND date <= '".$dat_max."'";}
if($nom_nat!='*') {$col .= " AND nature='".addslashes($nom_nat)."'";}
if($id_css!=0) {
	if($id_css>-2) {$col .= " AND id_css=".$id_css;}
	elseif($id_css==-2) {$col .= " AND id_css=0";}
}
if($id_att>=0) {$col .= " AND att=".$id_att;}
if($id_pst!=0) {$col .= " AND id_pst=".$id_pst;}
if($id_grp!=0) {
	if($id_grp>-2) {$col .= " AND id_grp=".$id_grp;}
	elseif($id_grp==-2) {$col .= " AND id_grp=0";}
}
$col .= " AND 1";
$val = 1;
$rq_ecr = sel_quo($var,$tab,$col,$val,$ord,"DISTINCT");
while($dt_ecr = ftc_ass($rq_ecr)) {
	$j++;
	if($rang==1) {
?>
	<tr id="ecr_trs_bdg<?php echo $dt_ecr['id'] ?>">
<?php
	}
	else{echo "ecr_trs_bdg".$dt_ecr['id'].'$$';}
	include("vue_ecr_trs_bdg.php");
	if($rang==1) {
?>
	</tr>
<?php
	}
	elseif($j<$limit) {echo '|';}
}
if($j==0 and $rang>1) {echo '0';}
?>
