<?php
header("Content-disposition: attachment; filename=Video_Principal.pptx");
header("Content-type: application/vnd.ms-powerpoint");
readfile("Video_Principal.pptx");
?>
