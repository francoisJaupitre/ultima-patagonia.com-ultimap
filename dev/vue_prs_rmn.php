<?php 
if((!$aut['dev'] and $cnf<1) or (!$aut['res'] and $cnf>0)){
	if($trf_mdl){$dt_rmn = ftc_ass(select("nr","dev_mdl_rmn","id",$dt_prs['id_rmn']));}
	else{$dt_rmn = ftc_ass(select("nr","dev_crc_rmn","id",$dt_prs['id_rmn']));}
	echo $dt_rmn['nr'];
}
else{
?>
<span class="dib">
	<div class="sel" onclick="vue_cmd('sel_rmn_prs<?php echo $id_dev_prs ?>')">
		<img src="../prm/img/sel.png" />
		<div>
<?php
	if($trf_mdl){$dt_rmn = ftc_ass(select("nr","dev_mdl_rmn","id",$dt_prs['id_rmn']));}
	else{$dt_rmn = ftc_ass(select("nr","dev_crc_rmn","id",$dt_prs['id_rmn']));}
	echo $dt_rmn['nr'];
 ?>
		</div>
	</div>
	<div id="sel_rmn_prs<?php echo $id_dev_prs ?>" class="cmd mw200">
		<ul onclick="document.getElementById('sel_rmn_prs<?php echo $id_dev_prs ?>').style.display='none';">
<?php
	if($trf_mdl){$rq_rmn = select("*","dev_mdl_rmn","id_mdl",$id_dev_mdl,"nr");}
	else{$rq_rmn = select("*","dev_crc_rmn","id_crc",$id_dev_crc,"nr");}
	while($dt_rmn = ftc_ass($rq_rmn)){	
		if($dt_rmn['id'] != $dt_prs['id_rmn']){
?>		
			<li onClick="maj('dev_prs','id_rmn',<?php echo $dt_rmn['id'].','.$id_dev_prs ?>);"><?php echo $dt_rmn['nr']; ?></li>
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