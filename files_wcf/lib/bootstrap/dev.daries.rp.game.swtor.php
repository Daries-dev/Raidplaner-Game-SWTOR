<?php

use rp\system\character\event\CharacterAddCreateForm;
use rp\system\event\listener\SWTORCharacterAddCreateFormListener;
use wcf\system\event\EventHandler;

return static function (): void {
    $eventHandler = EventHandler::getInstance();

    $eventHandler->register(CharacterAddCreateForm::class, SWTORCharacterAddCreateFormListener::class);
};