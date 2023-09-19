<span
<?php
if(!empty($dt_frn['wap']))
{
?>
  class="lnk"
  onclick="setTimeout( function () {window.open('https://wa.me/<?php echo $dt_frn['wap']; ?>', '_blank')} , 1000 );"
<?php
}
?>
>
<?php
echo $txt->wap->$id_lng.':';
?>
</span>
