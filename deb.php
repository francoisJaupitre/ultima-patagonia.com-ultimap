<?php
include("prm/lgg.php");
foreach($nom_lgg as $id => $nom){
	if($lngg[$id]){
?>
<span onclick="add(<?php echo $id ?>);" style="color: #0000C3"><?php echo $nom; ?></span>
<br />
<?php
		}
	}
?>
