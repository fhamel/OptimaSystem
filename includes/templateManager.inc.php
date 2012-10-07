<?php

	/**
	*	OptimaSystem, 2012
	*	Version 1.0
	*/

	class TemplateManager
	{
		private $header;
		private $footer;
		private $exists = false;
		
		public function TemplateManager()
		{
			$headerPath = $GLOBALS["TEMPLATE_FOLDER"] . "/" . $GLOBALS["TEMPLATE_HEADER_PAGE"];
			$footerPath = $GLOBALS["TEMPLATE_FOLDER"] . "/" . $GLOBALS["TEMPLATE_FOOTER_PAGE"];
		
			if(file_exists($headerPath) && file_exists($footerPath))
			{
				$this->header = file_get_contents($headerPath);
				$this->footer = file_get_contents($footerPath);
				$this->exists = true;
				$this->init();
			}
		}
		
		private function init()
		{
			// Setup Meta
			$this->setParam("{META_DESCRIPTION}", $GLOBALS["META_DESCRIPTION"]);
			$this->setParam("{META_KEYWORDS}", $GLOBALS["META_KEYWORDS"]);
			$this->setParam("{META_AUTHOR}", $GLOBALS["META_AUTHOR"]);
			$this->setParam("{SYSTEM_CSS}", $GLOBALS["CSS_FOLDER"]);
			$this->setParam("{SYSTEM_JAVASCRIPT}", $GLOBALS["JAVASCRIPT_FOLDER"]);
		}
				
		public function exists()
		{
			return $this->exists;
		}
		
		public function setParam($tag, $value)
		{
			$this->header = str_replace($tag, $value, $this->header);
		}
		
		public function getHeader()
		{
			return $this->header;
		}
		
		public function getFooter()
		{
			return $this->footer;
		}
	}

?>