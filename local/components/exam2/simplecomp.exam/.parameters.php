<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();
$arComponentParameters = array(
	"PARAMETERS" => array(
		"PRODUCTS_IBLOCK_ID" => array(
			"NAME" => GetMessage("EXAM2_CAT_IBLOCK_ID"),
            'PARENT' => 'BASE',
			"TYPE" => "STRING",
		),
        "NEWS_IBLOCK_ID" => array(
            "NAME" => GetMessage("EXAM2_NEWS_IBLOCK_ID"),
            'PARENT' => 'BASE',
            "TYPE" => "STRING",
        ),
        "PROPERTY_UF" => array(
            "NAME" => GetMessage("EXAM2_PROPERTY_UF"),
            'PARENT' => 'BASE',
            "TYPE" => "STRING",
        ),
        "CACHE_TIME"  =>  ["DEFAULT"=>36000000],
	),
);