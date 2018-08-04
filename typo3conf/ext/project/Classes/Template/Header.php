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
	 * Collection of all css files inside the / directory being rendered in the website's <head>.
	 *
	 * @var array
	 */
	private static $cssFiles = [
		'dist/main.css',
	];
	/**
	 * Collection of all js files inside the / directory being rendered in the website's <head>.
	 * The array key is the relative file name and its value is the render type/attribute (inline, async or defer).
	 *
	 * @var array
	 */
	private static $jsFiles = [
		'dist/main.js' => 'defer',
	];
	/**
	 * Content of the laravel mix manifest json file (mis-manifest.json).
	 *
	 * @var array
	 */
	protected $mixManifest = [];

	/**
	 * Header constructor.
	 */
	public function __construct()
	{
		// get the laravel mix manifest file
		$mixManifestContent = \file_get_contents(PATH_site . 'mix-manifest.json');
		$this->mixManifest = \json_decode($mixManifestContent, true);

		if (!\is_array($this->mixManifest)) {
			$this->mixManifest = [];
		}
	}

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
			'L' => (int)$this->frontendController()->sys_language_uid,
		];

		return $this->twigArray('page/head.html.twig', $twigData);
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
	 * @param string $filePath relative file path and name inside the / directory
	 *
	 * @return string
	 */
	private function appendVersionToFilePath(string $filePath): string
	{
		// get the absolute file path of this asset
		$absoluteFilePath = PATH_site . $filePath;

		if (!\file_exists($absoluteFilePath)) {
			return '';
		}

		// return a custom hashed version of the asset as there was an error reading the manifest file
		if (!\array_key_exists('/' . $filePath, $this->mixManifest)) {
			return '/' . $filePath . '?v=' . \filemtime($absoluteFilePath);
		}

		// return the manifest version of this asset
		return $this->mixManifest['/' . $filePath];
	}

	/**
	 * Returns the html tag to include the specified css file.
	 * Returns an empty string if the file does not exist.
	 *
	 * @param string $filePath relative file path and name inside the / directory
	 *
	 * @return string
	 */
	private function includeCss(string $filePath): string
	{
		// prepend the directory name where all css files are located in
		$filePath = \trim($filePath, '/');

		// get the versioned file path and name
		$filePath = $this->appendVersionToFilePath($filePath);

		return $filePath ? '<link rel="stylesheet" type="text/css" href="' . $filePath . '" media="all">' : '';
	}

	/**
	 * Returns either the html tag to include the specified js file as external resource or the inline js code.
	 * Returns an empty string if the file does not exist.
	 *
	 * @param string $filePath  relative file path and name inside the / directory
	 * @param string $attribute the type/attribute how the js code/file should be included (ether inline, async or
	 *                          defer)
	 *
	 * @return string
	 */
	private function includeJs(string $filePath, string $attribute): string
	{
		// prepend the directory name where all js files are located in
		$filePath = \trim($filePath, '/');

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
