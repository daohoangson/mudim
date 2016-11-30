<?php

class VIM_XenForo_ControllerPublic_Account extends XFCP_VIM_XenForo_ControllerPublic_Account
{
    public function actionPreferencesSave()
    {
        $GLOBALS['VIM_XenForo_ControllerPublic_Account::actionPreferencesSave'] = $this;

        return parent::actionPreferencesSave();
    }

    public function VIM_actionPreferencesSave(XenForo_DataWriter_User $userDw)
    {
        $input = $this->_input->filter(array(
            'vim_preferences' => XenForo_Input::UINT,
            'vim' => XenForo_Input::ARRAY_SIMPLE,
        ));

        if ($input['vim_preferences'] > 0) {
            $optionsInput = new XenForo_Input($input['vim']);
            $options = $optionsInput->filter(array(
                'method' => XenForo_Input::UINT,
                'speller' => XenForo_Input::UINT,
                'accentRule' => XenForo_Input::UINT,
            ));
            $userDw->set('vietnamese_input_method', $options);
        }
    }
}