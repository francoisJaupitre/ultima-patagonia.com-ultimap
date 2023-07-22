<ul class="lst_ul">
<?php
if(!isset($src)) {$src='';}
$flg_enter = true;
if($id_vll!=0) {$rq_prs = select("cat_prs.id,cat_prs.nom,cat_prs.info","cat_prs INNER JOIN (cat_prs_lieu INNER JOIN cat_lieu ON cat_prs_lieu.id_lieu = cat_lieu.id) ON cat_prs.id = cat_prs_lieu.id_prs","id_vll=".$id_vll." AND ctg",$id_ctg,"nom","DISTINCT");}
else{$rq_prs = select("id,nom,info","cat_prs","ctg",$id_ctg,"nom");}
while($dt_prs = ftc_ass($rq_prs)) {
	if(substr(upnoac($dt_prs['nom']),0,strlen($src))==$src) {
?>
	<li <?php if($flg_enter) {echo 'id="enter_prs" style="background-color: Chocolate;"';} ?>>
		<span class="dib" onClick="vue_cmd_ul('ul_prs<?php echo $dt_prs['id'] ?>','cmd_prs');"><?php echo stripslashes($dt_prs['nom']);  if(!empty($dt_prs['info'])) {echo stripslashes(' ['.$dt_prs['info'].']');} ?></span>
		<ul id="ul_prs<?php echo $dt_prs['id'] ?>" class="cmd_prs" style="display: none">
			<li onClick="insertPrs(<?php echo $dt_prs['id'] ?>);"><?php echo $txt->ajt->$id_lng ?></li>
			<li onClick="window.parent.opn_frm('cat/ctr.php?cbl=prs&id=<?php echo $dt_prs['id'] ?>');"><?php echo $txt->opn->$id_lng ?></li>
		</ul>
	</li>
<?php
		$flg_enter = false;
	}
}
?>
</ul>
