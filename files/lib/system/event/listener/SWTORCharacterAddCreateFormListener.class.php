<?php

namespace rp\system\event\listener;

use rp\data\game\GameCache;
use wcf\system\form\builder\field\IntegerFormField;
use wcf\system\form\builder\IFormDocument;

/**
 * Creates the character equipment form.
 * 
 * @author  Marco Daries
 * @copyright   2023-2024 Daries.dev
 * @license Free License <https://daries.dev/en/license-for-free-plugins>
 */
final class SWTORCharacterAddCreateFormListener
{
    public function __invoke(IFormDocument $event)
    {
        if (GameCache::getInstance()->getCurrentGame()->identifier !== 'swtor')  return;

        $section = $event->getNodeById('characterGeneralSection');
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
