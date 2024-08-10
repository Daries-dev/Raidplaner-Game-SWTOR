<?php

use rp\data\game\GameCache;
use rp\event\character\AvailableCharactersChecking;
use rp\event\character\CharacterAddCreateForm;
use rp\event\character\CharacterEditData;
use rp\event\event\EventCreateForm;
use rp\event\raid\AddAttendeesChecking;
use rp\system\event\listener\SWTORAddAttendeesChecking;
use rp\system\event\listener\SWTORAvailableCharactersChecking;
use rp\system\event\listener\SWTORCharacterAddCreateFormListener;
use rp\system\event\listener\SWTORCharacterEditDataListener;
use rp\system\event\listener\SWTOREventCreateFormListener;
use wcf\system\event\EventHandler;

return static function (): void {
    if (GameCache::getInstance()->getCurrentGame()->identifier !== 'swtor')  return;

    $eventHandler = EventHandler::getInstance();

    $eventHandler->register(AddAttendeesChecking::class, SWTORAddAttendeesChecking::class);
    $eventHandler->register(AvailableCharactersChecking::class, SWTORAvailableCharactersChecking::class);
    $eventHandler->register(CharacterAddCreateForm::class, SWTORCharacterAddCreateFormListener::class);
    $eventHandler->register(CharacterEditData::class, SWTORCharacterEditDataListener::class);
    $eventHandler->register(EventCreateForm::class, SWTOREventCreateFormListener::class);
};
