<?php

namespace rp\system\event\listener;

use rp\data\classification\ClassificationCache;
use rp\data\race\RaceCache;
use rp\data\role\RoleCache;
use rp\data\server\ServerCache;
use rp\event\character\CharacterAddCreateForm;
use wcf\system\form\builder\container\FormContainer;
use wcf\system\form\builder\container\TabFormContainer;
use wcf\system\form\builder\container\TabTabMenuFormContainer;
use wcf\system\form\builder\data\processor\CustomFormDataProcessor;
use wcf\system\form\builder\data\processor\VoidFormDataProcessor;
use wcf\system\form\builder\field\CheckboxFormField;
use wcf\system\form\builder\field\dependency\NonEmptyFormFieldDependency;
use wcf\system\form\builder\field\IntegerFormField;
use wcf\system\form\builder\field\SingleSelectionFormField;
use wcf\system\form\builder\field\validation\FormFieldValidationError;
use wcf\system\form\builder\field\validation\FormFieldValidator;
use wcf\system\form\builder\IFormDocument;

/**
 * Creates the character equipment form.
 * 
 * @author  Marco Daries
 * @copyright   2023-2024 Daries.dev
 * @license Raidplaner is licensed under Creative Commons Attribution-ShareAlike 4.0 International
 */
final class SWTORCharacterAddCreateFormListener
{
    private static $maxFightStyle = 2;

