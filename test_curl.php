<?php
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, "https://www.google.com");
curl_setopt($ch, CURLOPT_CAINFO, "/etc/ssl/certs/ca-bundle.crt");
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, true);
curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);
$response = curl_exec($ch);
if (curl_errno($ch)) {
    echo 'Curl error: ' . curl_error($ch);
} else {
    echo 'Curl success: ' . $response;
}
curl_close($ch);

echo phpinfo();
?>