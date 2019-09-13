<?php
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, "http://volivesolutions.com/zorni/cron/booked_reminder");
curl_setopt($ch, CURLOPT_HEADER, 0);
curl_exec($ch);
curl_close($ch);

$ch1 = curl_init();
curl_setopt($ch1, CURLOPT_URL, "http://volivesolutions.com/zorni/cron/change_appointment_status");
curl_setopt($ch1, CURLOPT_HEADER, 0);
curl_exec($ch1);
curl_close($ch1);
?>