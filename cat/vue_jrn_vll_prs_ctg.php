<?php
if(!isset($id_vll)) {$id_vll=0;}
if(!isset($id_ctg)) {$id_ctg=0;}
?>
<span class="dib">	
	<div class="sel" onclick="vue_cmd('sel_vll_prs')">
		<img src="../prm/img/sel.png" />
		<div>
			<input type="hidden" id="vll_prs" value="<?php if($id_vll>0) {echo $id_vll;} else{echo '0';}  ?>" />
<?php
if($id_vll>0) {echo $vll[$id_vll];}
else{echo $txt->vlldep->$id_lng;}
?>
		</div>
	</div>
	<div id="sel_vll_prs" class="cmd mw200">
		<div><input type="text" id="ipt_sel_vll_prs" onkeyup="auto_lst('jrn_prs','vll_prs',this.value,event);" /></div>
		<div id="lst_vll_prs"><?php include("vue_lst_vll.php") ?></div>
	</div>
</span>
<span class="dib">	
	<div class="sel" onclick="vue_cmd('sel_ctg')">
		<img src="../prm/img/sel.png" />
		<div>
			<input type="hidden" id="ctg_prs" value="<?php if($id_ctg>0) {echo $id_ctg;} else{echo '0';} ?>" />
<?php
if($id_ctg>0) {echo $ctg_prs[$id_lng][$id_ctg];}
else{echo $txt->ctg->$id_lng;}
?>
		</div>
	</div>
	<div id="sel_ctg" class="cmd mw200">
		<div><input type="text" id="ipt_sel_ctg" onkeyup="auto_lst('jrn_prs','ctg_prs',this.value,event);" /></div>
		<div id="lst_ctg_prs"><?php include("vue_lst_ctg_prs.php") ?></div>
	</div>
</span>
<?php
if($id_ctg>0 and $id_vll>0) {
?>
<span class="dib">
	<div class="sel" onclick="vue_cmd('sel_prs')">
		<img src="../prm/img/sel.png" />
		<div><?php echo $txt->prs->$id_lng; ?></div>
	</div>
	<div id="sel_prs" class="cmd mw200">
		<div><input type="text" id="ipt_sel_prs" onkeyup="auto_lst('jrn_prs','prs',this.value,event);" /></div>
		<div id="lst_prs"><?php include("vue_lst_prs.php") ?></div>
	</div>
</span>
<?php
}
?>

