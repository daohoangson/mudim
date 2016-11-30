<?php

class VIM_XenForo_DataWriter_User extends XFCP_VIM_XenForo_DataWriter_User
{
    protected function _getFields()
    {
        $fields = parent::_getFields();

        $fields['xf_user']['vietnamese_input_method'] = array('type' => XenForo_DataWriter::TYPE_SERIALIZED);

        return $fields;
    }

    protected function _preSave()
    {
        parent::_preSave();

        if (isset($GLOBALS['VIM_XenForo_ControllerPublic_Account::actionPreferencesSave'])) {
            /** @var VIM_XenForo_ControllerPublic_Account $controller */
            $controller = $GLOBALS['VIM_XenForo_ControllerPublic_Account::actionPreferencesSave'];
            $controller->VIM_actionPreferencesSave($this);
        }
    }
}