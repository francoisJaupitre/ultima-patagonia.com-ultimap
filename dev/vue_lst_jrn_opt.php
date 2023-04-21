<ul class="lst_ul">
<?php
if(!isset($src)){$src='';}
$flg_enter = true;
if(!isset($rq_jrn_opt)){include("lst_jrn_opt.php");}
if($id_cat_mdl==0){
?>
	<li onClick="ajt_jrn(<?php echo '0,'.$id_dev_mdl.','.$ord_jrn.',0,'.$id_sel_jrn ?>);"><?php echo  $txt->creer->$id_lng; ?></li>
<?php
}
if(isset($rq_jrn_opt)){
	while($dt_jrn_opt = ftc_ass($rq_jrn_opt)){
		if(!in_array($dt_jrn_opt['id'],$jrn_opt_id_cat) and substr(upnoac($dt_jrn_opt['nom']),0,strlen($src))==$src){
?>
	<li <?php if($flg_enter){echo 'id="enter_jrn_opt'.$id_dev_mdl.'__'.$ord_jrn.'__'.$id_sel_jrn.'" style="background-color: Chocolate;"';} ?>>
		<span class="dib" onClick="vue_cmd_ul('ul_jrn_opt<?php echo $dt_jrn_opt['id'].'_'.$id_dev_mdl.'__'.$ord_jrn.'__'.$id_sel_jrn ?>','cmd_jrn_opt<?php echo $id_dev_mdl.'__'.$ord_jrn.'__'.$id_sel_jrn ?>');"><?php echo stripslashes($dt_jrn_opt['nom']); if(!empty($dt_jrn_opt['info'])){echo stripslashes(' ['.$dt_jrn_opt['info'].']');} ?></span>
		<ul id="ul_jrn_opt<?php echo $dt_jrn_opt['id'].'_'.$id_dev_mdl.'__'.$ord_jrn.'__'.$id_sel_jrn ?>" class="cmd_jrn_opt<?php echo $id_dev_mdl.'__'.$ord_jrn.'__'.$id_sel_jrn ?>" style="display: none">
			<li onClick="ajt_jrn(<?php echo $dt_jrn_opt['id'].','.$id_dev_mdl.','.$ord_jrn.',0,'.$id_sel_jrn ?>);"><?php echo $txt->ajt->$id_lng ?></li>
			<li onClick="window.parent.opn_frm('cat/ctr.php?cbl=jrn&id=<?php echo $dt_jrn_opt['id'] ?>');"><?php echo $txt->opn->$id_lng ?></li>
		</ul>
	</li>
<?php
			$flg_enter = false;
		}
	}
}
?>
</ul>
