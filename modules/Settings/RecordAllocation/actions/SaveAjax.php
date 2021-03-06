<?php

/**
 * @package YetiForce.Action
 * @license licenses/License.html
 * @author Radosław Skrzypczak <r.skrzypczak@yetiforce.com>
 */
class Settings_RecordAllocation_SaveAjax_Action extends Settings_Vtiger_Index_Action
{

	function __construct()
	{
		parent::__construct();
		$this->exposeMethod('save');
		$this->exposeMethod('removePanel');
	}

	function save(Vtiger_Request $request)
	{
		$data = $request->get('param');
		$qualifiedModuleName = $request->getModule(false);

		$moduleInstance = Settings_Vtiger_Module_Model::getInstance($qualifiedModuleName);
		$moduleInstance->set('type', $data['type']);
		$moduleInstance->save(array_filter($data));

		$responceToEmit = new Vtiger_Response();
		$responceToEmit->setResult(true);
		$responceToEmit->emit();
	}

	function removePanel(Vtiger_Request $request)
	{
		$data = $request->get('param');
		$moduleName = $data['module'];
		$qualifiedModuleName = $request->getModule(false);

		$moduleInstance = Settings_Vtiger_Module_Model::getInstance($qualifiedModuleName);
		$moduleInstance->set('type', $data['type']);
		$moduleInstance->remove($moduleName);

		$responceToEmit = new Vtiger_Response();
		$responceToEmit->setResult(true);
		$responceToEmit->emit();
	}
}
