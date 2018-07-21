<?php

declare(strict_types=1);

namespace Project\Classes\Template;

use Project\Classes\Base;

/**
 * Renders the website's <head> data (assets).
 */
class Header extends Base
{

	/**
	 * Collection of all css files inside the assets/css/ directory being rendered in the website's <head>.
	 *
	 * @var array
	 */
	private static $cssFiles = [
		'vendor.min.css',
		'main.min.css',
	];
	/**
	 * Collection of all js files inside the assets/js/ directory being rendered in the website's <head>.
	 * The array key is the relative file name and its value is the render type/attribute (inline, async or defer).
	 *
	 * @var array
	 */
	private static $jsFiles = [
		'vendor.js' => 'defer',
		'main.js' => 'defer',
	];

	/**
	 * Returns all header data.
	 *
	 * @return string
	 */
	public function render(): string
	{
		// create a collection of all twig data which aren't static and can't be written in the twig file directly
		$twigData = [
			'css' => $this->css(),
			'js' => $this->js(),
			'L' => (int)$this->frontendController->sys_language_uid,
		];

		return $this->twig('page/head/default.html.twig', $twigData);
	}

	/**
	 * Returns the html tags to include all stylesheets to the website's <head>.
	 *
	 * @return string
	 */
	private function css(): string
	{
		$assets = [];

		// iterate through each css file and append it as asset
		foreach (self::$cssFiles as $filePath) {
			$assets[] = $this->includeCss($filePath);
		}

		return \implode('', $assets);
	}

	/**
	 * Returns the html tags to include all javascript files to the website's <head>.
	 *
	 * @return string
	 */
	private function js(): string
	{
		$assets = [];

		// iterate through each js file and append it as asset
		foreach (self::$jsFiles as $filePath => $attribute) {
			$assets[] = $this->includeJs($filePath, $attribute);
		}

		return \implode('', $assets);
	}

	/**
	 * Appends a version information (last modified timestamp) as query parameter to the specified file.
	 * Returns an empty string if the file does not exist.
	 *
	 * @param string $filePath relative file path and name inside the web/ directory
	 *
	 * @return string
	 */
	private function appendVersionToFilePath(string $filePath): string
	{
		// get the absolute file path as we need to read its last modified timestamp
		$absoluteFilePath = PATH_site . $filePath;

		return \file_exists($absoluteFilePath) ? '/' . $filePath . '?v=' . \filemtime($absoluteFilePath) : '';
	}

	/**
	 * Returns the html tag to include the specified css file.
	 * Returns an empty string if the file does not exist.
	 *
	 * @param string $filePath relative file path and name inside the web/css/ directory
	 *
	 * @return string
	 */
	private function includeCss(string $filePath): string
	{
		// prepend the directory name where all css files are located in
		$filePath = 'assets/css/' . \trim($filePath, '/');

		// get the versioned file path and name
		$filePath = $this->appendVersionToFilePath($filePath);

		return $filePath ? '<link rel="stylesheet" type="text/css" href="' . $filePath . '" media="all">' : '';
	}

	/**
	 * Returns either the html tag to include the specified js file as external resource or the inline js code.
	 * Returns an empty string if the file does not exist.
	 *
	 * @param string $filePath  relative file path and name inside the web/js/ directory
	 * @param string $attribute the type/attribute how the js code/file should be included (ether inline, async or
	 *                          defer)
	 *
	 * @return string
	 */
	private function includeJs(string $filePath, string $attribute): string
	{
		// prepend the directory name where all js files are located in
		$filePath = 'assets/js/' . \trim($filePath, '/');

		// check if the js file should be included as inline resource
		if ('inline' === \mb_strtolower($attribute)) {
			// inline script requires the absolute path to read the content
			$filePath = PATH_site . $filePath;

			return \file_exists($filePath) ? '<script>' . \file_get_contents($filePath) . '</script>' : '';
		}

		// get the versioned file path and name
		$filePath = $this->appendVersionToFilePath($filePath);

		return $filePath ? '<script src="' . $filePath . '" ' . $attribute . '></script>' : '';
	}
}
