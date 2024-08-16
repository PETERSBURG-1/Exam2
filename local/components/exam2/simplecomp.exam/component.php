<?
if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();

use Bitrix\Main\Loader,
	Bitrix\Iblock;

if(!Loader::includeModule("iblock"))
{
	ShowError(GetMessage("SIMPLECOMP_EXAM2_IBLOCK_MODULE_NONE"));
	return;
}

if (!isset($arParams['CACHE_TIME'])) {
    $arParams['CACHE_TIME'] = 36000000;
}

// Кэширование
if ($this->startResultCache()) {
    $arNews = [];
    $arNewsID = [];
    // Массив новостей
    $obNews = CIBlockElement::GetList(
        array(),
        array(
            'IBLOCK_ID' => $arParams['NEWS_IBLOCK_ID'],
            'ACTIVE' => 'Y',
        ),
        false,
        false,
        array(
            'NAME',
            'ACTIVE_FROM',
            'ID'
        ),
    );

    while ($newsElements = $obNews->Fetch()) {
        $arNewsID[] = $newsElements['ID'];
        $arNews[$newsElements['ID']] = $newsElements;
    }

    // Получаем список активных разделов с привязкой к новостям
    $arSections = [];
    $arSectionsID = [];

    $obSection = CIBlockSection::GetList(
        array(),
        array(
            'IBLOCK_ID' => $arParams['PRODUCTS_IBLOCK_ID'],
            'ACTIVE' => 'Y',
            $arParams['PROPERTY_UF'] => $arNewsID,
        ),
        false,
        array(
            'NAME',
            'IBLOCK_ID',
            'ID',
            $arParams['PROPERTY_UF'],
        ),
        false
    );

    while($arSectionCatalog = $obSection->Fetch())
    {
        $arSectionsID[] = $arSectionCatalog['ID'];
        $arSections[$arSectionCatalog['ID']] = $arSectionCatalog;
    }

    // Получаем список активных товаро из разделов
    $obProducts = CIBlockElement::GetList(
        array(),
        array(
            'IBLOCK_ID' => $arParams['PRODUCTS_IBLOCK_ID'],
            'ACTIVE' => 'Y',
            'SECTION_ID' => $arSectionsID,
        ),
        false,
        false,
        array(
            'NAME',
            'IBLOCK_SECTION_ID',
            'ID',
            'IBLOCK_ID',
            'PROPERTY_ARTNUMBER',
            'PROPERTY_MATERIAL',
            'PROPERTY_PRICE',

        ),
    );


    $arResult['PRODUCT_CNT'] = 0;
    while($arProducts = $obProducts->Fetch())
    {
        $arResult['PRODUCT_CNT'] ++;
       foreach ($arSections[$arProducts['IBLOCK_SECTION_ID']][$arParams['PROPERTY_UF']] as $newsID) {
            $arNews[$newsID]['PRODUCTS'][] = $arProducts;
       }
    }

    // Распеределяем разделы по новостям
    foreach ($arSections as $arSection) {

        foreach ($arSection[$arParams['PROPERTY_UF']] as $newID) {
            $arNews[$newID]['SECTIONS'][] = $arSection['NAME'];

        }
    }

    $arResult['NEWS'] = $arNews;

    $this->SetResultCacheKeys(array('PRODUCT_CNT'));
    $this->includeComponentTemplate();
} else {
    $this->abortResultCache();
}
$APPLICATION->SetTitle(GetMessage('TITLE_COUNT') . $arResult['PRODUCT_CNT']);
?>