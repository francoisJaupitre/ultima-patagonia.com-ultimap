<?php
if($ty_mrq==1){
?>
<strong><?php echo '  |  '.$txt->mrq_hbr->$id_lng.':'; ?></strong>
<input <?php if(!$aut['dev']){echo ' disabled';} ?> id="crc_mrq_hbr<?php echo $id_dev_crc ?>" type="text" style="width: 35px;" value="<?php echo $mrq_hbr_crc*100 ?>" onChange="maj('dev_crc','mrq_hbr',this.value.replace(',','.')/100,<?php echo $id_dev_crc ?>)"/>
<strong><?php echo '%'; ?></strong>
<?php
}
?>
