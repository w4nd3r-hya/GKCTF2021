<?php
error_reporting(0);
@$url=$_POST['url'];
@unlink("/nobodys3cr3t/".base64_encode($url));
?>