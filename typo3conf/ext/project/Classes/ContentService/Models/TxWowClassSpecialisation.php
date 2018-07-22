<?php

declare(strict_types=1);

namespace Project\Classes\ContentService\Models;

use Project\Classes\ContentService\Model;
use Project\Classes\Helper\Config;

/**
 * Base model representing any record of the tx_wow_class_specialisations table.
 *
 * @property int    uid
 * @property int    pid
 * @property int    tstamp
 * @property int    crdate
 * @property int    cruser_id
 * @property int    sorting
 * @property int    deleted
 * @property int    hidden
 * @property int    sys_language_uid
 * @property int    tx_wow_class_uid
 * @property string name
 * @property string background_image
 * @property string icon
 */
class TxWowClassSpecialisation extends Model
{

	/**
	 * @var string
	 */
	protected $table = 'tx_wow_class_specialisations';
	/**
	 * @var TxWowClass
	 */
	protected $classModelCache;

	/**
	 * Returns the absolute url to this specialisation's icon.
	 *
	 * @return string
	 */
	public function getIconUrl()
	{
		return \sprintf('https://render-eu.worldofwarcraft.com/icons/56/%s.jpg', $this->icon);
	}

	/**
	 * Returns the World of Warcraft class model this specialisation belongs to.
	 *
	 * @return \Project\Classes\ContentService\Models\TxWowClass
	 */
	public function getClassModel(): TxWowClass
	{
		if (!$this->classModelCache) {
			$class = new TxWowClass();

			$this->classModelCache = $class->load($this->tx_wow_class_uid);
		}

		return $this->classModelCache;
	}

	/**
	 * Checks if this specialisation is part of the tank role.
	 *
	 * @return bool
	 */
	public function isTank(): bool
	{
		$classNameCombination = \strtolower($this->name . ' ' . $this->getClassModel()->name);

		switch ($classNameCombination) {
			case 'blood death knight':
			case 'vengeance demon hunter':
			case 'guardian druid':
			case 'brewmaster monk':
			case 'protection paladin':
			case 'protection warrior':
				return true;
		}

		return false;
	}

	/**
	 * Checks if this specialisation is part of the melee dps role.
	 *
	 * @return bool
	 */
	public function isMeleeDps(): bool
	{
		$classNameCombination = \strtolower($this->name . ' ' . $this->getClassModel()->name);

		switch ($classNameCombination) {
			case 'frost death knight':
			case 'unholy death knight':
			case 'havoc demon hunter':
			case 'feral druid':
			case 'survival hunter':
			case 'windwalker monk':
			case 'retribution paladin':
			case 'assassination rogue':
			case 'outlaw rogue':
			case 'subtlety rogue':
			case 'enhancement shaman':
			case 'arms warrior':
			case 'fury warrior':
				return true;
		}

		return false;
	}

	/**
	 * Checks if this specialisation is part of the ranged dps role.
	 *
	 * @return bool
	 */
	public function isRangedDps(): bool
	{
		$classNameCombination = \strtolower($this->name . ' ' . $this->getClassModel()->name);

		switch ($classNameCombination) {
			case 'balance druid':
			case 'beast mastery hunter':
			case 'marksmanship hunter':
			case 'arcane mage':
			case 'fire mage':
			case 'frost mage':
			case 'shadow priest':
			case 'elemental shaman':
			case 'affliction warlock':
			case 'demonology warlock':
			case 'destruction warlock':
				return true;
		}

		return false;
	}

	/**
	 * Checks if this specialisation is part of the header role.
	 *
	 * @return bool
	 */
	public function isHealer(): bool
	{
		$classNameCombination = \strtolower($this->name . ' ' . $this->getClassModel()->name);

		switch ($classNameCombination) {
			case 'restoration druid':
			case 'mistweaver monk':
			case 'holy paladin':
			case 'discipline priest':
			case 'holy priest':
			case 'restoration shaman':
				return true;
		}

		return false;
	}

	/**
	 * Returns the role name of this specialisation.
	 *
	 * @return string
	 */
	public function getRoleName(): string
	{
		if ($this->isTank()) {
			return 'tank';
		}

		if ($this->isMeleeDps()) {
			return 'melee';
		}

		if ($this->isRangedDps()) {
			return 'range';
		}

		if ($this->isHealer()) {
			return 'healer';
		}

		return '';
	}

	/**
	 * Fetches a single specialisation model by its unique class and name combination.
	 *
	 * @param TxWowClass $class
	 * @param string     $name
	 *
	 * @return \Project\Classes\ContentService\Models\TxWowClassSpecialisation
	 */
	public static function findByClassAndName(TxWowClass $class, string $name): self
	{
		$model = new self();

		return $model->loadByMultiple(['tx_wow_class_uid' => $class->getKey(), 'name' => $name]);
	}

