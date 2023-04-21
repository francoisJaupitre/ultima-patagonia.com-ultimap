<ul>
<?php
if(!isset($src)){$src='';}
if($id_pays!=0 and empty($src)){
?>
	<li onClick="vue_cat('<?php echo $cbl ?>','pays','0');"><?php echo $txt->pays->$id_lng; ?></li>
<?php
}
$flg_enter = true;
foreach($pays[$id_lng] as $pays_id => $nom){
	if($pays_id!=$id_pays and substr(upnoac($nom),0,strlen($src))==$src){
?>
	<li <?php if($flg_enter){echo 'id="enter_pays" style="background-color: Chocolate;"';} ?> onClick="vue_cat('<?php echo $cbl ?>','pays',<?php echo $pays_id ?>);"><?php echo $nom ?></li>
<?php
		$flg_enter = false;
	}
}
?>
</ul>
