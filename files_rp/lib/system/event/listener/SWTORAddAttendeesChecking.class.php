<?php

namespace rp\system\event\listener;

use rp\event\raid\AddAttendeesChecking;
use rp\system\cache\runtime\CharacterRuntimeCache;

/**
 * Handles the `AddAttendeesChecking` event to process attendees data.
 * 
 * @author  Marco Daries
 * @copyright   2023-2024 Daries.dev
 * @license Raidplaner is licensed under Creative Commons Attribution-ShareAlike 4.0 International
 */
final class SWTORAddAttendeesChecking
{
    public function __invoke(AddAttendeesChecking $event)
    {
        $attendeeIDs = $event->getAttendeeIDs();

        foreach ($attendeeIDs as $attendeeID) {
            [$characterID, $fightStyleID] = \explode('_', $attendeeID, 2);

            $character = CharacterRuntimeCache::getInstance()->getObject($characterID);
            if ($character === null) {
                continue;
            }

            $fightStyles = $character->fightStyles ?? [];
            if (!\array_key_exists($fightStyleID, $fightStyles)) {
                continue;
            }

            $fightStyle = $fightStyles[$fightStyle];

            $event->setAttendee([
                'characterID' => $character->characterID,
                'characterName' => $character->characterName,
                'classificationID' => $fightStyle['classificationID'],
                'roleID' => $fightStyle['roleID'],
            ]);
        }
    }
}
