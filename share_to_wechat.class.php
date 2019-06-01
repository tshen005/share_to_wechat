<?php

if(!defined('IN_DISCUZ')) {
	exit('Access Denied');
}


class plugin_share_to_wechat {


	function _viewthread_useraction_output(){
		global $_G;

		global $global_url;
		$global_url = $_G['currenturl_encode'];

		$yourAppID='wx68aa1faefa37936d';
		$yourAppSecret='b9781d79081867f7f986eb31537de285';
		$jssdk = new JSSDK($yourAppID, $yourAppSecret);
		$signPackage = $jssdk->GetSignPackage();

		include_once template('share_to_wechat:index');
		return $return;
	}


}


class plugin_share_to_wechat_forum extends plugin_share_to_wechat{

	function viewthread_useraction_output() {
		return $this->_viewthread_useraction_output();
	}

}


?>