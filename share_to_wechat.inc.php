<?php


if(!defined('IN_DISCUZ')) {
	exit('Access Denied');
}


include('phpqrcode/qrlib.php');
global $_G;

$threadqr = isset($_GET['threadqr'])? intval($_GET['threadqr']):0;


$share = isset($_GET['share']) ? $_GET['share']:0;

if($share == 'yes') {
	$errorCorrectionLevel = 'L';
	$matrixPointSize = 5;
	$tempDir = 'data/plugindata/';
	$fileName = 'qrcode_'.md5($threadqr).time().'.png'; 

	$pngAbsoluteFilePath = $tempDir.$fileName;

	if(!isset($_GET['chl'])) {
		$url = $_G['siteurl'].'forum.php?mod=viewthread&tid='.$threadqr;
	}
	else {
		$url = urldecode($_GET['chl']);

	}

	QRcode::png($url, $pngAbsoluteFilePath, $errorCorrectionLevel, $matrixPointSize, 2);
	
	include_once template('share_to_wechat:qrcode');

	imagedestroy($pngAbsoluteFilePath);
}

?>