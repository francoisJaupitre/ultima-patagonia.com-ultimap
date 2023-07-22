<ul class="lst_ul">
<?php
if(!isset($src)) {$src='';}
$flg_enter = true;
if(!isset($rq_prs_opt)) {include("lst_prs_opt.php");}
if(isset($rq_prs_opt)) {
	while($dt_prs_opt = ftc_ass($rq_prs_opt)) {
		$flg_opt = true;
		foreach($prs_opt_id as $id_prs_opt) {
			if($dt_prs_opt['id']==$id_prs_opt) {$flg_opt=false;}
		}
		if($flg_opt and substr(upnoac($dt_prs_opt['nom']),0,strlen($src))==$src) {
?>
	<li <?php if($flg_enter) {echo 'id="enter_prs_opt'.$id_prs_sel.'__'.$ord_prs.'__'.$ctg_opt.'" style="background-color: Chocolate"';} ?>>
		<span class="dib" onClick="vue_cmd_ul('ul_prs_opt<?php echo $dt_prs_opt['id'].'_'.$ord_prs ?>','cmd_prs_opt<?php echo $ord_prs ?>')"><?php echo stripslashes($dt_prs_opt['nom']); if(!empty($dt_prs_opt['info'])) {echo stripslashes(' ['.$dt_prs_opt['info'].']');} ?></span>
		<ul id="ul_prs_opt<?php echo $dt_prs_opt['id'].'_'.$ord_prs ?>" class="cmd_prs_opt<?php echo $ord_prs ?>" style="display: none">
			<li onClick="insertOptionalPrs(<?php echo $dt_prs_opt['id'].','.$ord_prs ?>)"><?php echo $txt->ajt->$id_lng ?></li>
			<li onClick="window.parent.opn_frm('cat/ctr.php?cbl=prs&id=<?php echo $dt_prs_opt['id'] ?>')"><?php echo $txt->opn->$id_lng ?></li>
		</ul>
	</li>
<?php
			$flg_enter = false;
		}
	}
}
?>
</ul>
