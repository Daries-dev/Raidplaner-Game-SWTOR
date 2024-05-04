<?php

namespace rp\system\event\listener;

use rp\system\character\event\CharacterEditData;
use wcf\system\form\builder\field\IFormField;

/**
 * Set data for editing characters.
 * 
 * @author  Marco Daries
 * @copyright   2023-2024 Daries.dev
 * @license Raidplaner is licensed under Creative Commons Attribution-ShareAlike 4.0 International
 */

 final class SWTORCharacterEditDataListener
{
    public function __invoke(CharacterEditData $event)
    {
        if (empty($_POST) && $event->formObject !== null) {
            $fightStyles = $event->formObject->fightStyles;

            foreach ($fightStyles as $key => $fightStyle) {
                foreach ($fightStyle as $fightStyleKey => $fightStyleValue) {
                    /** @var IFormField $field */
                    $field = $event->form->getNodeById($fightStyleKey . $key);
                    $field?->value($fightStyleValue);
                }
            }
        }
    }
}