<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<?
if (!empty($arParams['ID_IBLOCK_CANONICAL'])) {
    $arSelect = array(
      'ID',
      'IBLOCK_ID',
      'NAME',
      'PROPERTY_NEW',
    );
    $arFilter = array(
        'IBLOCK_ID' => $arParams['ID_IBLOCK_CANONICAL'],
        'PROPERTY_NEW' => $arResult['ID'],
        'ACTIVE' => 'Y',
    );

    $res = CIBlockElement::GetList(
        array(),
        $arFilter,
        false,
        false,
        $arSelect
    );
    if($obRes = $res->GetNextElement())
    {
        $arField = $obRes->GetFields();
        $arResult['CANONICAL_LINK'] = $arField['NAME'];
        $this->__component->SetResultCacheKeys(array('CANONICAL_LINK'));
    }
}
?>

