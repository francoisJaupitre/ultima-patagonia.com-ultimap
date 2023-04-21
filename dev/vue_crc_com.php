<?php
if($ty_mrq==2){
?>
<strong><?php echo '  |  '.$txt->comm->$id_lng.':'; ?></strong>
<input <?php if(!$aut['dev']){echo ' disabled';} ?> id="crc_com<?php echo $id_dev_crc ?>" type="text" style="width: 35px;" value="<?php echo $com_crc*100 ?>" onChange="maj('dev_crc','com',this.value.replace(',','.')/100,<?php echo $id_dev_crc ?>)"/>
<strong><?php echo '%'; ?></strong>
<?php
}
?>
