<?php

	/**
	*	OptimaSystem developed by OptimaWeb, 2012
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
		/*echo "<h1>OptimaSystem</h1>";
		echo "<h2>Error: Page not found.</h2>";
		exit;*/
		header('Location: index.html');
	}
	
	// Template manager
	$templateManager = new TemplateManager();
	if($templateManager->exists() == false)
	{
		/*echo "<h1>OptimaSystem</h1>";
		echo "<h2>Error in TemplateManager</h2>";
		exit;*/
		header('Location: index.html');
	}
	
	// Setup the page
	$templateManager->setParam("{PAGE_TITLE}", $pageManager->getPageTitle());
	
	// Display the page
	echo $templateManager->getHeader();
	echo $pageManager->getPageContent();
	echo $templateManager->getFooter();
	
?>