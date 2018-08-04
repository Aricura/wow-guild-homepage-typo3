<?php

declare(strict_types=1);

namespace Project\Classes\ContentService\Models;

use Typo3ContentService\Models\AbstractModel;

/**
 * Base model representing any record of the tx_project_content_wheel_slides table.
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
 */
class TxProjectContentWheelSlide extends AbstractModel
{

	/**
	 * @var string
	 */
	protected $table = 'tx_project_content_wheel_slides';
	/**
	 * Column name where the language index of the model is stored in.
	 * This information may be empty if the model has no language index / isn't translatable.
	 * Default set to 'sys_language_uid'.
	 *
	 * @var string
	 */
	protected $languageIndexColumnName = '';

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
	public function getBodyText(): string
	{
		return $this->bodytext;
	}
}
