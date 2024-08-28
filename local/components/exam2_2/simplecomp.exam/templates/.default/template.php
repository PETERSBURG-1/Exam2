<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
---
<br>
<p><b><?=GetMessage("SIMPLECOMP_EXAM2_CAT_TITLE")?></b></p>
<? if ($arResult['CLASSIF']): ?>
    <ul>
        <? foreach ($arResult['CLASSIF'] as $arClassif): ?>
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
        <? endforeach; ?>
    </ul>
<? endif; ?>