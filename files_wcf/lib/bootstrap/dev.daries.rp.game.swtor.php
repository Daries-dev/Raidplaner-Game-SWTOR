<?php

use rp\system\character\event\CharacterAddGeneralTab;
use rp\system\event\listener\SWTORCharacterAddGeneralTabListener;
use wcf\system\event\EventHandler;

return static function (): void {
    $eventHandler = EventHandler::getInstance();

    $eventHandler->register(CharacterAddGeneralTab::class, SWTORCharacterAddGeneralTabListener::class);
};