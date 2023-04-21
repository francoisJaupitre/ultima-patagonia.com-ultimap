<h4><?php echo $txt->lst->acc->elemno->$id_lng.' :' ?></h4>
<?php
if(isset($mdl)){
?>
<h5><?php echo $txt->lst->acc->mdlno->$id_lng.' :' ?></h5>
<?php
	foreach($mdl as $id => $nom){
?>
<span class="lnk" onclick="window.parent.opn_frm('cat/ctr.php?cbl=mdl&id=<?php echo $id ?>');"><?php echo $nom; ?></span>
<br />
<?php
	}
}
if(isset($jrn)){
?>
<h5><?php echo $txt->lst->acc->jrnno->$id_lng.' :' ?></h5>
<?php
	foreach($jrn as $id => $nom){
?>
<span class="lnk" onclick="window.parent.opn_frm('cat/ctr.php?cbl=jrn&id=<?php echo $id ?>');"><?php echo $nom; ?></span>
<br />
<?php
	}
}
if(isset($prs_lieu)){
?>
<h5><?php echo $txt->lst->acc->prsnolieu->$id_lng.' :' ?></h5>
<?php
foreach($prs_lieu as $id => $nom){
?>
<span class="lnk" onclick="window.parent.opn_frm('cat/ctr.php?cbl=prs&id=<?php echo $id ?>');"><?php echo $nom; ?></span>
<br />
<?php
	}
}
if(isset($prs_ctg)){
?>
<h5><?php echo $txt->lst->acc->prsnoctg->$id_lng.' :' ?></h5>
<?php
	foreach($prs_ctg as $id => $nom){
?>
<span class="lnk" onclick="window.parent.opn_frm('cat/ctr.php?cbl=prs&id=<?php echo $id ?>');"><?php echo $nom; ?></span>
<br />
<?php
	}
}
if(isset($srv_vll)){
?>
<h5><?php echo $txt->lst->acc->srvnovll->$id_lng.' :' ?></h5>
<?php
	foreach($srv_vll as $id => $nom){
?>
<span class="lnk" onclick="window.parent.opn_frm('cat/ctr.php?cbl=srv&id=<?php echo $id ?>');"><?php echo $nom; ?></span>
<br />
<?php
	}
}
if(isset($srv_ctg)){
?>
<h5><?php echo $txt->lst->acc->srvnoctg->$id_lng.' :' ?></h5>
<?php
	foreach($srv_ctg as $id => $nom){
?>
<span class="lnk" onclick="window.parent.opn_frm('cat/ctr.php?cbl=srv&id=<?php echo $id ?>');"><?php echo $nom; ?></span>
<br />
<?php
	}
}
if(isset($hbr)){
?>
<h5><?php echo $txt->lst->acc->hbrno->$id_lng.' :' ?></h5>
<?php
	foreach($hbr as $id => $nom){
?>
<span class="lnk" onclick="window.parent.opn_frm('cat/ctr.php?cbl=hbr&id=<?php echo $id ?>');"><?php echo $nom; ?></span>
<br />
<?php
	}
}
if(isset($clt)){
?>
<h5><?php echo $txt->lst->acc->cltno->$id_lng.' :' ?></h5>
<?php
	foreach($clt as $id => $nom){
?>
<span class="lnk" onclick="window.parent.opn_frm('cat/ctr.php?cbl=clt&id=<?php echo $id ?>');"><?php echo $nom; ?></span>
<br />
<?php
	}
}
if(isset($frn_vll)){
?>
<h5><?php echo $txt->lst->acc->frnnovll->$id_lng.' :' ?></h5>
<?php
foreach($frn_vll as $id => $nom){
?>
<span class="lnk" onclick="window.parent.opn_frm('cat/ctr.php?cbl=frn&id=<?php echo $id ?>');"><?php echo $nom; ?></span>
<br />
<?php
	}
}
if(isset($frn_ctg)){
?>
<h5><?php echo $txt->lst->acc->frnnoctg->$id_lng.' :' ?></h5>
<?php
	foreach($frn_ctg as $id => $nom){
?>
<span class="lnk" onclick="window.parent.opn_frm('cat/ctr.php?cbl=frn&id=<?php echo $id ?>');"><?php echo $nom; ?></span>
<br />
<?php
	}
}
if(isset($pic)){
?>
<h5><?php echo $txt->lst->acc->picno->$id_lng.' :' ?></h5>
<?php
	foreach($pic as $id => $nom){
?>
<span class="lnk" onclick="window.parent.opn_frm('cat/ctr.php?cbl=pic&id=<?php echo $id ?>');"><?php echo $nom; ?></span>
<br />
<?php
	}
}
if(isset($vll_rgn)){
?>
<h5><?php echo $txt->lst->acc->vllnorgn->$id_lng.' :' ?></h5>
<?php
	foreach($vll_rgn as $id => $nom){
?>
<span class="lnk" onclick="window.parent.opn_frm('cat/ctr.php?cbl=vll&id=<?php echo $id ?>');"><?php echo $nom; ?></span>
<br />
<?php
	}
}
if(isset($vll_pays)){
?>
<h5><?php echo $txt->lst->acc->vllnopays->$id_lng.' :' ?></h5>
<?php
	foreach($vll_pays as $id => $nom){
?>
<span class="lnk" onclick="window.parent.opn_frm('cat/ctr.php?cbl=vll&id=<?php echo $id ?>');"><?php echo $nom; ?></span>
<br />
<?php
	}
}
if(isset($lieu)){
?>
<h5><?php echo $txt->lst->acc->lieuno->$id_lng.' :' ?></h5>
<?php
	foreach($lieu as $id => $nom){
?>
<span class="lnk" onclick="window.parent.opn_frm('cat/ctr.php?cbl=lieu&id=<?php echo $id ?>');"><?php echo $nom; ?></span>
<br />
<?php
	}
}
if(isset($bnq)){
?>
<h5><?php echo $txt->lst->acc->bnqno->$id_lng.' :' ?></h5>
<?php
	foreach($bnq as $id => $nom){
?>
<span class="lnk" onclick="window.parent.opn_frm('cat/ctr.php?cbl=bnq&id=<?php echo $id ?>');"><?php echo $nom; ?></span>
<br />
<?php
	}
}
?>
