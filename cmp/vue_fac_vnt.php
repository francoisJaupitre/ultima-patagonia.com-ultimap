<?php
$rq_cpt = sel_whe("id","cmp_itm","cpt!=0 AND id_fac=".$dt_fac['id']);
$nb_cpt = num_rows($rq_cpt);
?>
<select  <?php if(!$aut['cmp']){echo ' disabled';} ?> style="width: 85px;" onchange="maj('cmp_fac','vnt',this.value,<?php echo $dt_fac['id'] ?>)">
  <option <?php if($nb_cpt>0){echo ' disabled';} ?> value="0">COMPRA</option>
  <option <?php if($dt_fac['vnt']){echo ' selected';} ?> value="1">VENTA</option>
  <option <?php if($dt_fac['vnt']==2){echo ' selected';} ?> value="2">COMISION (facturada a proveedor)</option>
</select>
