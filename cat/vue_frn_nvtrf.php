<input type="checkbox" autocomplete="off" <?php if(!$aut['cat']) {echo ' disabled';} ?> <?php if ($dt_frn['nvtrf']) {echo('checked="checked"');} ?> onclick="if(this.checked) {updateData('cat_frn','nvtrf','1',<?php echo $id ?>)}else{updateData('cat_frn','nvtrf','0',<?php echo $id ?>)};" />
