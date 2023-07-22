<?php
if(!$aut['cat']) {echo $ty_delai[$id_lng][$dt_pay['ty_delai']];}
else{
?>
<div class="sel" <?php if($aut['cat']) { ?> onclick="vue_cmd('maj_hbr_ty_delai')" <?php } ?>>
	<img src="../prm/img/sel.png" />
	<div><?php echo $ty_delai[$id_lng][$dt_pay['ty_delai']]; ?></div>
</div>
<div id="maj_hbr_ty_delai" class="cmd mw200">
	<ul>
<?php
	foreach($ty_delai[$id_lng] as $id_ty_delai => $nom) {
		if($id_ty_delai != $dt_pay['ty_delai']) {
?>
		<li onClick="updateData('cat_hbr_pay','ty_delai',<?php echo $id_ty_delai.','.$dt_pay['id'] ?>);"><?php echo $nom; ?></li>
<?php
		}
	}
?>
	</ul>
</div>
<?php
}
?>
