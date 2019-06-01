<?php


include('phpqrcode/qrlib.php');

$threadqr = isset($_GET['threadqr'])? intval($_GET['threadqr']):0;


$share = isset($_GET['share']) ? $_GET['share']:0;

if($share == 'yes') {
	$errorCorrectionLevel = 'L';
	$matrixPointSize = 5;
	$tempDir = 'data/plugindata/';
	$fileName = 'qrcode_'.md5($threadqr).'.png'; 

	$pngAbsoluteFilePath = $tempDir.$fileName;

	//QRcode::png($global_url, $fileName, $errorCorrectionLevel, $matrixPointSize, 2);
	$threadqr     = isset($_GET['threadqr'])? intval($_GET['threadqr']):0;
	$url = $_G['siteurl'].'forum.php?mod=viewthread&tid='.$threadqr;

	QRcode::png($url, $pngAbsoluteFilePath, $errorCorrectionLevel, $matrixPointSize, 2);
	
	include_once template('share_to_wechat:qrcode');
}

?>