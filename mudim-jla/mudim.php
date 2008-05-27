<?php
function mudim_include_js(){
	global $mainframe;
	$document = & JFactory :: getDocument();
	$doctype = $document->getType();
	if ($doctype == 'html') {
		$body = JResponse :: getBody();
		$body = str_ireplace('<head>','<head><script src="/test/joomla/includes/js/mudim.js"></script>',$body);
		$i = stripos($body,'<head>');
		if ($i !== false) {
			$baseurl = $mainframe->isAdmin() ? $mainframe->getSiteURL() : JURI::base();
			$newbody=substr($body,0,$i+1).'<head><script src="'.$baseurl.'/includes/js/mudim.js"></script>'.substr($body,$i+6);
			JResponse :: setBody($newbody);
		}
	}
}
$mainframe->registerEvent('onAfterRender','mudim_include_js');
?>
