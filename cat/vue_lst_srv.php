<ul class="lst_ul">
<?php
if(!isset($src)) {$src='';}
$flg_enter = true;
$rq_srv = select("id,nom,info,lgg","cat_srv","ctg=".$id_ctg." and id_vll",$id_vll,"nom");
while($dt_srv = ftc_ass($rq_srv)) {
	if(substr(upnoac($dt_srv['nom']),0,strlen($src))==$src) {
		$inf = ' ';
		if ($dt_srv['lgg'] >0) {$inf .= '['.$nom_lgg_lgg[$id_lng][$dt_srv['lgg']].']';}
		if (!empty($dt_srv['info'])) {$inf .= '['.$dt_srv['info'].']';}
?>
	<li <?php if($flg_enter) {echo 'id="enter_srv" style="background-color: Chocolate;"';} ?>>
		<span class="dib" onClick="vue_cmd_ul('ul_srv<?php echo $dt_srv['id'] ?>','cmd_srv');"><?php echo $dt_srv['nom'].$inf; ?></span>
		<ul id="ul_srv<?php echo $dt_srv['id'] ?>" class="cmd_srv" style="display: none">
			<li onClick="ajt_srv(<?php echo $dt_srv['id'] ?>);document.getElementById('sel_srv').style.display='none';"><?php echo $txt->ajt->$id_lng ?></li>
			<li onClick="window.parent.opn_frm('cat/ctr.php?cbl=srv&id=<?php echo $dt_srv['id'] ?>');"><?php echo $txt->opn->$id_lng ?></li>
		</ul>
	</li>
<?php
		$flg_enter = false;
	}
}
?>
</ul>
