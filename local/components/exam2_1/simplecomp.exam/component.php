<?
if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();

use Bitrix\Main\Loader,
	Bitrix\Iblock;

if(!Loader::includeModule("iblock"))
{
	ShowError(GetMessage("SIMPLECOMP_EXAM2_IBLOCK_MODULE_NONE"));
	return;
}

$arParams['PROPERTY_IBLOCK'] = trim($arParams['PROPERTY_IBLOCK']);

$arParams['PROPERTY_UF'] = trim($arParams['PROPERTY_UF']);

global $USER;
if($USER->IsAuthorized()) {
    $arResult['COUNT'] = 0;
    $currentUserId = $USER->GetID();
    $currentUserType = CUser::GetList(
        ($by = 'id'),
        ($order = 'asc'),
        array('ID' => $currentUserId),
        array('SELECT' => array($arParams['PROPERTY_UF']))
    )->Fetch()[$arParams['PROPERTY_UF']];


if ($this->startResultCache(false, array($currentUserType, $currentUserId))) {
    $rsUsers = CUser::GetList(
        ($by = 'id'),
        ($order = 'desc'),
        array(
          $arParams['PROPERTY_UF'] => $currentUserType,
        ),
        array(
            'SELECT' => array('LOGIN', 'ID')
        ),
    );
    while($arUser = $rsUsers->GetNext()) {
        $userList[$arUser['ID']] = array('LOGIN' => $arUser['LOGIN']);
        $userListId[] = $arUser['ID'];
    }

    $arNewsAuthor = [];
    $arNewsList = [];
    $rsElements = CIBlockElement::GetList(
      array(),
      array(
          'IBLOCK_ID' => $arParams['NEWS_IBLOCK_ID'],
          'PROPERTY_' . $arParams['PROPERTY_IBLOCK'] => $userListId,
      ),
        false,
        false,
        array(
            'NAME',
            'ACTIVE_FROM',
            'ID',
            'IBLOCK_ID',
            'PROPERTY_' . $arParams['PROPERTY_IBLOCK']
        )
    );
    $arNewsId = [];
    while($arElement = $rsElements->Fetch()) {
        $arNewsAuthor[$arElement['ID']][] = $arElement['PROPERTY_' . $arParams['PROPERTY_IBLOCK'] . '_VALUE'];

        if (empty($arNewsList[$arElement['ID']])) {
            $arNewsList[$arElement['ID']] = $arElement;
        }

        if ($arElement['PROPERTY_' . $arParams['PROPERTY_IBLOCK'] . '_VALUE'] != $currentUserId) {
            $arNewsList[$arElement['ID']]['AUTHORS'][] = $arElement['PROPERTY_' . $arParams['PROPERTY_IBLOCK'] . '_VALUE'];
        }
    }

    foreach ($arNewsList as $key => $value) {

        if(in_array($currentUserId, $arNewsAuthor[$value['ID']]))
            continue;

            foreach ($value['AUTHORS'] as $authorId) {
                $userList[$authorId]['NEWS'][] = $value;
                $arNewsId[$value['ID']] = $value['ID'];
            }
    }

    unset($userList[$currentUserId]);

    $arResult['AUTHORS'] = $userList;
    $arResult['COUNT'] = count($arNewsId);
    $this->SetResultCacheKeys(array('COUNT'));
    $this->includeComponentTemplate();
} else {
    $this->abortResultCache();
}

$APPLICATION->SetTitle(GetMessage('COUNT_NEWS') . $arResult['COUNT']);
}