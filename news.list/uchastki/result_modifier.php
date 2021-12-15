<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
//получаем картинку карты раздела
$uf_iblock_id = 25;
$uf_name = Array("UF_MAP","UF_NUMBER");
$uf_section_code = $arResult['SECTION']['PATH'][0]['ID'];
   $uf_arresult = CIBlockSection::GetList(Array("SORT"=>"­­ASC"), Array("IBLOCK_ID" => $uf_iblock_id, "ID" => $uf_section_code), false, $uf_name);
   if($uf_value = $uf_arresult->GetNext()):
		$arResult["MAIN_MAP"] = $uf_value["UF_MAP"];
                $arResult["NUMBER"] = $uf_value["UF_NUMBER"];
   endif;


    //Статусы
    $arSelect = Array("ID", "IBLOCK_ID", "NAME", "PROPERTY_COLOR");
    $arFilter = Array("IBLOCK_CODE"=>"statusi_uchastkokv","ID"=>$arItem['PROPERTIES']['STATUS']['VALUE'], "ACTIVE"=>"Y");
    $res = CIBlockElement::GetList(Array(), $arFilter, false, false, $arSelect);
    $status = array();
    $statusColor = array();
    while($ob = $res->GetNext()){ 
            $status[$ob["ID"]] = $ob['NAME'];
            $statusColor[$ob["ID"]] = $ob['PROPERTY_COLOR_VALUE'];
    }

    //Проекты
    $obElement  = Array("ID", "IBLOCK_ID", "NAME", "PROPERTY_MAKET");
    $arFilter1 = Array("IBLOCK_CODE"=>"uchastki_projects","ID"=>$arItem['PROPERTIES']['PROJECT']['VALUE'], "ACTIVE"=>"Y");
    $res1 = CIBlockElement::GetList(Array(), $arFilter1, false, false, $obElement);
    $project = array();
    $projectMaket = array();
    while($ob = $res1->GetNext()){ 
      $project[$ob["ID"]] = $ob['NAME'];
      $projectMaket[$ob["ID"]] = $ob['PROPERTY_MAKET_VALUE'];
}

foreach($arResult["ITEMS"] as $key => $arItem){
    //ССЫЛКА
    $link = $arItem['DETAIL_PAGE_URL'];
    $VIL_CODE = $GLOBALS['village_code'];
    $id = $arItem['ID'];
    $arResult['DETAIL_PAGE_URL_UCH'][$id] = str_replace("#VIL_CODE#", $VIL_CODE, $link);

    //статус
    $ID2=$arItem['PROPERTIES']['STATUS']['VALUE'];
    $arResult['status_name'][$id] = $status[$ID2];
    $arResult['status_color'][$id] = $statusColor[$ID2];
    
   //проект
   $ID1=$arItem['PROPERTIES']['PROJECT']['VALUE'];
   $arResult['PROJECT_NAME'][$id] = $project[$ID1];
   $arResult['PROJECT_MAKET'][$id] = $projectMaket[$ID1];
}

