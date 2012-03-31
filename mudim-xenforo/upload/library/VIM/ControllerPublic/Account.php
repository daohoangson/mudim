<?php
class VIM_ControllerPublic_Account extends XFCP_VIM_ControllerPublic_Account {
	public function actionPreferencesSave() {
		$response = parent::actionPreferencesSave();
		
		if ($response instanceof XenForo_ControllerResponse_Redirect) {
			// do our job as parent worked (and redirected)
			$vim = $this->_input->filterSingle('vim', XenForo_Input::ARRAY_SIMPLE);
			$db = XenForo_Application::get('db'); 
			$db->update('xf_user', array('vietnamese_input_method' => serialize($vim)), array('user_id = ?' => XenForo_Visitor::getUserId()));
			// I know the updating procedure looks ugly but it works and it's simple :) Peace out
		}
		
		return $response;
	}
}