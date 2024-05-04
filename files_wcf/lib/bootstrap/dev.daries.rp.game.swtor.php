<?php

use rp\data\game\GameCache;
use rp\system\character\event\CharacterAddCreateForm;
use rp\system\character\event\CharacterEditData;
use rp\system\event\listener\SWTORCharacterAddCreateFormListener;
use rp\system\event\listener\SWTORCharacterEditDataListener;
use wcf\system\event\EventHandler;

return static function (): void {
    if (GameCache::getInstance()->getCurrentGame()->identifier !== 'swtor')  return;

    $eventHandler = EventHandler::getInstance();

    $eventHandler->register(CharacterAddCreateForm::class, SWTORCharacterAddCreateFormListener::class);
    $eventHandler->register(CharacterEditData::class, SWTORCharacterEditDataListener::class);
};