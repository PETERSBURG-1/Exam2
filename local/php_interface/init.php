<?php
AddEventHandler("main", "OnBeforeEventAdd", array("Exam2", "Ex2_51"));

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
}
