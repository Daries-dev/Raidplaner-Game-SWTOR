<?php

namespace rp\system\event\listener;

use rp\data\character\CharacterList;
use rp\data\classification\ClassificationCache;
use rp\data\role\RoleCache;
use rp\event\raid\character\CharacterCollecting;

/**
 * Set data for editing characters.
 * 
 * @author  Marco Daries
 * @copyright   2023-2024 Daries.dev
 * @license Raidplaner is licensed under Creative Commons Attribution-ShareAlike 4.0 International
 */
final class SWTORCharacterCollecting
{
    public function __invoke(CharacterCollecting $collecting)
    {
        $characterList = new CharacterList();
        $characterList->getConditionBuilder()->add('member.gameID = ?', [RP_CURRENT_GAME_ID]);
        $characterList->getConditionBuilder()->add('member.isDisabled = ?', [0]);
        $characterList->readObjects();

        foreach ($characterList as $character) {
            $fightStyles = $character->fightStyles;
            foreach ($fightStyles as $fightStyleID => $fightStyle) {
                if (!$fightStyle['fightStyleEnable']) continue;

                $id = $character->getObjectID() . '_' . $fightStyleID;

                $label = '';
                $classification = ClassificationCache::getInstance()->getClassificationByID($fightStyle['classificationID']);
                if ($classification) {
                    $label = $classification->getTitle();
                }

                $role = RoleCache::getInstance()->getRoleByID($fightStyle['roleID']);
                if ($role) {
                    if (!empty($label)) $label .= ', ';
                    $label .= $role->getTitle();
                }

                $collecting->register([
                    'id' => $id,
                    'label' => $character->getTitle() . ' (' . $label . ')',
                    'userID' => $character->userID,
                ]);
            }
        }
    }
}
