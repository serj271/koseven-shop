<?php

class Autoload_ClassLoader {
	private $namespace;
	private $namespaceSeparator = '\\';
	private $includePath;
	private $fileExtension;

	public function __construct($ns = null, $includePath = null)
	{
		$this->fileExtension = EXT;
		$this->namespace = $ns;
		$this->includePath = $includePath;
	}

	public function __get($var) {
		if(property_exists($this, $var)) return $this->$var;
		return;
	}
	
	public function __set($var, $val) {
		if(property_exists($this, $var)) return $this->$var = $val;
		return;
	}

	public function register()
	{
		spl_autoload_register(array($this, 'loadClass'));
	}

	public function unregister()
	{
		spl_autoload_unregister(array($this, 'loadClass'));
	}

	public function loadClass($className)
	{
		if ($this->namespace !== null && strpos($className, $this->namespace.$this->namespaceSeparator) !== 0) {
			return false;
		} else {
			$filename = str_replace($this->namespace . $this->namespaceSeparator, DIRECTORY_SEPARATOR, $className) . $this->fileExtension;
			$filename = strtolower($filename);
			$filename = str_replace("_",DIRECTORY_SEPARATOR, $filename);

			if (!file_exists($this->includePath . $filename)) {
				return false;
			}

			require $this->includePath . $filename;
			return true;
		}
	}
}