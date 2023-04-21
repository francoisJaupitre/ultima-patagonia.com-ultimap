<?php
$cbl = 'jrn_rpl';
$id = $id_sel_jrn;
if(!isset($id_vll)){$id_vll=0;}
?>
<input type="hidden" id="jrn_rpl_id_cat<?php echo $id_sel_jrn ?>" value="<?php echo $id_vll.'__'; if(isset($jrn_rpl_id_cat)){echo implode("_",$jrn_rpl_id_cat);} else{echo '0';}?>" />
<span class="dib">
	<div class="sel" onclick="vue_cmd('sel_vll_jrn_rpl<?php echo $id_sel_jrn ?>')">
		<img src="../prm/img/sel.png" />
		<div>
<?php
if(isset($id_vll) and $id_vll>0){echo stripslashes($vll[$id_vll]);}
else{echo $txt->vll->$id_lng;}
?>
		</div>
	</div>
	<div id="sel_vll_jrn_rpl<?php echo $id_sel_jrn ?>" class="cmd mw200">
		<div><input type="text" id="ipt_sel_vll_jrn_rpl<?php echo $id_sel_jrn ?>" class="vll_fll" onkeyup="auto_lst('jrn_rpl','vll_jrn_rpl<?php echo $id_sel_jrn ?>',this.value,event);" /></div>
		<div id="lst_vll_jrn_rpl<?php echo $id_sel_jrn ?>"><?php include("vue_lst_vll.php") ?></div>
	</div>
</span>
<span class="dib">
	<div class="sel" onclick="vue_cmd('sel_jrn_rpl<?php echo $id_sel_jrn ?>')">
		<img src="../prm/img/sel.png" />
		<div><?php echo $txt->jrn->$id_lng; ?></div>
	</div>
	<div id="sel_jrn_rpl<?php echo $id_sel_jrn ?>" class="cmd mw200">
		<div><input type="text" id="ipt_sel_jrn_rpl<?php echo $id_sel_jrn ?>" class="jrn_fll" onkeyup="auto_lst('jrn_rpl','jrn_rpl<?php echo $id_sel_jrn ?>',this.value,event);" /></div>
		<div id="lst_jrn_rpl<?php echo $id_sel_jrn ?>"><?php include("vue_lst_jrn.php") ?></div>
	</div>
</span>
