<?php
header("Content-disposition: attachment; filename=Video_promocional.pptx");
header("Content-type: application/vnd.ms-powerpoint");
readfile("Video_promocional.pptx");
?>
