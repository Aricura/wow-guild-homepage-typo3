<?php

declare(strict_types=1);

namespace Project\Classes\Helper;

use TYPO3\CMS\Core\Imaging\ImageManipulation\CropVariantCollection;
use TYPO3\CMS\Core\Resource\FileReference;
use TYPO3\CMS\Core\Resource\ProcessedFile;

/**
 * Helper class to apply the image cropping settings.
 */
class CropImage
{

	/**
	 * Applies the specified cropping area by id/name and returns the processed file reference.
	 *
	 * @param FileReference $image
	 * @param string        $cropAreaId
	 *
	 * @return ProcessedFile
	 */
	public static function getProcessedFile(FileReference $image, string $cropAreaId): ProcessedFile
	{
		$cropSettings = (string)$image->getProperty('crop');

		$cropArea = CropVariantCollection::create($cropSettings)->getCropArea($cropAreaId);

		$absoluteCropArea = $cropArea->makeAbsoluteBasedOnFile($image);

		return $image->getOriginalFile()->process(ProcessedFile::CONTEXT_IMAGECROPSCALEMASK, ['crop' => $absoluteCropArea]);
	}
}
