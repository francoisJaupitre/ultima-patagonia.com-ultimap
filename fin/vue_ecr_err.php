<?php
if(round($flux_trs-$som_bdg,8)==0) {
	if(!$flg_err) {echo 'OK';}
	else{echo 'ERROR';}
	}
else{echo 'ERROR :'.round($flux_trs-$som_bdg,8);}
?>	