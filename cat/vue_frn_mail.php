<span
<?php
if(!empty($dt_frn['mail']))
{
?>
  class="lnk"
  onclick="setTimeout( function () {location.href='mailto:<?php echo $dt_frn['mail']; ?>';} , 1000 );"
<?php
}
?>
>
<?php
echo $txt->email->$id_lng.':';
?>
</span>
