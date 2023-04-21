<table>
	<tr>
		<td id="jrn_opt<?php echo $id_dev_mdl.'__'.$ord_jrn.'__'.$id_sel_jrn ?>" class="lcrl">
			<input type="button" value="<?php echo $txt->srcopt->$id_lng.' '.$txt->jrn->$id_lng ?>" onclick="vue_elem('jrn_opt<?php echo $id_dev_mdl.'__'.$ord_jrn.'__'.$id_sel_jrn ?>','<?php if(isset($jrn_opt_id_cat)){echo implode("_",$jrn_opt_id_cat);}else{echo 0;} ?>');" />
		</td>
	</tr>
</table>
