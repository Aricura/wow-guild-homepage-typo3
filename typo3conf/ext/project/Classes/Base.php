<?php

declare(strict_types=1);

namespace Project\Classes;

use TYPO3\CMS\Frontend\Controller\TypoScriptFrontendController;

/**
 * Abstract base class for the entire Typo3 extension.
 */
abstract class Base
{

	/**
	 * @var \Twig_Loader_Filesystem
	 */
	private $twigLoader;
	/**
	 * @var \Twig_Environment
	 */
	private $twigEnvironment;
	/**
	 * @var TypoScriptFrontendController
	 */
	private $frontendController;

	/**
	 * Renders a template.
	 *
	 * @param string $name    The template name
	 * @param array  $context An array of parameters to pass to the template
	 *
	 * @return string
	 */
	protected function twig(string $name, array $context = []): string
	{
		if (!$this->twigLoader) {
			$this->twigLoader = new \Twig_Loader_Filesystem(\dirname(__FILE__) . '/../Resources/views/');
		}

		if (!$this->twigEnvironment) {
			$this->twigEnvironment = new \Twig_Environment($this->twigLoader);
		}

		try {
			return $this->twigEnvironment->render($name, $context);
		} catch (\Exception $exception) {
			return '';
		}
	}

	/**
	 * Inject the typoscript frontend controller.
	 *
	 * @param \TYPO3\CMS\Frontend\Controller\TypoScriptFrontendController $frontendController
	 */
	public function injectTypoScriptFrontendController(TypoScriptFrontendController $frontendController)
	{
		$this->frontendController = $frontendController;
	}

	/**
	 * Returns the typoscript frontend controller instance.
	 *
	 * @return mixed|\TYPO3\CMS\Frontend\Controller\TypoScriptFrontendController
	 */
	protected function frontendController()
	{
		if ($this->frontendController instanceof TypoScriptFrontendController) {
			return $this->frontendController;
		}

		return $GLOBALS['TSFE'];
	}
}
