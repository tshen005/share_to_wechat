<?php


if(!defined('IN_DISCUZ')) {
	exit('Access Denied');
}


if(isset($_GET['path'])){
	unlink($_GET['path'].'.png');
	//unlink('source/plugin/share_to_wechat/'.$_GET['path'].'.png');
}

$_GET['handlekey'];

?>