<?php
$dt_mel = ftc_ass(sel_quo("*","cfg_mel","id",$id_mel));
$server = $dt_mel['server'];
$port = $dt_mel['port'];
$user = $dt_mel['user'];
$pass = $dt_mel['pass'];
$mbox = imap_open("{".$server.":".$port."}".$box,$user,$pass);
?>
