<?php
error_reporting(0);
setcookie("token","eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJpZCI6IjQyZDA3YzY3LTEwNTEtNDBmNS1iY2M3LWM5NDE4MWMyYWU4MiIsIm5hbWUiOiJBbm9ueW1vdXMgdmlzaXRvcnMifQ.BD4Yp0Ke0LopppbH4rwAxOAb09DuP2-x_a_3Xjo2Sbs");
if(isset($_POST['url'])){
    $url = ($_POST['url']);
    $exl = pathinfo($url,PATHINFO_EXTENSION);
    $exl = strtolower($exl);
    if (empty($exl))                  die('No');
    if (strstr($exl, 'x')   != False) die('No');
    if (strstr($exl, 'ht')  != False) die('No');
    if (strstr($exl, 'ph')  != False) die('No');
    if (strstr($exl, 'ini') != False) die('No');
    if (strstr($exl, 'htm') != False) die('No');
    if (strstr($exl, 'xml') != False) die('No');
    if (strstr($exl, 'svg') != False) die('No');
    if (strstr($exl, 'app') != False) die('No');
    if (strstr($exl, 'rdf') != False) die('No');
    if (strstr($exl, 'pdf') != False) die('No');
    file_put_contents("/nobodys3cr3t/".base64_encode($url), "");
    echo "<script>alert('Submit successfully, wait for admin bot to check!');</script>";
    }
else{
    $txt=file_get_contents('bot_index.html');
    echo $txt;
    }
?>