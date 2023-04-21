<?php
include("../prm/stat_ech.php");
$rq_ctc = sel_quo("*","crm_ctc","","","dt_ctc DESC");
$nb_ctc = num_rows($rq_ctc);
?>
<div class="floating-box"><?php include("vue_dt_crm.php"); ?></div>
