<?php

	/**
	*	OptimaSystem, 2012
	*	Version 1.0
	*/

	// Include config file
	require_once("config.php");
	require_once("includes/pageManager.inc.php");
	require_once("includes/templateManager.inc.php");

	// URL
	$pageName = $GLOBALS["DEFAULT_PAGE"];
	if(isset($_GET[$GLOBALS["URL_PAGE_NAME_TAG"]]))
	{
		$pageName = htmlentities($_GET[$GLOBALS["URL_PAGE_NAME_TAG"]]);
	}
	
	// Check URL and if invalid, get the Index
	if(strlen($pageName) == 0)
	{
		$pageName = $GLOBALS["DEFAULT_PAGE"];
	}
	
	// Page manager
	$pageManager = new PageManager($pageName);
	if($pageManager->exists() == false)
	{
		header('Location: index.html');
	}
	
	// Template manager
	$templateManager = new TemplateManager();
	if($templateManager->exists() == false)
	{
		header('Location: index.html');
	}
	
	// Setup the page
	$templateManager->setParam("{PAGE_TITLE}", $GLOBALS["SITE_NAME"] . " - " . $pageManager->getPageTitle());
	
	// Display the page
	echo $templateManager->getHeader();
	echo $pageManager->getPageContent();
	echo $templateManager->getFooter();
	
?>