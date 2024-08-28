<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
---<br>
<p><b><?=GetMessage("SIMPLECOMP_EXAM2_CAT_TITLE")?></b></p>
<?
$url = $APPLICATION->GetCurPage() . '?F=Y';
?>
<?= GetMessage('FILTER_TITLE')?><a href="<?= $url?>"><?= $url?></a>
<? if ($arResult['NEWS']): ?>
    <ul>
        <? foreach ($arResult['NEWS'] as $arNews): ?>
            <li>
                <b><?= $arNews['NAME']?></b> -
                <?= $arNews['ACTIVE_FROM']?>
                (<?= implode(', ', $arNews['SECTIONS'])?>)
            </li>
            <ul>
            <? foreach ($arNews['PRODUCTS'] as $arProducts): ?>
                <li>
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
