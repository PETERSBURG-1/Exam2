<?
if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();
if (isset($arResult['MIN_PRICE']) && isset($arResult['MAX_PRICE'])) {
    $infoTemplates = '<div style="color:red; margin: 34px 15px 35px 15px">#TEXT#</div>';
    $pText = GetMessage('MIN_PRICE_TEXT') . $arResult['MIN_PRICE'] . '<br>' . GetMessage('MAX_PRICE_TEXT') . $arResult['MAX_PRICE'];
    $finalText = str_replace('#TEXT#', $pText, $infoTemplates);
    $APPLICATION->AddViewContent('prices', $finalText);
}