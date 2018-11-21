<?php
header("Content-disposition: attachment; filename=Video_vertical.pptx");
header("Content-type: application/vnd.ms-powerpoint");
readfile("Video_vertical.pptx");
?>
