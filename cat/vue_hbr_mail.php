<span
<?php
if(!empty($mel_hbr))
{
?>
  class="lnk"
  onclick="setTimeout( function () {location.href='mailto:<?php echo $mel_hbr; ?>';} , 1000 );"
<?php
} 
?>
>
<?php
echo $txt->email->$id_lng.':';
?>
</span>
