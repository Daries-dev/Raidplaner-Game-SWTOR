<?php

namespace rp\system\event\listener;

use rp\data\game\GameCache;
use rp\system\character\event\CharacterAddGeneralTab;
use wcf\system\form\builder\field\IntegerFormField;

/**
 * Creates the character equipment form.
 * 
 * @author  Marco Daries
 * @copyright   2023-2024 Daries.dev
 * @license Free License <https://daries.dev/en/license-for-free-plugins>
 */
final class SWTORCharacterAddGeneralTabListener
{
    public function __invoke(CharacterAddGeneralTab $event)
    {
        if (GameCache::getInstance()->getCurrentGame()->identifier !== 'dev.daries.rp.game.swtor')  return;

        $section = $event->characterGeneralTab->getNodeById('characterGeneralSection');
        $section->appendChildren([
            IntegerFormField::create('level')
                ->label('rp.character.swtor.level')
                ->required()
                ->minimum(1)
                ->maximum(90)
                ->value(0),
        ]);
    }
}
