<?php

declare(strict_types=1);

namespace Project\Classes\Helper;

use Project\Classes\ContentService\Models\TtContent;
use TYPO3\CMS\Frontend\ContentObject\ContentObjectRenderer;

/**
 * Content Element renderer.
 */
class Renderer
{

	/**
	 * Inject by the user function call from TYPO3 :/.
	 *
	 * @var ContentObjectRenderer
	 */
	public $cObj;

	/**
	 * @param string $content       The content. Not used
	 * @param array  $configuration The TS configuration array
	 *
	 * @return string $content The processed content
	 */
	public function handle(string $content, array $configuration): string
	{
		/** @var \Project\Classes\Base $controller */
		$controller = new $configuration['controller'];
		$controller->element = TtContent::inject((array) $this->cObj->data);;

		return $controller->render();
	}
}
