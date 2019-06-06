<?php


if(!defined('IN_DISCUZ')) {
	exit('Access Denied');
}


include('phpqrcode/qrlib.php');
global $_G;

$threadqr = isset($_GET['threadqr'])? intval($_GET['threadqr']):0;


$share = isset($_GET['share']) ? $_GET['share']:0;

if($share == 'yes') {
	$errorCorrectionLevel = 'M';
	$matrixPointSize = 5;
	$tempDir = 'source/plugin/share_to_wechat/';
	$fileName = 'qrcode_'.md5($threadqr).time(); 
	$pngAbsoluteFilePath = $tempDir.$fileName.'.png';

	if(!isset($_GET['chl'])) {
		$url = $_G['siteurl'].'forum.php?mod=viewthread&tid='.$threadqr;
	}
	else {
		$url = urldecode($_GET['chl']);

	}

	QRcode::png($url, $pngAbsoluteFilePath, $errorCorrectionLevel, $matrixPointSize, 2);


	$logo = 'source/plugin/share_to_wechat/images/logo.png';

	if($logo !== FLASE) {
		$image = imagecreatefromstring(file_get_contents($pngAbsoluteFilePath));
		$logo = imagecreatefromstring(file_get_contents($logo));
		$QR_width = imagesx($image);
		$QR_height = imagesy($image);
		$logo_width = imagesx($logo);
		$logo_height = imagesy($logo);

		$logo_QR_width = $QR_width / 5;
		$scale = $logo_width / $logo_QR_width;
		$logo_QR_height = $logo_height / $scale;
		$from_width = ($QR_width - $logo_QR_width) / 2;

		imagecopyresampled($image, $logo, $from_width, $from_width, 0, 0, $logo_QR_width, $logo_QR_height, $logo_width, $logo_height);

		imagepng($image, $pngAbsoluteFilePath);
	}
	
	include_once template('share_to_wechat:qrcode');

	
	//unlink($pngAbsoluteFilePath);
}

?>