<?php 
if(!$aut['dev']){
?>
<div class="nosel"><?php echo $ty_mrq_dev[$ty_mrq]; ?></div>
<?php
}
else{
?>
<span class="dib">
	<div class="sel" onclick="vue_cmd('sel_ty_mrq')">
		<img src="../prm/img/sel.png" />
		<div><?php echo $ty_mrq_dev[$ty_mrq]; ?></div>
	</div>
	<div id="sel_ty_mrq" class="cmd mw200">
		<ul onclick="document.getElementById('sel_ty_mrq').style.display='none';">
<?php
	foreach($ty_mrq_dev as $id_ty_mrq => $nom){
		if($id_ty_mrq != $ty_mrq){
?>		
			<li onClick="maj('dev_crc','ty_mrq',<?php echo $id_ty_mrq.','.$id_dev_crc ?>);"><?php echo $nom ?></li>
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