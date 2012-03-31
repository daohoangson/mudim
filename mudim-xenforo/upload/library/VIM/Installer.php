<?php
class VIM_Installer {
	public static function install() {
		$db = XenForo_Application::get('db');
		
		$existed = $db->fetchOne("SHOW COLUMNS FROM `xf_user` LIKE 'vietnamese_input_method'");
		if (empty($existed)) {
			$db->query("ALTER TABLE `xf_user` ADD COLUMN `vietnamese_input_method` BLOB");
		}
	}
	
	public static function uninstall() {
		
	}
}