<?php

class VIM_Installer
{
    /* Start auto-generated lines of code. Change made will be overwriten... */

    protected static $_tables = array();
    protected static $_patches = array(
        array(
            'table' => 'xf_user',
            'tableCheckQuery' => 'SHOW TABLES LIKE \'xf_user\'',
            'field' => 'vietnamese_input_method',
            'checkQuery' => 'SHOW COLUMNS FROM `xf_user` LIKE \'vietnamese_input_method\'',
            'addQuery' => 'ALTER TABLE `xf_user` ADD COLUMN `vietnamese_input_method` MEDIUMBLOB',
            'modifyQuery' => 'ALTER TABLE `xf_user` MODIFY COLUMN `vietnamese_input_method` MEDIUMBLOB',
            'dropQuery' => 'ALTER TABLE `xf_user` DROP COLUMN `vietnamese_input_method`',
        ),
    );

    public static function install($existingAddOn, $addOnData)
    {
        $db = XenForo_Application::get('db');

        foreach (self::$_tables as $table) {
            $db->query($table['createQuery']);
        }

        foreach (self::$_patches as $patch) {
            $tableExisted = $db->fetchOne($patch['tableCheckQuery']);
            if (empty($tableExisted)) {
                continue;
            }

            $existed = $db->fetchOne($patch['checkQuery']);
            if (empty($existed)) {
                $db->query($patch['addQuery']);
            } else {
                $db->query($patch['modifyQuery']);
            }
        }

        self::installCustomized($existingAddOn, $addOnData);
    }

    public static function uninstall()
    {
        $db = XenForo_Application::get('db');

        foreach (self::$_patches as $patch) {
            $tableExisted = $db->fetchOne($patch['tableCheckQuery']);
            if (empty($tableExisted)) {
                continue;
            }

            $existed = $db->fetchOne($patch['checkQuery']);
            if (!empty($existed)) {
                $db->query($patch['dropQuery']);
            }
        }

        foreach (self::$_tables as $table) {
            $db->query($table['dropQuery']);
        }

        self::uninstallCustomized();
    }

    /* End auto-generated lines of code. Feel free to make changes below */

    public static function installCustomized($existingAddOn, $addOnData)
    {
        if (XenForo_Application::$versionId < 1020000) {
            throw new XenForo_Exception('XenForo v1.2.0+ is required.');
        }
    }

    public static function uninstallCustomized()
    {
        // customized uninstall script goes here
    }

}