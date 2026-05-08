<?php

$gotoPage = $_GET['goto_page'];
$msg = $_GET['message'];

header("location:$gotoPage?message=$msg");
exit;
?>