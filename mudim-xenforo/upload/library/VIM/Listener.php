<?php
class VIM_Listener {
	public static function visitor_setup(XenForo_Visitor &$visitor) {
		$options = XenForo_Application::get('options');
		$default = array(
			'method' => $options->get('vim_method'),
			'speller' => $options->get('vim_speller'),
			'accentRule' => $options->get('vim_accentRule'),
		);
		
		if ($visitor->get('user_id') > 0) {
			$raw = $visitor->get('vietnamese_input_method');
			if (!empty($raw)) {
				// try to unserialize the stored data
				$parsed = @unserialize($raw);
				if (!empty($parsed)) {
					// merge with default to make sure all keys are valid
					foreach ($default as $key => $value) {
						if (!isset($parsed[$key])) {
							$parsed[$key] = false;
						}
					}
				}
			}
		}
		
		$visitor['vietnamese_input_method'] = empty($parsed) ? $default : $parsed;
	}
	
	public static function load_class($class, array &$extend) {
		if ($class == 'XenForo_ControllerPublic_Account') {
			$extend[] = 'VIM_ControllerPublic_Account';
		}
	}
	
	public static function template_create($templateName, array &$params, XenForo_Template_Abstract $template) {
		// always try to preload our template (performance reason)
		if (!defined('VIM_PRELOADED')) {
			$template->preloadTemplate('vim');
			define('VIM_PRELOADED', true);
		}
		
		if ($templateName == 'account_preferences') {
			$template->preloadTemplate('vim_preferences');
		}
	}
	
	public static function template_post_render($templateName, &$content, array &$containerData, XenForo_Template_Abstract $template) {
		if ($templateName == 'PAGE_CONTAINER') {
			// inject our script to page footer
			$avimTemplate = $template->create('vim', $template->getParams());
			$rendered = $avimTemplate->render();
			$search = '</body>';
			$content = str_replace($search, $rendered . $search, $content);
		}
	}
	
	public static function template_hook($hookName, &$contents, array $hookParams, XenForo_Template_Abstract $template) {
		if ($hookName == 'account_preferences_locale') {
			// display our preferences after the locale preferences
			$avimTemplate = $template->create('vim_preferences', $template->getParams());
			$avimTemplate->setParam('vim', XenForo_Visitor::getInstance()->get('vietnamese_input_method'));
			$contents .= $avimTemplate->render();
		}
	}
}