<?php
IncludeModuleLangFile(__FILE__);
AddEventHandler("main", "OnBeforeEventAdd", array("Exam2", "Ex2_51"));
AddEventHandler("main", "OnBuildGlobalMenu", array("Exam2", "Ex2_95"));
AddEventHandler("iblock", "OnBeforeIBlockElementUpdate", Array("Exam2", "Ex2_50"));
AddEventHandler("main", "OnEpilog", array('Exam2', 'Ex2_93'));


const IBLOCK_CATALOG = 12;
const MAX_COUNT = 2;
class Exam2
{

    static function Ex2_51(&$event, &$lid, &$arFields)
    {
        if ($event == 'FEEDBACK_FORM') {
            global $USER;
            if ($USER->isAuthorized()) {
                $arFields['AUTHOR'] = GetMessage('AUTH_USER', array(
                        '#ID#' => $USER->GetID(),
                        '#LOGIN#' => $USER->GetLogin(),
                        '#NAME#' => $USER->GetFullName(),
                        '#NAME_FORM#' => $arFields['AUTHOR'],
                    )
                );
            } else {
                $arFields['AUTHOR'] = GetMessage('NO_AUTH_USER', array(
                        '#NAME_FORM#' => $arFields['AUTHOR'],
                    )
                );
            }
            CEventLog::Add(array(
                "SEVERITY" => "SECURITY",
                "AUDIT_TYPE_ID" => GetMessage('REPLACEMENT_MESSAGE'),
                "MODULE_ID" => "main",
                "ITEM_ID" => $event,
                "DESCRIPTION" => GetMessage('REPLACEMENT_MESSAGE') . '-' . $arFields['AUTHOR'],
            ));
        }
    }

    public static function Ex2_95(&$aGlobalMenu, &$aModuleMenu)
    {
        $isAdmin = false;
        $isManager = false;

        global $USER;
        $userGroup = CUser::GetUserGroupList($USER->GetID());
        $contentGroupID = CGroup::GetList(
            $by = 'c_sort',
            $order = 'asc',
            array(
                "STRING_ID" => 'content_editor'
            )
        )->Fetch()["ID"];

        while ($group = $userGroup->Fetch()) {

            if ($group['GROUP_ID'] == 1) {
                $isAdmin = true;
            }

            if ($group['GROUP_ID'] == $contentGroupID) {
                $isManager = true;
            }
        }

        if (!$isAdmin && $isManager) {

            foreach ($aModuleMenu as $key => $item) {

                if ($item["items_id"] == "menu_iblock_/news") {
                    $aModuleMenu = [$item];

                    foreach ($item['$items'] as $childItem) {
                        if ($childItem['items_id'] == "menu_iblock_/news/6") {
                            $aModuleMenu[0]["items"] = [$childItem];
                            break;
                        }
                    }
                    break;
                }
            }
            $aGlobalMenu = ['global_menu_content' => $aGlobalMenu['global_menu_content']];
        }
    }

    static function Ex2_50(&$arFields)
    {
            if ($arFields['IBLOCK_ID'] == IBLOCK_CATALOG) {
                if ($arFields['ACTIVE'] == 'N') {
                    $res = CIBlockElement::GetList(
                      array(),
                      array(
                        'IBLOCK_ID' => IBLOCK_CATALOG,
                        'ID' => $arFields['ID'],
                      ),
                        false,
                        false,
                        array(
                            'ID',
                            'IBLOCK_ID',
                            'NAME',
                            'SHOW_COUNTER'
                        ),
                    );
                    $arItems = $res->Fetch();
                    if ($arItems['SHOW_COUNTER'] > MAX_COUNT) {
                        global $APPLICATION;
                        $sText = GetMessage('NOT_DEACTIVE', array('#COUNT#' => $arItems['SHOW_COUNTER']));
                        $APPLICATION->throwException($sText);
                        return false;
                    }
                }
            }
    }

    static function Ex2_93()
    {
        if (defined('ERROR_404') && ERROR_404 == 'Y') {
            global $APPLICATION;
            $APPLICATION->RestartBuffer();
            include $_SERVER['DOCUMENT_ROOT'] . SITE_TEMPLATE_PATH .'/header.php';
            include $_SERVER['DOCUMENT_ROOT'] . '/404.php';
            include $_SERVER['DOCUMENT_ROOT'] . SITE_TEMPLATE_PATH . '/footer.php';

            CEventLog::Add(
                array(
                    'SEVERITY' => 'INFO',
                    'AUDIT_TYPE_ID' => 'ERROR_404',
                    'MODULE_ID' => 'main',
                    'DESCRIPTION' => $APPLICATION->GetCurPage(),
                )
            );
        }
    }

}