    public function __invoke(CharacterAddCreateForm $event)
    {
        $section = $event->form->getNodeById('characterGeneralSection');
        $section->appendChildren([
            IntegerFormField::create('level')
                ->label('rp.character.swtor.level')
                ->required()
                ->minimum(1)
                ->maximum(80)
                ->value(0),
            SingleSelectionFormField::create('raceID')
                ->label('rp.race.title')
                ->required()
                ->options(['' => 'wcf.global.noSelection'] + RaceCache::getInstance()->getRaces())
                ->addValidator(new FormFieldValidator('check', function (SingleSelectionFormField $formField) {
                    $value = $formField->getSaveValue();

                    if (empty($value)) {
                        $formField->addValidationError(new FormFieldValidationError('empty'));
                    }
                })),
            SingleSelectionFormField::create('serverID')
                ->label('rp.server.title')
                ->required()
                ->options(['' => 'wcf.global.noSelection'] + ServerCache::getInstance()->getServers())
                ->addValidator(new FormFieldValidator('check', function (SingleSelectionFormField $formField) {
                    $value = $formField->getSaveValue();

                    if (empty($value)) {
                        $formField->addValidationError(new FormFieldValidationError('empty'));
                    }
                })),
        ]);

        /** @var TabTabMenuFormContainer $characterTab */
        $characterTab = $event->form->getNodeById('characterTab');

        for ($i = 0; $i < self::$maxFightStyle; $i++) {
            $fightStyleEnable = CheckboxFormField::create('fightStyleEnable' . $i)
                ->label('rp.character.swtor.fightStyleEnable')
                ->value($i === 0)
                ->addValidator(new FormFieldValidator('checkFirstEnable', function (CheckboxFormField $formField) {
                    $id = $formField->getId();
                    if ($id === 'fightStyleEnable0') {
                        $value = $formField->getSaveValue();
                        if (!$value) {
                            $formField->addValidationError(new FormFieldValidationError('empty'));
                        }
                    }
                }));

            $characterFightStyleTab = TabFormContainer::create('characterFightStyle' . $i)
                ->label('rp.character.swtor.fightStyle' . $i)
                ->appendChildren([
                    FormContainer::create('characterFightStyleSection' . $i)
                        ->appendChildren([
                            $fightStyleEnable,
                            SingleSelectionFormField::create('classificationID' . $i)
                                ->label('rp.classification.title')
                                ->required()
                                ->options(['' => 'wcf.global.noSelection'] + ClassificationCache::getInstance()->getClassifications())
                                ->addValidator(new FormFieldValidator('check', function (SingleSelectionFormField $formField) {
                                    $value = $formField->getSaveValue();

                                    if (empty($value)) {
                                        $formField->addValidationError(new FormFieldValidationError('empty'));
                                    }
                                }))
                                ->addDependency(
                                    NonEmptyFormFieldDependency::create('fightStyleEnable' . $i)
                                        ->field($fightStyleEnable)
                                ),
                            SingleSelectionFormField::create('roleID' . $i)
                                ->label('rp.role.title')
                                ->required()
                                ->options(['' => 'wcf.global.noSelection'] + RoleCache::getInstance()->getRoles())
                                ->addValidator(new FormFieldValidator('check', function (SingleSelectionFormField $formField) {
                                    $value = $formField->getSaveValue();

                                    if (empty($value)) {
                                        $formField->addValidationError(new FormFieldValidationError('empty'));
                                    }
                                }))
                                ->addDependency(
                                    NonEmptyFormFieldDependency::create('fightStyleEnable' . $i)
                                        ->field($fightStyleEnable)
                                ),
                        ]),

                    FormContainer::create('fightStyleEquipment' . $i)
                        ->label('rp.character.category.swtor.equipment')
                        ->appendChildren([
                            IntegerFormField::create('itemLevel' . $i)
                                ->label('rp.character.swtor.itemLevel')
                                ->required()
                                ->minimum(1)
                                ->maximum(344)
                                ->value(0),
                            SingleSelectionFormField::create('implants' . $i)
                                ->label('rp.character.swtor.implants')
                                ->options(function () {
                                    return [
                                        '0' => 'rp.character.swtor.implants.0',
                                        '1' => 'rp.character.swtor.implants.1',
                                        '2' => 'rp.character.swtor.implants.2'
                                    ];
                                }),
                            IntegerFormField::create('upgradeBlue' . $i)
                                ->label('rp.character.swtor.upgradeBlue')
                                ->minimum(0)
                                ->maximum(14)
                                ->value(0),
                            IntegerFormField::create('upgradePurple' . $i)
                                ->label('rp.character.swtor.upgradePurple')
                                ->minimum(0)
                                ->maximum(14)
                                ->value(0),
                            IntegerFormField::create('upgradeGold' . $i)
                                ->label('rp.character.swtor.upgradeGold')
                                ->minimum(0)
                                ->maximum(14)
                                ->value(0),
                        ])
                        ->addDependency(
                            NonEmptyFormFieldDependency::create('fightStyleEnable' . $i)
                                ->field($fightStyleEnable)
                        ),
                ]);
            $characterTab->appendChild($characterFightStyleTab);

            $event->form->getDataHandler()->addProcessor(new VoidFormDataProcessor('fightStyleEnable' . $i));
            $event->form->getDataHandler()->addProcessor(new VoidFormDataProcessor('classificationID' . $i));
            $event->form->getDataHandler()->addProcessor(new VoidFormDataProcessor('roleID' . $i));
            $event->form->getDataHandler()->addProcessor(new VoidFormDataProcessor('itemLevel' . $i));
            $event->form->getDataHandler()->addProcessor(new VoidFormDataProcessor('implants' . $i));
            $event->form->getDataHandler()->addProcessor(new VoidFormDataProcessor('upgradeBlue' . $i));
            $event->form->getDataHandler()->addProcessor(new VoidFormDataProcessor('upgradePurple' . $i));
            $event->form->getDataHandler()->addProcessor(new VoidFormDataProcessor('upgradeGold' . $i));
        }

        $event->form->getDataHandler()->addProcessor(
            new CustomFormDataProcessor(
                'fightStyles',
                static function (IFormDocument $document, array $parameters) {
                    $fightStyles = [];

                    for ($i = 0; $i < self::$maxFightStyle; $i++) {
                        /** @var CheckboxFormField $fightStyleEnable */
                        $fightStyleEnable = $document->getNodeById('fightStyleEnable' . $i);

                        $newFightStyle = [
                            'fightStyleEnable' => $fightStyleEnable->getSaveValue(),
                        ];

                        if ($fightStyleEnable->getSaveValue()) {
                            /** @var SingleSelectionFormField $classificationID */
                            $classificationID = $document->getNodeById('classificationID' . $i);
                            $newFightStyle['classificationID'] = $classificationID->getSaveValue();

                            /** @var SingleSelectionFormField $roleID */
                            $roleID = $document->getNodeById('roleID' . $i);
                            $newFightStyle['roleID'] = $roleID->getSaveValue();

                            /** @var IntegerFormField $itemLevel */
                            $itemLevel = $document->getNodeById('itemLevel' . $i);
                            $newFightStyle['itemLevel'] = $itemLevel->getSaveValue();

                            /** @var SingleSelectionFormField $implants */
                            $implants = $document->getNodeById('implants' . $i);
                            $newFightStyle['implants'] = $implants->getSaveValue();

                            /** @var IntegerFormField $upgradeBlue */
                            $upgradeBlue = $document->getNodeById('upgradeBlue' . $i);
                            $newFightStyle['upgradeBlue'] = $upgradeBlue->getSaveValue();

                            /** @var IntegerFormField $upgradePurple */
                            $upgradePurple = $document->getNodeById('upgradePurple' . $i);
                            $newFightStyle['upgradePurple'] = $upgradePurple->getSaveValue();

                            /** @var IntegerFormField $upgradeGold */
                            $upgradeGold = $document->getNodeById('upgradeGold' . $i);
                            $newFightStyle['upgradeGold'] = $upgradeGold->getSaveValue();
                        }

                        $fightStyles[$i] = $newFightStyle;
                    }

                    $parameters['data']['fightStyles'] = $fightStyles;

                    return $parameters;
                }
            )
        );
    }
}
