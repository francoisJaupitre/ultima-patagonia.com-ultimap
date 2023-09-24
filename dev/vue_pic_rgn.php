<?php
$cbl = 'pic';
if($id_pic_jrn > 0){
	$dt_pic = ftc_ass(select("pic","cat_pic","id",$id_pic_jrn));
?>
		<span onclick="window.parent.opn_frm('cat/ctr.php?cbl=pic&id=<?php echo $id_pic_jrn ?>');">
			<img style="height: 30px;" src="../pic/<?php echo $dir.'/'.$dt_pic['pic']; ?>" />
		</span>
<?php
}
?>
	<div class="sel" style="right: 5px"  onclick="vue_cmd('sel_rgn_pic<?php echo $id_dev_jrn ?>')">
		<img src="../prm/img/sel.png" />
		<div>
			<input type="hidden" id="rgn_pic<?php echo $id_dev_jrn ?>" value="<?php echo $id_rgn ?>" />
<?php
if(isset($id_rgn) and $id_rgn>0){echo stripslashes($rgn[$id_rgn]);}
else{echo $txt->rgn->$id_lng;}
?>
		</div>
	</div>
	<div id="sel_rgn_pic<?php echo $id_dev_jrn ?>" class="cmd2" style="right: 5px">
		<div><input type="text" id="ipt_sel_rgn_pic<?php echo $id_dev_jrn ?>" class="rgn_fll" onkeyup="auto_lst('pic','pic_rgn<?php echo $id_dev_jrn ?>',this.value,event);" /></div>
		<div id="lst_pic_rgn<?php echo $id_dev_jrn ?>"><?php include("vue_lst_rgn.php") ?></div>
	</div>
	<span class="dib">
		<div class="sel" onclick="vue_cmd('sel_pic<?php echo $id_dev_jrn ?>')">
			<img src="../prm/img/sel.png" />
			<div><?php echo $txt->pic->$id_lng; ?></div>
		</div>
		<div id="sel_pic<?php echo $id_dev_jrn ?>" style="right: 5px; overflow: auto;" class="cmd2">
			<div id="lst_pic<?php echo $id_dev_jrn ?>"><?php include("vue_lst_pic.php") ?></div>
		</div>
	</span>
