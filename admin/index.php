<?php


require_once(dirname(__FILE__).'/../config/ProjectConfiguration.class.php');

$env = $_SERVER['ENVIRONMENT'];

switch ($env) {
	case 'DEV':
		$configuration = ProjectConfiguration::getApplicationConfiguration('admin', 'dev', true);
		break;
	case 'STAGE':
		$configuration = ProjectConfiguration::getApplicationConfiguration('admin', 'stage', true);
		break;
	default:
		//Default is PROD
		$configuration = ProjectConfiguration::getApplicationConfiguration('admin', 'prod', false);
		break;
}

sfContext::createInstance($configuration)->dispatch();
