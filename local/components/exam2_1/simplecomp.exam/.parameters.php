<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();
$arComponentParameters = array(
	"PARAMETERS" => array(
		"NEWS_IBLOCK_ID" => array(
			"NAME" => GetMessage("NEWS_IBLOCK_ID"),
            'PARENT' => 'BASE',
			"TYPE" => "STRING",
		),
        "PROPERTY_IBLOCK" => array(
            "NAME" => GetMessage("PROPERTY_IBLOCK"),
            'PARENT' => 'BASE',
            "TYPE" => "STRING",
        ),
        "PROPERTY_UF" => array(
            "NAME" => GetMessage("PROPERTY_UF"),
            'PARENT' => 'BASE',
            "TYPE" => "STRING",
        ),
        "CACHE_TIME"  =>  ["DEFAULT"=>36000000],
        "CACHE_GROUPS" => [
            "PARENT" => "CACHE_SETTINGS",
            "NAME" => GetMessage("CP_BN_CACHE_GROUPS"),
            "TYPE" => "CHECKBOX",
            "DEFAULT" => "Y",
        ],
	),
);