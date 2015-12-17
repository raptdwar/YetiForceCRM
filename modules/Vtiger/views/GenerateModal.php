<?php

/**
 * @package YetiForce.ModalView
 * @license licenses/License.html
 * @author Radosław Skrzypczak <r.skrzypczak@yetiforce.com>
 */
class Vtiger_GenerateModal_View extends Vtiger_BasicModal_View
{

	public function preProcess(Vtiger_Request $request)
	{
		echo '<div class="generateMappingModal modal fade"><div class="modal-dialog"><div class="modal-content">';
	}

	function process(Vtiger_Request $request)
	{
		$log = vglobal('log');
		$log->debug('Entering ' . __CLASS__ . '::' . __METHOD__ . '() method ...');

		$moduleName = $request->getModule();
		$recordId = $request->get('record');
		$view = $request->get('fromview');
		$viewer = $this->getViewer($request);
		$handlerClass = Vtiger_Loader::getComponentClassName('Model', 'MappedFields', $moduleName);
		$mfModel = new $handlerClass();
		if ($view == 'List') {
			$allRecords = Vtiger_Mass_Action::getRecordsListFromRequest($request);
			$templates = $mfModel->getActiveTemplatesForModule($moduleName, $view);
			$viewer->assign('ALL_RECORDS', $allRecords);
		} else {
			$templates = $mfModel->getActiveTemplatesForRecord($recordId, $view, $moduleName);
			$viewer->assign('RECORD', $recordId);
		}

		$viewer->assign('TEMPLATES', $templates);
		$viewer->assign('VIEW', $view);
		$viewer->assign('MODULE_NAME', $moduleName);
		$viewer->assign('BASE_MODULE_NAME', 'Vtiger');
		$this->preProcess($request);
		$viewer->view('GenerateModal.tpl', $qualifiedModule);
		$this->postProcess($request);
		$log->debug('Exiting ' . __CLASS__ . '::' . __METHOD__ . ' method ...');
	}
}
