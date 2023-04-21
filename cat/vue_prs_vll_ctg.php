<?php
if(!isset($id_vll)) {$id_vll=0;}
if(!isset($id_ctg)) {$id_ctg=0;}
if(!isset($id_rgm)) {$id_rgm=0;}
if(!isset($id_hbr)) {$id_hbr=0;}
?>
<span class="dib">	
	<div class="sel" onclick="vue_cmd('sel_vll')">
		<img src="../prm/img/sel.png" />
		<div>
			<input type="hidden" id="vll" value="<?php if($id_vll>0) {echo $id_vll;} else{echo '0';}  ?>" />
<?php
if($id_vll>0) {echo $vll[$id_vll];}
else{echo $txt->vll->$id_lng;}
?>
		</div>
	</div>
	<div id="sel_vll" class="cmd mw200">
		<div><input type="text" id="ipt_sel_vll" onkeyup="auto_lst('prs','vll',this.value,event);" /></div>
		<div id="lst_vll"><?php include("vue_lst_vll.php") ?></div>
	</div>
</span>
<span class="dib">	
	<div class="sel" onclick="vue_cmd('sel_ctg')">
		<img src="../prm/img/sel.png" />
		<div>
			<input type="hidden" id="ctg_srv" value="<?php if($id_ctg>0) {echo $id_ctg;} else{echo '0';} ?>" />
<?php
if($id_ctg>0) {echo $ctg_srv[$id_lng][$id_ctg];}
else{echo $txt->ctg->$id_lng;}
?>
		</div>
	</div>
	<div id="sel_ctg" class="cmd mw200">
		<div><input type="text" id="ipt_sel_ctg" onkeyup="auto_lst('prs','ctg_srv',this.value,event);" /></div>
		<div id="lst_ctg_srv"><?php include("vue_lst_ctg_srv.php") ?></div>
	</div>
</span>
<?php
if($id_ctg>0 and $id_vll>0) {
	if($id_ctg!=1) {
?>
<span class="dib">
	<div class="sel" onclick="vue_cmd('sel_srv')">
		<img src="../prm/img/sel.png" />
		<div><?php echo $txt->srv->$id_lng; ?></div>
	</div>
	<div id="sel_srv" class="cmd mw200">
		<div><input type="text" id="ipt_sel_srv" onkeyup="auto_lst('prs','srv',this.value,event);" /></div>
		<div id="lst_srv"><?php include("vue_lst_srv.php") ?></div>
	</div>
</span>
<?php
	}
	else{
?>
<span class="dib">
	<div class="sel" onclick="vue_cmd('sel_rgm')">
		<img src="../prm/img/sel.png" />
		<div>
			<input type="hidden" id="rgm" value="<?php if($id_rgm>0) {echo $id_rgm;} else{echo '0';}  ?>" />
<?php
		if($id_rgm>0) {echo $rgm[$id_lng][$id_rgm];}
		else{echo $txt->rgm->$id_lng;}
?>
		</div>
	</div>
	<div id="sel_rgm" class="cmd mw200">
		<div><input type="text" id="ipt_sel_rgm" onkeyup="auto_lst('prs','rgm',this.value,event);" /></div>
		<div id="lst_rgm"><?php include("vue_lst_rgm.php") ?></div>
	</div>
</span>
<?php
		if($id_rgm>0) {
?>
<span class="dib">
	<div class="sel" onclick="vue_cmd('sel_hbr')">
		<img src="../prm/img/sel.png" />
		<div>
			<input type="hidden" id="hbr" value="<?php if($id_hbr>0) {echo $id_hbr;} else{echo '0';}  ?>" />
<?php
			if($id_hbr>0) {
				$dt_hbr = ftc_ass(select("nom","cat_hbr","id",$id_hbr));
				echo $dt_hbr['nom'];
			}
			else{echo $txt->hbr->$id_lng;}
?>
		</div>
	</div>
	<div id="sel_hbr" class="cmd mw200">
		<div><input type="text" id="ipt_sel_hbr" onkeyup="auto_lst('prs','hbr',this.value,event);" /></div>
		<div id="lst_hbr"><?php include("vue_lst_hbr.php") ?></div>
	</div>
</span>
<?php
			if($id_hbr>0) {
?>
<span class="dib">
	<div class="sel" onclick="vue_cmd('sel_chm')">
		<img src="../prm/img/sel.png" />
		<div><?php echo $txt->chm->$id_lng; ?></div>
	</div>
	<div id="sel_chm" class="cmd mw200">
		<div><input type="text" id="ipt_sel_chm" onkeyup="auto_lst('prs','chm',this.value,event);" /></div>
		<div id="lst_chm"><?php include("vue_lst_chm.php") ?></div>
	</div>
</span>
<?php
			}
		}
	}
}
?>
