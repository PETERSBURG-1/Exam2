<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<p><b><?=GetMessage("SIMPLECOMP_EXAM2_CAT_TITLE")?></b></p>
<? if (!empty($arResult['AUTHORS'])): ?>
    <ul>
        <? foreach ($arResult['AUTHORS'] as $key => $arAuthor): ?>
            <li>
                [<?= $key; ?>] <?= $arAuthor['LOGIN']; ?>
                <? if (!empty($arAuthor['NEWS'])): ?>
                    <ul>
                        <? foreach($arAuthor['NEWS'] as $arNews): ?>
                            <li>- <?= $arNews['NAME'] ?></li>
                        <? endforeach; ?>
                    </ul>
                <? endif; ?>
            </li>
        <? endforeach;?>
    </ul>
<? endif; ?>
