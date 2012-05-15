<?php
// get values from URL parameters
$width = isset($_GET['w']) ? trim($_GET['w']) : null;
$height = isset($_GET['h']) ? trim($_GET['h']) : null;
$bgColor = isset($_GET['bgColor']) ? strtolower(trim($_GET['bgColor'])) : null;
$textColor = isset($_GET['textColor']) ? strtolower(trim($_GET['textColor'])) : null;

require('placeholder.class.php');

try {
	$placeholder = new Placeholder();
	$placeholder->setWidth($width);
	$placeholder->setHeight($height);
	if ($bgColor) $placeholder->setBgColor($bgColor);
	if ($textColor) $placeholder->setTextColor($textColor);
	$placeholder->render();
} catch (Exception $e){
	die($e->getMessage());
}
