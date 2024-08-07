<?php
if ($arParams['SPECIALDATE'] == 'Y') {
    $arResult['FIRST_DATE_NEW'] = $arResult['ITEMS'][0]['ACTIVE_FROM'];
    $this->__component->SetResultCacheKeys(array('FIRST_DATE_NEW'));
}