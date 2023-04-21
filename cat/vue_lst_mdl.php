<ul class="lst_ul">
<?php
if(!isset($src)) {$src='';}
$flg_enter = true;
$rq_mdl = select("cat_mdl.id,cat_mdl.nom,cat_mdl.info","cat_mdl_rgn INNER JOIN cat_mdl ON cat_mdl_rgn.id_mdl = cat_mdl.id","id_rgn",$id_rgn,"nom","DISTINCT");
while($dt_mdl = ftc_ass($rq_mdl)) {
	if(substr(upnoac($dt_mdl['nom']),0,strlen($src))==$src) {
		if(!isset($id_chm)) {$id_chm = '';}
?>
	<li <?php if($flg_enter) {echo 'id="enter_mdl" style="background-color: Chocolate;"';} ?>>
		<span class="dib" onClick="vue_cmd_ul('ul_mdl<?php echo $dt_mdl['id'] ?>','cmd_mdl');"><?php echo stripslashes($dt_mdl['nom']); if(!empty($dt_mdl['info'])) {echo stripslashes(' ['.$dt_mdl['info'].']');} ?></span>
		<ul id="ul_mdl<?php echo $dt_mdl['id'] ?>" class="cmd_mdl" style="display: none">
			<li onClick="ajt_mdl(<?php echo $dt_mdl['id'] ?>);document.getElementById('sel_mdl').style.display='none';"><?php echo $txt->ajt->$id_lng ?></li>
			<li onClick="window.parent.opn_frm('cat/ctr.php?cbl=mdl&id=<?php echo $dt_mdl['id'] ?>');"><?php echo $txt->opn->$id_lng ?></li>
		</ul>
	</li>
<?php
	$flg_enter = false;
	}
}
?>
</ul>
