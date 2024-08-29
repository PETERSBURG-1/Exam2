<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
---
<br>
<p><b><?=GetMessage("SIMPLECOMP_EXAM2_CAT_TITLE")?></b></p>
<? if ($arResult['CLASSIF']): ?>
    <ul>
        <? foreach ($arResult['CLASSIF'] as $arClassif): ?>
            <? if (!empty($arClassif['NAME'])): ?>
            <li><b><?= $arClassif['NAME'] ?></b></li>
            <ul>
                <? foreach ($arClassif['ELEMENTS'] as $arItems): ?>
                    <li>
                        <?= $arItems['NAME'] ?> -
                        <?= $arItems['PROPERTY']['PRICE']['VALUE']?> -
                        <?= $arItems['PROPERTY']['MATERIAL']['VALUE']?> -
                        (<a href="<?= $arItems['DETAIL_PAGE_URL']?>"><?= $arItems['DETAIL_PAGE_URL']?></a>)
                    </li>
                <? endforeach; ?>
            </ul>
            <? endif; ?>
        <? endforeach; ?>
    </ul>
<br>
    <p><b><?= GetMessage('NAVIGATION'); ?></b></p>
    <?= $arResult['NAV_STRING']?>
<? endif; ?>