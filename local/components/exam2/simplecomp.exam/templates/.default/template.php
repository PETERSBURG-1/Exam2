<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
---<br>
<p><b><?=GetMessage("SIMPLECOMP_EXAM2_CAT_TITLE")?></b></p>
<?
$url = $APPLICATION->GetCurPage() . '?F=Y';
?>
<?= GetMessage('FILTER_TITLE')?><a href="<?= $url?>"><?= $url?></a>
<? if ($arResult['NEWS']): ?>
    <ul>
        <? foreach ($arResult['NEWS'] as $key => $arNews): ?>
            <?
            $this->AddEditAction('add_element_' . $key, $arResult['ADD_LINK'], CIBlock::GetArrayByID($arResult["IBLOCK_ID"], "ELEMENT_ADD"));
            ?>
            <li>
                <b><?= $arNews['NAME']?></b> -
                <?= $arNews['ACTIVE_FROM']?>
                (<?= implode(', ', $arNews['SECTIONS'])?>)
            </li>
            <ul id="<?=$this->GetEditAreaId('add_element_' . $key);?>">
            <? foreach ($arNews['PRODUCTS'] as $arProducts): ?>
                <?
                $this->AddEditAction($arNews['ID'] . '_' . $arProducts['ID'], $arProducts['EDIT_LINK'], CIBlock::GetArrayByID($arProducts["IBLOCK_ID"], "ELEMENT_EDIT"));
                $this->AddDeleteAction($arNews['ID'] . '_' . $arProducts['ID'], $arProducts['DELETE_LINK'], CIBlock::GetArrayByID($arProducts["IBLOCK_ID"], "ELEMENT_DELETE"), array("CONFIRM" => GetMessage('CT_BNL_ELEMENT_DELETE_CONFIRM')));
                ?>
                <li id="<?=$this->GetEditAreaId($arNews['ID'] . '_' . $arProducts['ID']);?>">
                    <?= $arProducts['NAME']?> -
                    <?= $arProducts['PROPERTY_PRICE_VALUE']?> -
                    <?= $arProducts['PROPERTY_MATERIAL_VALUE']?> -
                    <?= $arProducts['PROPERTY_ARTNUMBER_VALUE']?>
                </li>
            <? endforeach;?>
            </ul>
        <? endforeach;?>
    </ul>
<? endif;?>
