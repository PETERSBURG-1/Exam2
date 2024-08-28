<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();
$arComponentParameters = array(
	"PARAMETERS" => array(
		"PRODUCTS_IBLOCK_ID" => array(
			"NAME" => GetMessage("CAT_IBLOCK_ID"),
            'PARENT' => 'BASE',
			"TYPE" => "STRING",
		),
        "CLASSIF_IBLOCK_ID" => array(
            "NAME" => GetMessage("CLASSIF_IBLOCK_ID"),
            'PARENT' => 'BASE',
            "TYPE" => "STRING",
        ),
        "TEMPLATE_DETAIL_LINK" => array(
            "NAME" => GetMessage("TEMPLATE_DETAIL_LINK"),
            'PARENT' => 'BASE',
            "TYPE" => "STRING",
        ),
        "PROPERTY_CODE" => array(
            "NAME" => GetMessage("PROPERTY_CODE"),
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