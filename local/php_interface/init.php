<?php
AddEventHandler("main", "OnBeforeEventAdd", array("Exam2", "Ex2_51"));
AddEventHandler("main", "OnBuildGlobalMenu", array("Exam2", "Ex2_95"));

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
}