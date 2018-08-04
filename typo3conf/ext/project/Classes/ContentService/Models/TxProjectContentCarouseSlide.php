<?php

declare(strict_types=1);

namespace Project\Classes\ContentService\Models;

use Project\Classes\Helper\CropImage;
use TYPO3\CMS\Core\Imaging\ImageManipulation\CropVariantCollection;
use TYPO3\CMS\Core\Resource\FileReference;
use TYPO3\CMS\Core\Resource\ProcessedFile;
use TYPO3\CMS\Core\Resource\ProcessedFileRepository;
use Typo3ContentService\Models\AbstractModel;

/**
 * Base model representing any record of the tx_project_content_carousel_slides table.
 *
 * @property int    uid
 * @property int    pid
 * @property int    tstamp
 * @property int    crdate
 * @property int    cruser_id
 * @property int    sorting
 * @property int    deleted
 * @property int    hidden
 * @property int    parent_id
 * @property string parent_table
 * @property string title
 * @property string bodytext
 * @property int    image
 */
class TxProjectContentCarouseSlide extends AbstractModel
{

	/**
	 * @var string
	 */
	protected $table = 'tx_project_content_carousel_slides';
	/**
	 * Column name where the language index of the model is stored in.
	 * This information may be empty if the model has no language index / isn't translatable.
	 * Default set to 'sys_language_uid'.
	 *
	 * @var string
	 */
	protected $languageIndexColumnName = '';
	/**
	 * @var FileReference|null
	 */
	private $imageCache;

	/**
	 * @return string
	 */
	public function getTitle(): string
	{
		return $this->title;
	}

	/**
	 * @return string
	 */
	public function getTeaserText(): string
	{
		return $this->bodytext;
	}

	/**
	 * @return string
	 */
	public function getMobileTeaserText(): string
	{
		return \strlen($this->getTeaserText()) > 50
			? \substr($this->getTeaserText(), 0, 47) . '...'
			: $this->getTeaserText();
	}

	/**
	 * @return \TYPO3\CMS\Core\Resource\FileReference
	 */
	public function getImage(): FileReference
	{
		if (!$this->imageCache) {
			$this->imageCache = $this->resolveFile('image');
		}

		return $this->imageCache;
	}

	/**
	 * @return \TYPO3\CMS\Core\Resource\ProcessedFile
	 */
	public function getLandscapeImage(): ProcessedFile
	{
		return CropImage::getProcessedFile($this->getImage(), 'landscape');
	}

	/**
	 * @return \TYPO3\CMS\Core\Resource\ProcessedFile
	 */
	public function getPortraitImage(): ProcessedFile
	{
		return CropImage::getProcessedFile($this->getImage(), 'portrait');
	}
}
