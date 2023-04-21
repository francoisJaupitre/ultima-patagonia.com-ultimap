<?php 
if(!$aut['mrq']){echo $ty_mrq_dev[$tymrq];}
else{
?> 
<div class="sel" onclick="vue_cmd('sel_ty_mrq<?php echo $id ?>')">
	<img src="../prm/img/sel.png" />
	<div><?php echo $ty_mrq_dev[$tymrq]; ?></div>
</div>
<div id="sel_ty_mrq<?php echo $id ?>" class="cmd mw200">
	<ul>
<?php
	foreach($ty_mrq_dev as $id_ty_mrq => $nom){
		if($id_ty_mrq != $tymrq){
?>		
		<li onClick="maj('cfg_ctg_clt','ty_mrq','<?php echo $id_ty_mrq ?>',<?php echo $id ?>);"><?php echo $nom ?></li>
<?php
		}
	}
?>
	</ul>
</div>
 <?php	
}
?>