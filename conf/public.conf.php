<?php 

/*
 * $isDebug  true  表示开发模式
 * $isDebug  false 表示线上模式
 */
$isDebug = false;

return require_once $isDebug ? "public.dev.conf.php" : "public.prod.conf.php";
