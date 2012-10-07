<?php
	
	/**
	*	OptimaSystem, 2012
	*	Version 1.0
	*/

	class Language
	{
		const FRENCH = "fr";
		const ENGLISH = "en";
		const ESPANOL = "es";
	};
	
	class PageManager
	{
		private $pageName;
		private $exists = false;
		private $content;
		private $pageTitle;
		private $filePath = "";
		private $xmlPath = "";
		private $language = Language::FRENCH;
		
		public function PageManager($urlPageName)
		{
			if($this->isPageExists($urlPageName))
			{
				$this->pageName = $urlPageName;
				$this->exists = true;
				$this->content = file_get_contents($this->filePath);
				
				// Detect language
				$this->detectLanguage();
				
				$this->extractXML();
				$this->init();
			}
		}
		
		private function isPageExists($pageName)
		{
			$this->filePath = $GLOBALS["PAGES_FOLDER"] . "/" . $pageName . $GLOBALS["PAGE_NAME_STRUCTURE"];
			$this->xmlPath = $GLOBALS["PAGES_FOLDER"] . "/" . $pageName . $GLOBALS["PAGE_INFO_STRUCTURE"];
			
			if(file_exists($this->filePath) && file_exists($this->xmlPath))
			{
				return true;
			}
			return false;
		}
		
		private function init()
		{
			$this->content = str_replace("{SYSTEM_IMAGE}", $GLOBALS["IMAGE_FOLDER"], $this->content);
			$this->content = str_replace("{SYSTEM_FILE}", $GLOBALS["FILE_FOLDER"], $this->content);
		}
		
		private function detectLanguage()
		{
			$lang = substr($_SERVER['HTTP_ACCEPT_LANGUAGE'], 0, 2);
			switch ($lang)
			{
				case "fr":
					$this->language = Language::FRENCH;
				break;
				case "en":
					$this->language = Language::ENGLISH;
				break;
				default:
					$this->language = Language::FRENCH;
				break;
			}
		}
		
		private function extractXML()
		{
			// Load the XML file
			$XML = simplexml_load_file($this->xmlPath);
			
			// Extract the page Title
			foreach($XML->{"title"} as $child)
			{
				if($child->getName() == "title")
				{
					$this->pageTitle =(string)$child;
				}
			}
			
			// Extract global language
			foreach($XML->{"language"}->children() as $id => $child)
			{
				$this->content = str_replace("{". $id ."}", $child, $this->content);
			}
			
			// Extract the language
			foreach($XML->{"language"}->{$this->language}->children() as $id => $child)
			{
				$this->content = str_replace("{". $id ."}", $child, $this->content);
			}
		}
		
		public function exists()
		{
			return $this->exists;
		}
		
		public function getPageContent()
		{
			return $this->content;
		}
		
		public function getPageTitle()
		{
			return $this->pageTitle;
		}
	}
	
?>