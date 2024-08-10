<?php

/**
 * @author  Marco Daries
 * @copyright   2023-2024 Daries.dev
 * @license Raidplaner is licensed under Creative Commons Attribution-ShareAlike 4.0 International
 */

use rp\data\game\GameCache;
use rp\data\point\account\PointAccount;
use rp\data\point\account\PointAccountEditor;
use rp\data\raid\event\RaidEventEditor;
use wcf\data\language\item\LanguageItemAction;
use wcf\data\package\PackageCache;
use wcf\system\language\LanguageFactory;
use wcf\util\StringUtil;

$packageID = $this->installation->getPackageID();

/** @var PointAccount $pointAccount */
// raid events with point account 
$pointAccount = PointAccountEditor::create([
    'gameID' => GameCache::getInstance()->getGameByIdentifier('swtor')->gameID,
    'title' => 'SWTOR 1.0',
]);
insertEvent(getClassic(), $pointAccount, $packageID);

$pointAccount = PointAccountEditor::create([
    'gameID' => GameCache::getInstance()->getGameByIdentifier('swtor')->gameID,
    'title' => 'SWTOR 2.0',
]);
insertEvent(getEvents(), $pointAccount, $packageID);

$pointAccount = PointAccountEditor::create([
    'gameID' => GameCache::getInstance()->getGameByIdentifier('swtor')->gameID,
    'title' => 'SWTOR 3.0',
]);
insertEvent(getRevan(), $pointAccount, $packageID);

$pointAccount = PointAccountEditor::create([
    'gameID' => GameCache::getInstance()->getGameByIdentifier('swtor')->gameID,
    'title' => 'SWTOR 4.0',
]);
insertEvent(getFallen(), $pointAccount, $packageID);

$pointAccount = PointAccountEditor::create([
    'gameID' => GameCache::getInstance()->getGameByIdentifier('swtor')->gameID,
    'title' => 'SWTOR 5.6',
]);
insertEvent(getUprising(), $pointAccount, $packageID);

$pointAccount = PointAccountEditor::create([
    'gameID' => GameCache::getInstance()->getGameByIdentifier('swtor')->gameID,
    'title' => 'SWTOR 6.0',
]);
insertEvent(getOnslaught(), $pointAccount, $packageID);

$pointAccount = PointAccountEditor::create([
    'gameID' => GameCache::getInstance()->getGameByIdentifier('swtor')->gameID,
    'title' => 'SWTOR 7.0',
]);
insertEvent(getLotS(), $pointAccount, $packageID);

function insertEvent(array $entries, PointAccount $pointAccount, $packageID)
{
    foreach ($entries as $entry) {
        $event = RaidEventEditor::create([
            'gameID' => GameCache::getInstance()->getGameByIdentifier('swtor')->gameID,
            'pointAccountID' => $pointAccount->accountID,
            'icon' => $entry['icon'],
        ]);
        $eventEditor = new RaidEventEditor($event);
        $eventEditor->update(['title' => 'rp.raid.event.title' . $event->eventID]);

        insertLanguageItem($event->eventID, $entry['title'], $packageID);
    }
}

function insertLanguageItem(int $eventID, array $title, int $packageID)
{
    foreach (LanguageFactory::getInstance()->getLanguages() as $language) {
        if (!isset($title[$language->languageCode])) continue;

        (new LanguageItemAction([], 'create', [
            'data' => [
                'languageID' => $language->languageID,
                'languageItem' => 'rp.raid.event.title' . $eventID,
                'languageItemValue' => StringUtil::trim($title[$language->languageCode]),
                'languageCategoryID' => (LanguageFactory::getInstance()->getCategory('rp.raid.event'))->languageCategoryID,
                'packageID' => $packageID,
                'languageItemOriginIsSystem' => 1,
            ]
        ]))->executeAction();
    }
}

