<table>
	<tr>
		<td id="prs_prs_opt<?php echo $id_dev_jrn.'__'.$ord_prs.'__'.$id_ant_prs ?>" class="lmcf w-100">
			<input type="button" value="<?php echo $txt->srcopt->$id_lng.' '.$txt->prs->$id_lng ?>" onclick="vue_elem('prs_prs_opt<?php echo $id_dev_jrn.'__'.$ord_prs.'__'.$id_ant_prs ?>','<?php if(isset($prs_opt_id_cat)){echo implode("_",$prs_opt_id_cat);}else{echo 0;} ?>');" />
		</td>
	</tr>
</table>
