<?php
require('placeholder.class.php');

$w = isset($_GET['w']) ? trim($_GET['w']) : null;
$h = isset($_GET['h']) ? trim($_GET['h']) : null;
$bgColor = isset($_GET['bgColor']) ? strtolower(trim($_GET['bgColor'])) : null;
$textColor = isset($_GET['textColor']) ? strtolower(trim($_GET['textColor'])) : null;

try {
	$placeholder = new Placeholder();
	$placeholder->setWidth($w);
	$placeholder->setHeight($h);
	if ($bgColor) $placeholder->setBgColor($bgColor);
	if ($textColor) $placeholder->setTextColor($textColor);
	$placeholder->render();
} catch (Exception $e){
	die($e->getMessage());
}