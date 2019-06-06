<?php

if(!defined('IN_DISCUZ')) {
	exit('Access Denied');
}

require_once "jssdk.php";
class plugin_share_to_wechat {

	function _fetch_shared_content(){
		global $_G;
		if($_G['basescript'] == 'forum' && CURMODULE == 'viewthread' && $_G[forum_thread][tid] && $_G[forum_thread][authorid]) {
			$threadTable = DB::fetch_all('SELECT * FROM '.DB::table('forum_attachment').' WHERE tid = '.$_G[forum_thread][tid].' AND uid = '.$_G[forum_thread][authorid].' LIMIT 0 ,'. 1);
			if($threadTable['0'][aid]){
				$attachmentTable = DB::fetch_first('SELECT * FROM '.DB::table('forum_attachment_'.$threadTable['0'][tableid]).' WHERE tid = '.$_G[forum_thread][tid].' AND aid = '.$threadTable['0'][aid]);
				$content[imgUrl] = $_G['siteurl'].'data/attachment/forum/'.$attachmentTable[attachment];
			}
			
			$message = DB::fetch_all('SELECT * FROM '.DB::table('forum_post').' WHERE tid = '.$_G[forum_thread][tid].' AND first = 1');
			$content[desc] = $message['0'][message];
			$space=array(" ","　","\t","\n","\r");
			$content[desc] = str_replace($space,'', $content[desc]);
			$content[title] = trim($_G[forum_thread][subject]);	
		}
		if($_G['basescript'] == 'forum' && CURMODULE =='forumdisplay'){
			$content[title] = $_G['setting'][sitename];
		}

		if(empty($content[imgUrl]) || !isset($content[imgUrl])){
			$content[imgUrl] = $_G[cache][plugin][share_to_wechat][default_imgUrl];
		}
		if(empty($content[desc]) || !isset($content[desc])) {
			$content[desc] = $_G[cache][plugin][share_to_wechat][default_desc];
		}

		return $content;
	}

	function _viewthread_useraction_output(){
		global $_G;
		
		if($_G[cache][plugin][share_to_wechat][position] == 2) return '';

		$content = $this->_fetch_shared_content();

		// get AppID & AppSecret from cache
		
		$AppID = $_G[cache][plugin][share_to_wechat][AppID];
		$AppSecret = $_G[cache][plugin][share_to_wechat][AppSecret];

		$jssdk = new JSSDK($AppID, $AppSecret);
		$signPackage = $jssdk->GetSignPackage();
		

    	$urlToEncode = urlencode($signPackage["url"]);

		include_once template('share_to_wechat:index');
	
		return $return;
	}

	function viewthread_postfooter_output() {
		global $_G;
		
		if($_G[cache][plugin][share_to_wechat][position] != 2) return array();

		$content = $this->_fetch_shared_content();

		$AppID = $_G[cache][plugin][share_to_wechat][AppID];
		$AppSecret = $_G[cache][plugin][share_to_wechat][AppSecret];

		$jssdk = new JSSDK($AppID, $AppSecret);
		$signPackage = $jssdk->GetSignPackage();
		

    	$urlToEncode = urlencode($signPackage["url"]);

		include_once template('share_to_wechat:index');
		
		return array($return);
	}

}


class plugin_share_to_wechat_forum extends plugin_share_to_wechat{

	function viewthread_useraction_output() {
		return $this->_viewthread_useraction_output();
	}


}


?>