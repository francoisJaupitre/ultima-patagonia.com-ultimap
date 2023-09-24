<ul class="lst_ul">
<?php
if(!isset($src)){$src='';}
$flg_enter = true;
if(!isset($rq_lst_prs_prs_opt)){include("lst_prs_prs_opt.php");}
if($id_cat_jrn==0){
?>
	<li onClick="ajt_prs(<?php echo '0,'.$id_dev_jrn.','.$ord_prs.',0,0,0' ?>);document.getElementById('sel_prs_prs_opt<?php echo $id_dev_jrn.'__'.$ord_prs.'__'.$id_ant_prs ?>').style.display='none';"><?php echo  $txt->creer->$id_lng;; ?></li>
<?php
}
if(isset($rq_lst_prs_prs_opt)){
	while($dt_lst_prs_prs_opt = ftc_ass($rq_lst_prs_prs_opt)){
		if(!in_array($dt_lst_prs_prs_opt['id'],$prs_opt_id_cat) and substr(upnoac($dt_lst_prs_prs_opt['nom']),0,strlen($src))==$src){
			$param = '{\x22ord\x22:0,\x22id_ant\x22:'.$id_ant_prs.'}';
			$event = "searchPrs(".$dt_lst_prs_prs_opt['id'].",'$param',".$id_dev_jrn.")";
?>
	<li <?php if($flg_enter){echo 'id="enter_prs_prs_opt'.$id_dev_jrn.'__'.$ord_prs.'__'.$id_ant_prs.'" style="background-color: Chocolate;"';} ?>>
		<span class="dib" onClick="vue_cmd_ul('ul_prs_prs_opt<?php echo $dt_lst_prs_prs_opt['id'].'_'.$id_dev_jrn.'__'.$ord_prs.'__'.$id_ant_prs ?>','cmd_prs_prs_opt<?php echo $id_dev_jrn.'__'.$ord_prs.'__'.$id_ant_prs ?>');">
<?php
			if($id_cat_prs_sel==0){echo '{'.$dt_lst_prs_prs_opt['nom_lieu'].'} ';}
			echo stripslashes($dt_lst_prs_prs_opt['nom']);
			if(!empty($dt_lst_prs_prs_opt['info'])){echo stripslashes(' ['.$dt_lst_prs_prs_opt['info'].']');}
?>
		</span>
		<ul id="ul_prs_prs_opt<?php echo $dt_lst_prs_prs_opt['id'].'_'.$id_dev_jrn.'__'.$ord_prs.'__'.$id_ant_prs ?>" class="cmd_prs_prs_opt<?php echo $id_dev_jrn.'__'.$ord_prs.'__'.$id_ant_prs ?>" style="display: none">
			<li onClick="<?php echo $event; ?>"><?php echo $txt->ajt->$id_lng ?></li>
			<li onClick="window.parent.opn_frm('cat/ctr.php?cbl=prs&id=<?php echo $dt_lst_prs_prs_opt['id'] ?>');"><?php echo $txt->opn->$id_lng ?></li>
		</ul>
	</li>
<?php
			$flg_enter = false;
		}
	}
}
?>
</ul>