//Operation Swtor 1.0
function getClassic()
{
    return [
        [
            'title' => [
                'de' => 'Ewige Kammer (Story)',
                'en' => 'The Eternity Vault (Story)',
            ],
            'icon' => 'swtorStory',
        ],
        [
            'title' => [
                'de' => 'Ewige Kammer (Veteran)',
                'en' => 'The Eternity Vault (Veteran)',
            ],
            'icon' => 'swtorVeteran',
        ],
        [
            'title' => [
                'de' => 'Ewige Kammer (Meister)',
                'en' => 'The Eternity Vault (Master)',
            ],
            'icon' => 'swtorMaster',
        ],
        [
            'title' => [
                'de' => 'Karaggas Palast (Story)',
                'en' => 'Karaggas Palace (Story)',
            ],
            'icon' => 'swtorStory',
        ],
        [
            'title' => [
                'de' => 'Karaggas Palast (Veteran)',
                'en' => 'Karaggas Palace (Veteran)',
            ],
            'icon' => 'swtorVeteran',
        ],
        [
            'title' => [
                'de' => 'Karaggas Palast (Meister)',
                'en' => 'Karaggas Palace (Master)',
            ],
            'icon' => 'swtorMaster',
        ],
        [
            'title' => [
                'de' => 'Explosiv Konflikt (Story)',
                'en' => 'Explosiv Conflict (Story)',
            ],
            'icon' => 'swtorStory',
        ],
        [
            'title' => [
                'de' => 'Explosiv Konflikt (Veteran)',
                'en' => 'Explosiv Conflict (Veteran)',
            ],
            'icon' => 'swtorVeteran',
        ],
        [
            'title' => [
                'de' => 'Explosiv Konflikt (Meister)',
                'en' => 'Explosiv Conflict (Master)',
            ],
            'icon' => 'swtorMaster',
        ],
    ];
}

//Operation Swtor 2.0
function getEvents()
{
    return [
        [
            'title' => [
                'de' => 'Abschaum und Verkommenheit (Story)',
                'en' => 'Scum and Villainy (Story)',
            ],
            'icon' => 'swtorStory',
        ],
        [
            'title' => [
                'de' => 'Abschaum und Verkommenheit (Veteran)',
                'en' => 'Scum and Villainy (Veteran)',
            ],
            'icon' => 'swtorVeteran',
        ],
        [
            'title' => [
                'de' => 'Abschaum und Verkommenheit (Meister)',
                'en' => 'Scum and Villainy (Master)',
            ],
            'icon' => 'swtorMaster',
        ],
        [
            'title' => [
                'de' => 'Schrecken aus der Tiefe (Story)',
                'en' => 'Terror from Beyond (Story)',
            ],
            'icon' => 'swtorStory',
        ],
        [
            'title' => [
                'de' => 'Schrecken aus der Tiefe (Veteran)',
                'en' => 'Terror from Beyond (Veteran)',
            ],
            'icon' => 'swtorVeteran',
        ],
        [
            'title' => [
                'de' => 'Schrecken aus der Tiefe (Meister)',
                'en' => 'Terror from Beyond (Master)',
            ],
            'icon' => 'swtorMaster',
        ],
        [
            'title' => [
                'de' => 'Schreckensfestung (Story)',
                'en' => 'Dread Fortress (Story)',
            ],
            'icon' => 'swtorStory',
        ],
        [
            'title' => [
                'de' => 'Schreckensfestung (Veteran)',
                'en' => 'Dread Fortress (Veteran)',
            ],
            'icon' => 'swtorVeteran',
        ],
        [
            'title' => [
                'de' => 'Schreckensfestung (Meister)',
                'en' => 'Dread Fortress (Master)',
            ],
            'icon' => 'swtorMaster',
        ],
        [
            'title' => [
                'de' => 'Schreckenspalast (Story)',
                'en' => 'Dread Palace (Story)',
            ],
            'icon' => 'swtorStory',
        ],
        [
            'title' => [
                'de' => 'Schreckenspalast (Veteran)',
                'en' => 'Dread Palace (Veteran)',
            ],
            'icon' => 'swtorVeteran',
        ],
        [
            'title' => [
                'de' => 'Schreckenspalast (Meister)',
                'en' => 'Dread Palace (Master)',
            ],
            'icon' => 'swtorMaster',
        ],
        [
            'title' => [
                'de' => "Toborro's Hof (Story)",
                'en' => 'Golden Fury (Story)',
            ],
            'icon' => 'swtorStory',
        ],
        [
            'title' => [
                'de' => "Toborro's Hof (Veteran)",
                'en' => 'Golden Fury (Veteran)',
            ],
            'icon' => 'swtorVeteran',
        ],
    ];
}

