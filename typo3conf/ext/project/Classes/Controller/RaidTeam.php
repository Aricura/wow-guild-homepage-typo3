<?php

declare(strict_types=1);

namespace Project\Classes\Controller;

use Project\Classes\Base;
use Project\Classes\ContentService\Models\TxWowClassSpecialisation;
use Project\Classes\ContentService\Models\TxWowGuildMember;

/**
 * Renders the raid team slider plugin.
 */
class RaidTeam extends Base
{

	/**
	 * @return string
	 */
	public function render(): string
	{
		$where = [
			'is_raid_member' => 1,
		];

		// fetch all raid members
		$raidMembers = TxWowGuildMember::findAllBy($where);
		$tanks = [];
		$meleeDps = [];
		$rangeDps = [];
		$heals = [];

		// split all raid members according to their role
		foreach($raidMembers as $raidMember) {
			$specialisation = TxWowClassSpecialisation::find($raidMember->tx_wow_class_specialisation_uid);

			switch($specialisation->getRoleName()) {
				case TxWowClassSpecialisation::ROLE_TANK:
					$tanks[] = $raidMember;
					break;
				case TxWowClassSpecialisation::ROLE_MELEE:
					$meleeDps[] = $raidMember;
					break;
				case TxWowClassSpecialisation::ROLE_RANGE:
					$rangeDps[] = $raidMember;
					break;
				case TxWowClassSpecialisation::ROLE_HEAL:
					$heals[] = $raidMember;
					break;
			}
		}

		$this->element->setAttribute('tanks', $tanks);
		$this->element->setAttribute('melees', $meleeDps);
		$this->element->setAttribute('ranges', $rangeDps);
		$this->element->setAttribute('heals', $heals);

		return $this->twig('raid-team/template.html.twig');
	}
}
