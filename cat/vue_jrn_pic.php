<div class="lcrl fwb">
<?php
$nb_pic = ftc_ass(select("COUNT(*) as total","cat_jrn_pic","id_jrn",$id));
if($nb_pic['total']!=0) {
	echo $txt->pic->$id_lng;
?>
	<table>
<?php
	$rq_jrn_pic = select("id_pic","cat_jrn_pic","id_jrn",$id);
	while($dt_jrn_pic = ftc_ass($rq_jrn_pic)) {
		$dt_pic = ftc_ass(select("pic","cat_pic","id",$dt_jrn_pic['id_pic']));
?>
		<tr>
			<td onclick="window.parent.opn_frm('cat/ctr.php?cbl=pic&id=<?php echo $dt_jrn_pic['id_pic'] ?>');">
				<img src="../pic/<?php echo $dir.'/'.$dt_pic['pic']; ?>"/>
			</td>
		</tr>
<?php
	}
?>
	</table>
<?php
}
else{echo $txt->nopic->$id_lng;}
?>
</div>
