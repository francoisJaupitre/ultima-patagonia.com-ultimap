<ul onclick="document.getElementById('sel_res_prs<?php echo $id_dev_prs ?>').style.display='none';">
<?php
if(!isset($src))
{
	$src = '';
}
$flg_enter = true;
foreach($res_prs[$id_lng] as $res_id => $nom)
{
	if($res_id != $id_res_prs and substr(upnoac($nom), 0, strlen($src)) == $src)
	{
		$param = '{\res\x22:'.$res_id.',\x22id_dev\x22:'.$id_dev_prs.'}';
		$event = "searchPrs(".$id_cat_prs.",'$param',".$id_dev_jrn.")";
?>
	<li
<?php
		if($flg_enter)
		{
			echo 'id="enter_prs_res'.$id_dev_prs.'" style="background-color: Chocolate;"';
		}
?>
		onClick="<?php echo $event; ?>"
	>
<?php
		echo $nom;
?>
	</li>
<?php
		$flg_enter = false;
	}
}
?>
</ul>
