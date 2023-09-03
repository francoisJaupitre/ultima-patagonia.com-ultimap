<?php
if(!$aut['dev']){
?>
<div class="noselcol" style="width:50px; background:#<?php echo $col[$id_col_mdl]; ?>; color:#<?php echo $col[$id_col_mdl]; ?>;"><?php echo $col[$id_col_mdl]; ?></div>
<?php
}
else{
?>
<span class="dib">
	<div class="sel" onclick="vue_cmd('sel_col<?php echo $id_dev_mdl ?>')">
		<img src="../prm/img/sel.png" />
		<div style="width:50px; background:#<?php echo $col[$id_col_mdl]; ?>; color:#<?php echo $col[$id_col_mdl]; ?>;"><?php echo $col[$id_col_mdl]; ?></div>
	</div>
	<div id="sel_col<?php echo $id_dev_mdl ?>" class="cmd mw200">
		<ul onclick="document.getElementById('sel_col<?php echo $id_dev_mdl ?>').style.display='none';">
<?php
	foreach($col as $col_id => $code){
		if($id_col_mdl != $col_id){
?>
			<li onClick="closeRichText('dsc_mdl,dt_mdl',<?php echo $id_dev_mdl ?>),function(){maj('dev_mdl','col',<?php echo $col_id.','.$id_dev_mdl ?>);})" style="width:50px; background:#<?php echo $code; ?>; color:#<?php echo $code; ?>;"><?php echo $code; ?></li>
<?php
		}
	}
?>
		</ul>
	</div>
</span>
<?php
}
?>
