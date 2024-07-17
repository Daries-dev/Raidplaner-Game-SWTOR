<?php

namespace rp\system\event\listener;

use rp\data\character\CharacterProfile;
use rp\data\classification\ClassificationCache;
use rp\data\event\Event;
use rp\data\role\RoleCache;
use rp\event\character\AvailableCharactersChecking;
use rp\system\character\AvailableCharacter;
use wcf\util\StringUtil;

/**
 * Creates the character equipment form.
 * 
 * @author  Marco Daries
 * @copyright   2023-2024 Daries.dev
 * @license Raidplaner is licensed under Creative Commons Attribution-ShareAlike 4.0 International
 */
final class SWTORAvailableCharactersChecking
{
    public function __invoke(AvailableCharactersChecking $eventChecking)
    {
        /** @var Event $event */
        $event = $eventChecking->getEvent();

        /** @var CharacterProfile $character */
        foreach ($eventChecking->getCharacters() as $characterID => $character) {
            if ($event->requiredLevel !== 0 && $character->level < $event->requiredLevel) {
                continue;
            }

            foreach ($character->fightStyles as $fightStyleID => $fightStyle) {
                if (!$fightStyle['fightStyleEnable']) {
                    continue;
                }

                if (
                    $this->doesNotMeetRequirements($event, $fightStyle) ||
                    !$this->hasSufficientUpgrades($event, $fightStyle)
                ) {
                    continue;
                }

                $id = $characterID . '_' . $fightStyleID;
                $label = $this->getFightStyleLabel($fightStyle);

                $availableCharacter = new AvailableCharacter(
                    $id,
                    $character->getTitle() . ' (' . $label . ')',
                    $fightStyle['classificationID'],
                    $fightStyle['roleID']
                );
                $eventChecking->setAvailableCharacter($id, $availableCharacter);
            }
        }
    }

    /**
     * Returns true if the fighting style does not match the required requirements, otherwise false.
     */
    private function doesNotMeetRequirements(Event $event, array $fightStyle): bool
    {
        foreach (['requiredItemLevel', 'requiredImplants'] as $required) {
            $name = StringUtil::firstCharToLowerCase(\str_replace('required', '', $required));

            if ($event->{$required} != 0 && $fightStyle[$name] < $event->{$required}) {
                return true;
            }
        }

        return false;
    }

    /**
     * Creates and returns a label for the given fighting style based on its classification and role.
     */
    private function getFightStyleLabel(array $fightStyle): string
    {
        $classification = ClassificationCache::getInstance()->getClassificationByID($fightStyle['classificationID']);
        $role = RoleCache::getInstance()->getRoleByID($fightStyle['roleID']);

        $label = $classification ? $classification->getTitle() : '';
        if ($role) {
            $label .= $label ? ', ' : '';
            $label .= $role->getTitle();
        }

        return $label;
    }

    /**
     * Returns true if the fighting style has sufficient upgrades, otherwise false.
     */
    private function hasSufficientUpgrades(Event $event, array $fightStyle): bool
    {
        $highUpgradeCount = 0;

        foreach (['requiredUpgradeGold', 'requiredUpgradePurple', 'requiredUpgradeBlue'] as $required) {
            $name = StringUtil::firstCharToLowerCase(\str_replace('required', '', $required));

            if ($event->{$required} != 0) {
                if ($fightStyle[$name] < $event->{$required}) {
                    return ($highUpgradeCount + $fightStyle[$name]) < 14;
                }
            }

            $highUpgradeCount += $fightStyle[$name];
        }

        return true;
    }
}
