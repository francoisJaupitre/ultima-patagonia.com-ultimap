<ul class="lst_ul">
<?php
if(!isset($src))
{
	$src='';
}
$flg_enter = true;
if(!isset($lst_prs_jrn_opt))
{
	include("lst_prs_jrn_opt.php");
}
if(isset($lst_prs_jrn_opt))
{
	foreach($lst_prs_jrn_opt as $id => $nom)
	{
		if(substr(upnoac($nom),0,strlen($src)) == $src)
		{
			$param = '{\x22ord\x22:0}';
			$event = "searchPrs(".$id.",'$param',".$id_dev_jrn.")";
?>
	<li
<?php
			if($flg_enter)
			{
				echo 'id="enter_prs_jrn_opt'.$id_dev_jrn.'" style="background-color: Chocolate;"';
			}
?>
	>
		<span class="dib" onClick="vue_cmd_ul('ul_prs_jrn_opt<?php echo $id.'_'.$id_dev_jrn ?>','cmd_prs_jrn_opt<?php echo $id_dev_jrn ?>');"><?php echo stripslashes($nom); ?></span>
		<ul id="ul_prs_jrn_opt<?php echo $id.'_'.$id_dev_jrn ?>" class="cmd_prs_jrn_opt<?php echo $id_dev_jrn ?>" style="display: none">
			<li onClick="<?php echo $event; ?>"><?php echo $txt->ajt->$id_lng ?></li>
			<li onClick="window.parent.opn_frm('cat/ctr.php?cbl=prs&id=<?php echo $id ?>');"><?php echo $txt->opn->$id_lng ?></li>
		</ul>
	</li>
<?php
			$flg_enter = false;
		}
	}
}
?>
</ul>
