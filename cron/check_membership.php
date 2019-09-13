<?php
error_reporting(0);
$con = mysqli_connect('localhost','ab99614_mydist3n','=Ehz1duJ^7;G','ab99614_mydist3n');
mysqli_set_charset($con,"utf8");
date_default_timezone_set('Asia/Calcutta');
$date = date('Y-m-d');

$sql="UPDATE `outlets` SET main_type_en='outlet', main_type_ar='مخرج' WHERE main_type_en='sponsorer' AND end_date < '$date'";
$res = mysqli_query($con, $sql);
echo mysqli_affected_rows($con)." rows updated";

?>