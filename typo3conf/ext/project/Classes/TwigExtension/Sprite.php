<?php

declare(strict_types=1);

namespace Project\Classes\TwigExtension;

/**
 * Twig extension to inject SVG sprites.
 */
class Sprite extends \Twig_Extension
{
	/**
	 * Returns a list of functions to add to the existing list.
	 *
	 * @return \Twig_Function[]
	 */
	public function getFunctions(): array
	{
		return [
			new \Twig_SimpleFunction('sprite', [$this, 'getEmbedSprite'], ['is_safe' => ['html']]),
			new \Twig_SimpleFunction('sprite_inline', [$this, 'getInlineSprite'], ['is_safe' => ['html']]),
		];
	}

	/**
	 * @param        $name
	 * @param string $namespace
	 *
	 * @return string
	 */
	public function getEmbedSprite($name, $namespace = 'global'): string
	{
		return $this->getMarkup($name, $namespace);
	}

	/**
	 * @param        $name
	 * @param string $namespace
	 *
	 * @return string
	 */
	public function getInlineSprite($name, $namespace = 'global'): string
	{
		return $this->getMarkup($name, $namespace, true);
	}

	/**
	 * @param      $name
	 * @param      $namespace
	 * @param bool $inline
	 *
	 * @return string
	 */
	private function getMarkup($name, $namespace, $inline = false): string
	{
		$path = PATH_site.'assets/base/icons/'.$namespace.'/'.$name.'.svg';
		$markup = \file_get_contents($path);

		if (!$inline) {
			$parser = new \SimpleXMLElement($markup);
			$viewbox = (string) $parser->attributes()['viewBox'];
			$class = (string) $parser->attributes()['class'];

			$markup = '<svg class="embed embed--image" viewBox="'.$viewbox.'"><use class="'.$class.'" xlink:href="/static/'.$namespace.'.svg#'.$name.'"></use></svg>';
		}

		return $markup;
	}
}
