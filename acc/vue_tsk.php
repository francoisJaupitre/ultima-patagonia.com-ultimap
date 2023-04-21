<?php
include("../prm/stat_tsk.php");
$rq_tsk = sel_whe("*, grp_tsk.id AS id_tsk ","grp_tsk LEFT JOIN grp_dev ON grp_tsk.id_grp=grp_dev.id","dt_grp=CURDATE() OR stat<4","date,id_grp");
$nb_tsk = num_rows($rq_tsk);
?>
<div class="floating-box"><?php include("vue_dt_tsk.php"); ?></div>
