<?php 
if(!$aut['cat']) {echo $ctg_res[$id_lng][$dt_frn['ctg_res']];}
else{
?> 
<div class="sel" onclick="vue_cmd('maj_frn_ctg_res')">
	<img src="../prm/img/sel.png" />
	<div><?php echo $ctg_res[$id_lng][$dt_frn['ctg_res']]; ?></div>
</div>
<div id="maj_frn_ctg_res" class="cmd mw200">
	<ul>
<?php
	foreach($ctg_res[$id_lng] as $res => $nom) {
		if($res != $dt_frn['ctg_res']) {
?>		
		<li onClick="updateData('cat_frn','ctg_res',<?php echo $res.','.$id ?>);"><?php echo $nom; ?></li>
<?php
		}
	}
?>
	</ul>
</div>
<?php 
}
?>