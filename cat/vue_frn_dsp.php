<?php
$rq_dsp = select("*","frn_dsp","id_frn",$id,"date");
if(num_rows($rq_dsp)>0) {
?>
<div class="tbl_prs dsg">
	<strong><?php echo $txt->nodsp->$id_lng.' :'; ?></strong>
		<table>
<?php
	while($dt_dsp = ftc_ass($rq_dsp)) {
?>
		<tr>
			<td style="<?php if($dt_dsp['date']<date("Y-m-d")) {echo 'color: red';} ?>"><?php if($dt_dsp['date']!="0000-00-00") {echo date("d/m/Y", strtotime($dt_dsp['date']));} ?></td>
<?php
		if($aut['res']) {
?>
			<td><span class="dib" onClick="sup_dsp(<?php echo $dt_dsp['id']; ?>);"><img src="../prm/img/sup.png" /></span></td>
<?php
		}
?>
		</tr>
<?php
	}
?>
	</table>
</div>
<?php
}
?>
