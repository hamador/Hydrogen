<?php
/*
 * Copyright (c) 2009 - 2011, Frosted Design
 * All rights reserved.
 */

namespace hydrogen\view\engines\hydrogen;

use hydrogen\config\Config;
use hydrogen\view\TemplateEngine;
use hydrogen\view\engines\hydrogen\Parser;

class HydrogenEngine implements TemplateEngine {
	
	protected static $filterClass = array();
	protected static $filterPath = array();
	protected static $filterNamespace = array(
		'\hydrogen\view\engines\hydrogen\filters\\'
		);
	protected static $tagClass = array();
	protected static $tagPath = array();
	protected static $tagNamespace = array(
		'\hydrogen\view\engines\hydrogen\tags\\'
		);

	public static function addFilter($filterName, $className, $path=false) {
		$filterName = strtolower($filterName);
		static::$filterClass[$filterName] = $className;
		if ($path)
			static::$filterPath[$filterName] = Config::getAbsolutePath($path);
	}
	
	public static function addFilterNamespace($namespace) {
		static::$filterNamespace[] = static::formatNamespace($namespace);
	}
	
	public static function addTag($tagName, $className, $path=false) {
		$tagName = strtolower($tagName);
		static::$tagClass[$tagName] = $className;
		if ($path)
			static::$tagPath[$tagName] = Config::getAbsolutePath($path);
	}
	
	public static function addTagNamespace($namespace) {
		static::$tagNamespace[] = static::formatNamespace($namespace);
	}
	
	protected static function formatNamespace($namespace) {
		if ($namespace[0] !== '\\')
			$namespace = '\\' . $namespace;
		if ($namespace[strlen($namespace) - 1] !== '\\')
			$namespace .= '\\';
		return $namespace;
	}

	public static function getPHP($templateName, $loader) {
		$parser = new Parser($templateName, $loader);
		$nodes = $parser->parse();
		return $nodes->render();
	}

}

?>