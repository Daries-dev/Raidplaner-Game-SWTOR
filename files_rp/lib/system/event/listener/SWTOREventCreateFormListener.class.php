<?php

namespace rp\system\event\listener;

use rp\data\game\GameCache;
use rp\event\event\EventCreateForm;
use wcf\system\form\builder\container\FormContainer;
use wcf\system\form\builder\field\IntegerFormField;
use wcf\system\form\builder\field\SingleSelectionFormField;

/**
 * Set condition for event form.
 * 
 * @author  Marco Daries
 * @copyright   2023-2024 Daries.dev
 * @license Raidplaner is licensed under Creative Commons Attribution-ShareAlike 4.0 International
 */
final class SWTOREventCreateFormListener
{
    public function __invoke(EventCreateForm $eventForm)
    {
        if (GameCache::getInstance()->getCurrentGame()->identifier !== 'swtor') return;
        if ($eventForm->eventController !== 'dev.daries.rp.event.controller.raid') return;

        /** @var FormContainer $conditionContainer */
        $conditionContainer = $eventForm->form->getNodeById('condition');
        $conditionContainer->appendChildren([
            IntegerFormField::create('requiredLevel')
                ->label('rp.character.swtor.level')
                ->minimum(0)
                ->maximum(80)
                ->value(0),
            IntegerFormField::create('requiredItemLevel')
                ->label('rp.character.swtor.itemLevel')
                ->minimum(0)
                ->maximum(344)
                ->value(0),
            SingleSelectionFormField::create('requiredImplants')
                ->label('rp.character.swtor.implants')
                ->options(static function () {
                    return [
                        '0' => 'rp.character.swtor.implants.0',
                        '1' => 'rp.character.swtor.implants.1',
                        '2' => 'rp.character.swtor.implants.2',
                    ];
                }),
            IntegerFormField::create('requiredUpgradeBlue')
                ->label('rp.character.swtor.upgradeBlue')
                ->minimum(0)
                ->maximum(14)
                ->value(0),
            IntegerFormField::create('requiredUpgradePurple')
                ->label('rp.character.swtor.upgradePurple')
                ->minimum(0)
                ->maximum(14)
                ->value(0),
            IntegerFormField::create('requiredUpgradeGold')
                ->label('rp.character.swtor.upgradeGold')
                ->minimum(0)
                ->maximum(14)
                ->value(0),
        ]);
    }
}
