<?php

if ((int)\TYPO3\CMS\Core\Utility\VersionNumberUtility::getCurrentTypo3Version() >= 12) {
    $allRegisteredModules = $GLOBALS['TBE_MODULES']['web'];
    if (stripos($allRegisteredModules, 'gdprmanager') == false){

        return[
            'gdpr' => [
                'labels' => 'LLL:EXT:gdpr_extensions_com_mt/Resources/Private/Language/locallang_mod_web.xlf',
                'iconIdentifier' => 'gdpr_extensions_com_tab',
                'navigationComponent' => '@typo3/backend/page-tree/page-tree-element',
            ],
            'mt' => [
                'parent' => 'gdpr',
                'position' => [],
                'access' => 'user,group',
                'iconIdentifier' => 'gdpr_two_x_matomo_plugin_gdprgoogle_reviewlist',
                'path' => '/module/mt',
                'labels' => 'LLL:EXT:gdpr_extensions_com_mt/Resources/Private/Language/locallang_gdprmanager.xlf',
                'extensionName' => 'GdprExtensionsComMt',
                'controllerActions' => [
                    \GdprExtensionsCom\GdprExtensionsComMt\Controller\GdprManagerController::class => [
                        'list',
                        'index',
                        'show',
                        'new',
                        'create',
                        'edit',
                        'editAdd',
                        'save',
                        'update',
                        'delete',
                        'uploadImage'
                    ],
                ],
            ]
        ];

    }}


