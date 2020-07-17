<?php 
$data =$_POST['postapp'];
echo $data;
list($type, $data) = explode(';', $data);
list(, $data) = explode(',', $data);
$data = base64_decode($data);

file_put_contents('Chart_images/'."4a".'.png', $data);
?>