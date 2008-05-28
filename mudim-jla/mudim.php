<?php
function mudim_include_js(){
	global $mainframe;
	$document = & JFactory :: getDocument();
	$doctype = $document->getType();
	if ($doctype == 'html') {
		$body = JResponse :: getBody();
		$i = stripos($body,'<head>');
		if ($i !== false) {
			$baseurl = $mainframe->isAdmin() ? $mainframe->getSiteURL() : JURI::base();
			$newbody=substr($body,0,$i).'<head><script src="'.$baseurl.'plugins/system/mudim/mudim.js"></script>'.substr($body,$i+6);
			JResponse :: setBody($newbody);
		}
	}
}
$mainframe->registerEvent('onAfterRender','mudim_include_js');
?>
