<?php
include("../prm/aut.php");
?>
<div class="floating-box" style="width: 90%; text-align-last: left;">
<textarea <?php if(!$aut['web']){echo ' readonly';} ?> style="height: 500px;" onChange="maj_xml(this.value);"><?php echo htmlspecialchars(file_get_contents('../fct/html_web.xml')); ?></textarea>
<input type="button" value="SIMULER" onclick="window.open('../fct/html_web.php');">
</div>