	/**
	 * Creates a new or updates an existing specialisation model.
	 *
	 * @param TxWowClass $class
	 * @param string     $name
	 * @param string     $bgImage
	 * @param string     $icon
	 */
	private static function create(TxWowClass $class, string $name, string $bgImage, string $icon)
	{
		$model = self::findByClassAndName($class, $name);
		$model->pid = (int)Config::get('tx_wow_class_specialisation_folder_uid');
		$model->cruser_id = 1;
		$model->background_image = \strtolower($bgImage);
		$model->icon = \strtolower($icon);
		$model->store();
	}

	/**
	 * Seeds the World of Warcraft specialisation database table.
	 */
	public static function seed()
	{
		// death knight
		$class = TxWowClass::findByName('Death Knight');
		self::create($class, 'Blood', 'bg-deathknight-blood', 'spell_deathknight_bloodpresence');
		self::create($class, 'Unholy', 'bg-deathknight-unholy', 'spell_deathknight_unholypresence');
		self::create($class, 'Frost', 'bg-deathknight-frost', 'spell_deathknight_frostpresence');

		// demon hunter
		$class = TxWowClass::findByName('Demon Hunter');
		self::create($class, 'Havoc', 'bg-rogue-subtlety', 'ability_demonhunter_specdps');
		self::create($class, 'Vengeance', 'bg-warlock-demonology', 'ability_demonhunter_spectank');

		// druid
		$class = TxWowClass::findByName('Druid');
		self::create($class, 'Guardian', 'bg-druid-bear', 'ability_racial_bearform');
		self::create($class, 'Balance', 'bg-druid-balance', 'spell_nature_starfall');
		self::create($class, 'Restoration', 'bg-druid-restoration', 'spell_nature_healingtouch');
		self::create($class, 'Feral', 'bg-druid-cat', 'ability_druid_catform');

		// hunter
		$class = TxWowClass::findByName('Hunter');
		self::create($class, 'Marksmanship', 'bg-hunter-marksman', 'ability_hunter_focusedaim');
		self::create($class, 'Beast Mastery', 'bg-hunter-beastmaster', 'ability_hunter_bestialdiscipline');
		self::create($class, 'Survival', 'bg-hunter-survival', 'ability_hunter_camouflage');

		// mage
		$class = TxWowClass::findByName('Mage');
		self::create($class, 'Fire', 'bg-mage-fire', 'spell_fire_firebolt02');
		self::create($class, 'Frost', 'bg-mage-frost', 'spell_frost_frostbolt02');
		self::create($class, 'Arcane', 'bg-mage-arcane', 'spell_holy_magicalsentry');

		// monk
		$class = TxWowClass::findByName('Monk');
		self::create($class, 'Windwalker', 'bg-monk-battledancer', 'spell_monk_windwalker_spec');
		self::create($class, 'Mistweaver', 'bg-monk-mistweaver', 'spell_monk_mistweaver_spec');
		self::create($class, 'Brewmaster', 'bg-monk-brewmaster', 'spell_monk_brewmaster_spec');

		// paladin
		$class = TxWowClass::findByName('Paladin');
		self::create($class, 'Protection', 'bg-paladin-protection', 'ability_paladin_shieldofthetemplar');
		self::create($class, 'Retribution', 'bg-paladin-retribution', 'spell_holy_auraoflight');
		self::create($class, 'Holy', 'bg-paladin-holy', 'spell_holy_holybolt');

		// priest
		$class = TxWowClass::findByName('Priest');
		self::create($class, 'Holy', 'bg-priest-holy', 'spell_holy_guardianspirit');
		self::create($class, 'Shadow', 'bg-priest-shadow', 'spell_shadow_shadowwordpain');
		self::create($class, 'Discipline', 'bg-priest-discipline', 'spell_holy_powerwordshield');

		// rogue
		$class = TxWowClass::findByName('Rogue');
		self::create($class, 'Subtlety', 'bg-rogue-subtlety', 'ability_stealth');
		self::create($class, 'Assassination', 'bg-rogue-assassination', 'ability_rogue_deadlybrew');
		self::create($class, 'Outlaw', 'bg-rogue-combat', 'inv_sword_30');

		// shaman
		$class = TxWowClass::findByName('Shaman');
		self::create($class, 'Enhancement', 'bg-shaman-enhancement', 'spell_shaman_improvedstormstrike');
		self::create($class, 'Restoration', 'bg-shaman-restoration', 'spell_nature_magicimmunity');
		self::create($class, 'Elemental', 'bg-shaman-elemental', 'spell_nature_lightning');

		// warlock
		$class = TxWowClass::findByName('Warlock');
		self::create($class, 'Affliction', 'bg-warlock-affliction', 'spell_shadow_deathcoil');
		self::create($class, 'Demonology', 'bg-warlock-demonology', 'spell_shadow_metamorphosis');
		self::create($class, 'Destruction', 'bg-warlock-destruction', 'spell_shadow_rainoffire');

		// warrior
		$class = TxWowClass::findByName('Warrior');
		self::create($class, 'Fury', 'bg-warrior-fury', 'ability_warrior_innerrage');
		self::create($class, 'Protection', 'bg-warrior-protection', 'ability_warrior_defensivestance');
		self::create($class, 'Arms', 'bg-warrior-arms', 'ability_warrior_savageblow');
	}
}
