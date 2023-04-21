<ul>
<?php
if(!isset($src)){$src='';}
if($id_ctg!=0 and empty($src)){
?>
	<li onClick="vue_cat('<?php echo $cbl ?>','ctg','0');"><?php echo $txt->lst->cat->ctg->$id_lng; ?></li>
<?php
}
$flg_enter = true;
foreach($nom_ctg_clt as $ctg_id => $nom){
	if($ctg_id!=$id_ctg and substr(upnoac($nom),0,strlen($src))==$src){
?>		
	<li <?php if($flg_enter){echo 'id="enter_ctg_clt" style="background-color: Chocolate;"';} ?> onClick="vue_cat('<?php echo $cbl ?>','ctg',<?php echo $ctg_id ?>);"><?php echo $nom ?></li>
<?php
		$flg_enter = false;
	}
}
?>
</ul>