<ul>
<?php
if(!isset($src)){$src='';}
if($id_ctg!=0 and empty($src)){
?>
	<li onClick="vue_cat('<?php echo $cbl ?>','ctg','0');"><?php echo $txt->lst->cat->ctg->$id_lng; ?></li>
<?php
}
$flg_enter = true;
foreach($ctg_srv[$id_lng] as $ctg_id => $nom){
	if(($ctg_id!=1 or $cbl!='srv') and $ctg_id!=$id_ctg and substr(upnoac($nom),0,strlen($src))==$src){
?>		
	<li <?php if($flg_enter){echo 'id="enter_ctg_srv" style="background-color: Chocolate;"';} ?> onClick="vue_cat('<?php echo $cbl ?>','ctg',<?php echo $ctg_id ?>);"><?php echo $nom ?></li>
<?php
		$flg_enter = false;
	}
}
?>
</ul>