<?
if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();

use Bitrix\Main\Loader,
	Bitrix\Iblock;

if(!Loader::includeModule("iblock"))
{
	ShowError(GetMessage("SIMPLECOMP_EXAM2_IBLOCK_MODULE_NONE"));
	return;
}

if (empty($arParams['CACHE_TIME']))
    $arParams['CACHE_TIME'] = 36000000;

if (empty($arParams['PRODUCTS_IBLOCK_ID']))
    $arParams['PRODUCTS_IBLOCK_ID'] = 0;

if (empty($arParams['CLASSIF_IBLOCK_ID']))
    $arParams['CLASSIF_IBLOCK_ID'] = 0;

$arParams['PROPERTY_CODE'] = trim($arParams['PROPERTY_CODE']);
global $USER;
if ($this->startResultCache(false, array($USER->GetGroups()))) {

    $arClassif = [];
    $arClassifID = [];
    $arResult['COUNT'] = 0;

    $arSelectElems = array (
        'ID',
        'IBLOCK_ID',
        'NAME'
    );
    $arFilterElems = array (
        "IBLOCK_ID" => $arParams["CLASSIF_IBLOCK_ID"],
        'CHECK_PERMISSION' => $arParams['CACHE_GROUPS'],
        "ACTIVE" => "Y"
    );

    $rsElements = CIBlockElement::GetList(
        array(),
        $arFilterElems,
        false,
        false,
        $arSelectElems);

    while($arElement = $rsElements->GetNext())
    {
        $arClassif[$arElement['ID']] = $arElement;
        $arClassifID[] = $arElement['ID'];
    }
    $arResult['COUNT'] = count($arClassifID);

    $arSelectElemsProd = array (
        "ID",
        "IBLOCK_ID",
        'IBLOCK_SECTION_ID',
        "NAME",
        'DETAIL_PAGE_URL'
    );
    $arFilterElemsProd = array (
        "IBLOCK_ID" => $arParams["PRODUCTS_IBLOCK_ID"],
        'CHECK_PERMISSION' => $arParams['CACHE_GROUPS'],
        'PROPERTY_' . $arParams['PROPERTY_CODE'] => $arClassifID,
        "ACTIVE" => "Y"
    );

    $rsElementsProd = CIBlockElement::GetList(
        array(
            'NAME' => 'ASC',
            'SORT' => 'ASC'
        ),
        $arFilterElemsProd,
        false,
        false,
        $arSelectElemsProd
    );

    // Формирование ссылки из шаблона
    if ($arParams["TEMPLATE_DETAIL_LINK"]) {
        $rsElementsProd->SetUrlTemplates($arParams['TEMPLATE_DETAIL_LINK'] . '.php');
    }

    while($arElementProd = $rsElementsProd->GetNextElement())
    {
        $arField = $arElementProd->GetFields();
        $arField['PROPERTY'] = $arElementProd->GetProperties();

        foreach ($arField['PROPERTY']['FIRMA']['VALUE'] as $value) {
            $arClassif[$value]['ELEMENTS'][$arField['ID']] = $arField;
        }
    }

    $arResult['CLASSIF'] = $arClassif;
    $this->SetResultCacheKeys(array('COUNT'));
    $this->includeComponentTemplate();
} else {
    $this->abortResultCache();
}
$APPLICATION->SetTitle(GetMessage('TITLE_SECTIONS') . $arResult['COUNT']);
?>