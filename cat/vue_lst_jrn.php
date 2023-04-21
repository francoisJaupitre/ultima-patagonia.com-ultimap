<ul class="lst_ul">
<?php
if(!isset($src)) {$src='';}
$flg_enter = true;
$col = '';
if($cbl=='mdl') {$col = "ord=1 AND ";}
if($cbl=='pic') {$rq_jrn = select(
	"cat_jrn.id,cat_jrn.nom,cat_jrn.info",
	"cat_jrn LEFT JOIN (
			SELECT id_jrn FROM cat_jrn_pic WHERE id_pic=".$id."
	) t1 ON cat_jrn.id = t1.id_jrn
	INNER JOIN cat_jrn_vll ON cat_jrn_vll.id_jrn = cat_jrn.id",
	"t1.id_jrn IS NULL AND id_vll",$id_vll,"nom","DISTINCT");}
else{$rq_jrn = select("cat_jrn.id,cat_jrn.nom,cat_jrn.info","cat_jrn_vll INNER JOIN cat_jrn ON cat_jrn_vll.id_jrn = cat_jrn.id",$col."id_vll",$id_vll,"nom","DISTINCT");}
while($dt_jrn = ftc_ass($rq_jrn)) {
	if(substr(upnoac($dt_jrn['nom']),0,strlen($src))==$src) {
		if($cbl=='mdl') {$event = "ajt_jrn(".$dt_jrn['id'].")";}
		else{$event = "ajt('jrn_pic',".$dt_jrn['id'].",'pic','0')";}
?>
	<li <?php if($flg_enter) {echo 'id="enter_jrn" style="background-color: Chocolate;"';} ?>>
		<span class="dib" onClick="vue_cmd_ul('ul_jrn<?php echo $dt_jrn['id'] ?>','cmd_jrn');"><?php echo stripslashes($dt_jrn['nom']); if(!empty($dt_jrn['info'])) {echo stripslashes(' ['.$dt_jrn['info'].']');} ?></span>
		<ul id="ul_jrn<?php echo $dt_jrn['id'] ?>" class="cmd_jrn" style="display: none">
			<li onClick="<?php echo $event; ?>;"><?php echo $txt->ajt->$id_lng ?></li>
			<li onClick="window.parent.opn_frm('cat/ctr.php?cbl=jrn&id=<?php echo $dt_jrn['id'] ?>');"><?php echo $txt->opn->$id_lng ?></li>
		</ul>
	</li>
<?php
		$flg_enter = false;
	}
}
?>
</ul>
