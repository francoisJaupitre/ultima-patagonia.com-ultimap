<?php
$dt_pic = ftc_ass(select("*","cat_pic","id",$id));
?>
<div style="float:left;">
	<div class="lcrl">
		<img src="../pic/<?php echo $dir.'/'.$dt_pic['pic']; ?>" />
		<div>
			<a href="../pic/<?php echo $dir.'/'.$dt_pic['pic']; ?>" target="_blank">
				<span class="lnk_cat"><?php echo stripslashes($dt_pic['pic']); ?></span>
			</a>
<?php
if($aut['cat']) {
?>
			<span class="dib delete-elem"><img src="../prm/img/sup.png" /></span>
<?php
}
?>
		</div>
	</div>
</div>
<div class="div_cat2">
	<table class="tbl_jrn">
		<tr>
			<td class="dsg">
				<div class="fwb"><?php echo $txt->rgn->$id_lng.' :'; ?></div>
				<div id="pic_rgn" class="rgn"><?php include("vue_pic_rgn.php"); ?></div>
			</td>
		</tr>
		<tr>
			<td class="vat">
				<div class="dsg">
					<div id="pic_jrn" class="jrn"><?php include("vue_pic_jrn.php"); ?></div>
					<hr/>
					<span class="vdfp"><?php echo $txt->ajt->$id_lng.' :'; ?></span>
					<span id="pic_vll<?php echo $id ?>" class="vll"><?php include("vue_pic_vll.php"); ?></span>
				</div>
			</td>
		</tr>
	</table>
</div>
