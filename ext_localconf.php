<?php
defined('TYPO3') || die();

(static function() {

    \TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
        'GdprExtensionsComMt',
        'gdprmt',
        [
            \GdprExtensionsCom\GdprExtensionsComMt\Controller\GdprExtensionsComMtController::class => 'index , showReviews,ajax'
        ],
        // non-cacheable actions
        [
            \GdprExtensionsCom\GdprExtensionsComMt\Controller\GdprExtensionsComMtController::class => 'showReviews, ajax',
            \GdprExtensionsCom\GdprExtensionsComMt\Controller\GdprManagerController::class => 'create, update, delete'
        ],
        \TYPO3\CMS\Extbase\Utility\ExtensionUtility::PLUGIN_TYPE_CONTENT_ELEMENT


    );

    // register plugin for cookie widget
    \TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
        'GdprExtensionsComMt',
        'gdprcookiewidget',
        [
            \GdprExtensionsCom\GdprExtensionsComMt\Controller\GdprCookieWidgetController::class => 'index, ajax'
        ],
        // non-cacheable actions
        [
            \GdprExtensionsCom\GdprExtensionsComMt\Controller\GdprCookieWidgetController::class => 'index, ajax'
        ],
    );



    // wizards
    \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addPageTSConfig(
        'mod {
            wizards.newContentElement.wizardItems.plugins {
                elements {
                    gdprcookiewidget {
                        iconIdentifier = gdpr_two_x_matomo_plugin_gdprgoogle_reviewlist
                        title = cookie
                        description = LLL:EXT:gdpr_extensions_com_mt/Resources/Private/Language/locallang_db.xlf:tx_gdpr_two_x_matomo_gdprgoogle_reviewlist.description
                        tt_content_defValues {
                            CType = list
                            list_type = gdprextensionscommt_gdprcookiewidget
                        }
                    }
                }
                show = *
            }
       }'
    );

    // wizards
    \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addPageTSConfig(
        'mod.wizards.newContentElement.wizardItems {
               gdpr.header = LLL:EXT:gdpr_extensions_com_mt/Resources/Private/Language/locallang_db.xlf:tx_gdpr_two_x_gtm_gdprgoogle_reviewlist.name.tab
        }'
    );

    \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addPageTSConfig(
        'mod {
            wizards.newContentElement.wizardItems.common {
                elements {
                    gdprtmt {
                        iconIdentifier = gdpr_two_x_matomo_plugin_gdprgoogle_reviewlist
                        title = LLL:EXT:gdpr_extensions_com_mt/Resources/Private/Language/locallang_db.xlf:tx_gdpr_two_x_gtm_gdprgoogle_reviewlist.name
                        description = LLL:EXT:gdpr_extensions_com_mt/Resources/Private/Language/locallang_db.xlf:tx_gdpr_two_x_gtm_gdprgoogle_reviewlist.description
                        tt_content_defValues {
                            CType = list
                            list_type = gdprextensionscommt_gdprmt

                        }
                    }
                }
                show = *
            }
       }'
    );

    $registeredTasks = $GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['scheduler']['tasks'];
    $alreadyRegistered = 0;
    foreach($registeredTasks as $registeredTask){

        if(isset($registeredTask['extension']) && strpos($registeredTask['extension'], 'Googlereview') !== false){
            $alreadyRegistered +=1;
        }

    }


    if(!$alreadyRegistered){
        $GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['scheduler']['tasks'][\GdprExtensionsCom\GdprExtensionsComMt\Commands\SyncReviewsTask::class] = [
            'extension' => 'GdprExtensionsComMt',
            'title' => 'Sync gdpr reviews',
            'description' => 'Sync gdpr reviews',
            'additionalFields' => \GdprExtensionsCom\GdprExtensionsComMt\Commands\SyncReviewsTask::class,
        ];
    }


})();
$GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['t3lib/class.t3lib_tcemain.php']['processDatamapClass'][] = \GdprExtensionsCom\GdprExtensionsComMt\Hooks\DataHandlerHook::class;
if (!isset($GLOBALS['TYPO3_CONF_VARS']['SYS']['caching']['cacheConfigurations']['GdprExtensionsComMt'])) {
    $GLOBALS['TYPO3_CONF_VARS']['SYS']['caching']['cacheConfigurations']['GdprExtensionsComMt'] = [
        'frontend' => \TYPO3\CMS\Core\Cache\Frontend\VariableFrontend::class,
        'backend' => \TYPO3\CMS\Core\Cache\Backend\FileBackend::class,
        'groups' => ['all', 'GdprExtensionsComMt'],
        'options' => [
            'defaultLifetime' => 3600, // Cache lifetime in seconds
        ],
    ];
}