//Operation Swtor 3.0
function getRevan()
{
    return [
        [
            'title' => [
                'de' => 'Die Wüter (Story)',
                'en' => 'The Ravagers (Story)',
            ],
            'icon' => 'swtorStory',
        ],
        [
            'title' => [
                'de' => 'Die Wüter (Veteran)',
                'en' => 'The Ravagers (Veteran)',
            ],
            'icon' => 'swtorVeteran',
        ],
        [
            'title' => [
                'de' => 'Die Wüter (Meister)',
                'en' => 'The Ravagers (Master)',
            ],
            'icon' => 'swtorMaster',
        ],
        [
            'title' => [
                'de' => 'Tempel des Opfers (Story)',
                'en' => 'Tempel of Sacrifice (Story)',
            ],
            'icon' => 'swtorStory',
        ],
        [
            'title' => [
                'de' => 'Tempel des Opfers (Veteran)',
                'en' => 'Tempel of Sacrifice (Veteran)',
            ],
            'icon' => 'swtorVeteran',
        ],
        [
            'title' => [
                'de' => 'Tempel des Opfers (Meister)',
                'en' => 'Tempel of Sacrifice (Master)',
            ],
            'icon' => 'swtorMaster',
        ],
    ];
}

//Operation Swtor 4.0 Fallen
function getFallen()
{
    return [
        [
            'title' => [
                'de' => 'Gewaltiger Monolith (Story)',
                'en' => 'Colossal Monolith (Story)',
            ],
            'icon' => 'swtorStory',
        ],
        [
            'title' => [
                'de' => 'Gewaltiger Monolith (Veteran)',
                'en' => 'Colossal Monolith (Veteran)',
            ],
            'icon' => 'swtorVeteran',
        ],
        [
            'title' => [
                'de' => 'Gewaltiger Monolith (Meister)',
                'en' => 'Colossal Monolith (Master)',
            ],
            'icon' => 'swtorMaster',
        ],
        [
            'title' => [
                'de' => 'Götter aus der Maschiene (Story)',
                'en' => 'Gods from the Machine Tyth (Story)',
            ],
            'icon' => 'swtorStory',
        ],
        [
            'title' => [
                'de' => 'Götter aus der Maschiene (Veteran)',
                'en' => 'Gods from the Machine Tyth (Veteran)',
            ],
            'icon' => 'swtorVeteran',
        ],
    ];
}

//Operation Swtor 5.6 Uprising
function getUprising()
{
    return [
        [
            'title' => [
                'de' => 'Mutierte Genosianische Königin (Story)',
                'en' => 'Mutated Geonosian Queen (Story)',
            ],
            'icon' => 'swtorStory',
        ],
        [
            'title' => [
                'de' => 'Mutierte Genosianische Königin (Veteran)',
                'en' => 'Mutated Geonosian Queen (Veteran)',
            ],
            'icon' => 'swtorVeteran',
        ],
    ];
}

//Operation Swtor 6.0 Onslaught
function getOnslaught()
{
    return [
        [
            'title' => [
                'de' => 'Dxun (Story)',
                'en' => 'Dxun (Story)',
            ],
            'icon' => 'swtorStory',
        ],
        [
            'title' => [
                'de' => 'Dxun (Veteran)',
                'en' => 'Dxun (Veteran)',
            ],
            'icon' => 'swtorVeteran',
        ],
    ];
}

//Operation Swtor 7.0 Legacy of the Sith
function getLotS()
{
    return [
        [
            'title' => [
                'de' => 'R-4 Anomalie (Story)',
                'en' => 'R-4 Anomaly (Story)',
            ],
            'icon' => 'swtorStory',
        ],
        [
            'title' => [
                'de' => 'R-4 Anomalie (Veteran)',
                'en' => 'R-4 Anomaly (Veteran)',
            ],
            'icon' => 'swtorVeteran',
        ],
        [
            'title' => [
                'de' => 'R-4 Anomalie (Meister)',
                'en' => 'R-4 Anomaly (Master)',
            ],
            'icon' => 'swtorMaster',
        ],
    ];
}
