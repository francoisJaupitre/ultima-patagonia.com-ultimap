<table class="w-100">
	<tr>
		<td id="jrn_rpl<?php echo $id_sel_jrn ?>" class="lcrl">
			<input type="button" value="<?php echo $txt->rpl->$id_lng.' '.$txt->jrn->$id_lng ?>" onclick="vue_elem('jrn_rpl<?php echo $id_sel_jrn ?>','<?php if(isset($jrn_rpl_id_cat)){echo implode("_",$jrn_rpl_id_cat);}else{echo 0;} ?>');" />
		</td>
	</tr>
</table>
