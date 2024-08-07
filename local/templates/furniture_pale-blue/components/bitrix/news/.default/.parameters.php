<?php
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)
{
	die();
}

/** @var array $arCurrentValues */

$arTemplateParameters = array(
	"SPECIALDATE" => Array(
		"NAME" => GetMessage("SPECIALDATE"),
		"TYPE" => "CHECKBOX",
		"DEFAULT" => "Y",
	),
);