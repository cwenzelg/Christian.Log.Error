<?php
namespace Christian\Log\Error\Command;

/*                                                                        *
 * This script belongs to the TYPO3 Flow package "VOWO.Main".             *
 *                                                                        *
 *                                                                        */

use TYPO3\Flow\Annotations as Flow;
use TYPO3\Flow\Cli\CommandController;
use TYPO3\Flow\Configuration\ConfigurationManager;

/**
 * Command controller for managing cronjob sending of Mails
 *
 * There might be the need to set the environment variable: FLOW_REWRITEURLS=1
 *
 * The baseUri in the TYPO3 Flow Settings.yaml must be set for this controller to work!
 *
 * @Flow\Scope("singleton")
 */
class LogCommandController extends \TYPO3\Flow\Cli\CommandController {

	/**
	 * @Flow\Inject
	 * @var \TYPO3\Flow\Configuration\ConfigurationManager
	 */
	protected $configurationManager;


	public function testCommand(){
		$flowSettings = $this->configurationManager->getConfiguration(ConfigurationManager::CONFIGURATION_TYPE_SETTINGS, 'TYPO3.Flow');
		$httpRequest =\TYPO3\Flow\Http\Request::create(new \TYPO3\Flow\Http\Uri($flowSettings['http']['baseUri']));

		$request = new \TYPO3\Flow\Mvc\ActionRequest($httpRequest);
		$request->setControllerPackageKey('Christian.Log.Error');
		$uriBuilder = new \TYPO3\Flow\Mvc\Routing\UriBuilder();
		$uriBuilder->setRequest($request);
		$uriBuilder->setCreateAbsoluteUri(TRUE);

		$routesConfiguration = $this->configurationManager->getConfiguration(ConfigurationManager::CONFIGURATION_TYPE_ROUTES);
		$router = \TYPO3\Flow\Reflection\ObjectAccess::getProperty($uriBuilder, 'router', TRUE);

		$router->setRoutesConfiguration($routesConfiguration);

		$uriBuilder->uriFor('action', array(), 'NotExisting');
	}


}
