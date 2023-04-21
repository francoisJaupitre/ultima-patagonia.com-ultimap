<?php
if(!$aut['cat']) {echo $ctg_res[$id_lng][$ctg_res_hbr];}
else{
?>
<div class="sel" onclick="vue_cmd('maj_hbr_ctg_res')">
	<img src="../prm/img/sel.png" />
	<div><?php echo $ctg_res[$id_lng][$ctg_res_hbr]; ?></div>
</div>
<div id="maj_hbr_ctg_res" class="cmd mw200">
	<ul>
<?php
	foreach($ctg_res[$id_lng] as $res => $nom) {
		if($res != $ctg_res_hbr) {
?>
		<li onClick="maj('cat_hbr','ctg_res',<?php echo $res.','.$id ?>);"><?php echo $nom; ?></li>
<?php
		}
	}
?>
	</ul>
</div>
<?php
}
?>
