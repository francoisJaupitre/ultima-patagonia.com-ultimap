<ul onclick="document.getElementById('sel_pic_<?php echo $id_dev_jrn; ?>').style.display='none';">
<?php
$event = "maj('dev_jrn','id_pic','0',$id_dev_jrn);";
?>
	<li onClick="<?php echo $event; ?>"><?php echo $txt->nopic->$id_lng; ?></li>
<?php
if($id_rgn>0){
	$rq_pic = select("id,pic","cat_pic","id_rgn",$id_rgn);
	while($dt_pic = ftc_ass($rq_pic)){
		$event = "maj('dev_jrn','id_pic',".$dt_pic['id'].",".$id_dev_jrn.");";
?>
	<li onClick="<?php echo $event; ?>" style="display: flex" >
		<img src="../pic/<?php echo $dir.'/'.$dt_pic['pic'] ?>" />
	</li>
<?php
	}
}
?>
</ul>
