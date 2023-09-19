<span
<?php
if(!empty($wap_hbr))
{
?>
  class="lnk"
  onclick="setTimeout( function () {window.open('https://wa.me/<?php echo $wap_hbr; ?>', '_blank')} , 1000 );"
<?php
}
?>
>
<?php
echo $txt->wap->$id_lng.':';
?>
</span>
