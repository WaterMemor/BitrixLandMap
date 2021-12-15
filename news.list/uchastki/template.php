<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
/** @var array $arParams */
/** @var array $arResult */
/** @global CMain $APPLICATION */
/** @global CUser $USER */
/** @global CDatabase $DB */
/** @var CBitrixComponentTemplate $this */
/** @var string $templateName */
/** @var string $templateFile */
/** @var string $templateFolder */
/** @var string $componentPath */
/** @var CBitrixComponent $component */
$this->setFrameMode(true);
?>
<!--КАРТА-->
<div class="map">
   <input type="text" hidden id="number" value="<?=$arResult["NUMBER"];?>">
<?$arFile = CFile::GetFileArray($arResult["MAIN_MAP"]);?>
      <div class="cont">
         <img src="<?=CFile::GetPath($arResult["MAIN_MAP"]); ?>" alt="">
         <svg id="svg" xmlns="http://www.w3.org/2000/svg" xml:space="preserve"  version="1.1"
         viewBox="0 0 <?=$arFile['WIDTH']?> <?=$arFile['HEIGHT']?>" xmlns:xlink="http://www.w3.org/1999/xlink" xmlns:xodm="http://www.corel.com/coreldraw/odm/2003"></svg>
   </div>
   <input class="pictureWidth" type="text" hidden value="<?=$arFile['WIDTH']?>">
   <input class="pictureHeight" type="text" hidden value="<?=$arFile['HEIGHT']?>">
<!--//КАРТА-->

<?foreach($arResult["ITEMS"] as $key => $arItem):?>
	<?
	$this->AddEditAction($arItem['ID'], $arItem['EDIT_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_EDIT"));
	$this->AddDeleteAction($arItem['ID'], $arItem['DELETE_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_DELETE"), array("CONFIRM" => GetMessage('CT_BNL_ELEMENT_DELETE_CONFIRM')));
	?>
      <div id="<?=$this->GetEditAreaId($arItem['ID']);?>">
      <!-- инпут с координатами каждого участка-->
         <input type="text" class="coord" uchN="_<?=$arItem['ID']?>" hidden  status="<?=$arResult['status_color'][$arItem['ID']]?>" value="<?=$arItem['PROPERTIES']['COORDINATES']['VALUE']?>" >
         
         <?if($arItem['NAME'] != " "){?>
            <div class="name img_<?=$arItem['ID']?>"><?= htmlspecialchars_decode($arItem['NAME'])?></div>   
         <?}?>
         <!-- инпут с номерами каждого участка-->
         <?if($arItem['PROPERTIES']['NUMBER_OF_PLOT']['VALUE'] != ""){?>
            <div class="num_cont num_<?=$arItem['ID']?>">  
                  <span class="num" uchN="_<?=$arItem['ID']?>" style="margin-top:<?=($arItem['PROPERTIES']['SCALE_OF_HOUSE']['VALUE'])?>px"><?=$arItem['PROPERTIES']['NUMBER_OF_PLOT']['VALUE']?></span>
            </div>
         <?}?>

          <!-- инпут с картинками домов для каждого участка-->
		 <?if($arResult['PROJECT_MAKET'][$arItem['ID']]){?>
         	<img class="img_uch img_<?=$arItem['ID']?>"  uchN="_<?=$arItem['ID']?>" src="<?=CFile::GetPath($arResult['PROJECT_MAKET'][$arItem['ID']])?>" style="width:<?=($arItem['PROPERTIES']['SCALE_OF_HOUSE']['VALUE']*10)?>px" alt="" >
        <?}?>
      </div>

      <!-- Попап при нажатии на участок -->
<?if($arItem['PROPERTIES']['GO_TO_DETAIL_PAGE']['VALUE'] != "да"){?>
   <div class="_<?=$arItem['ID']?> uchastki_detail modal fade modal--form show" tabindex="-1" role="dialog" aria-labelledby="CallMeLabel" bis_skin_checked="1" aria-modal="true">
      <button type="button" class="modal-close" data-dismiss="modal" aria-label="Закрыть"></button>
      <div class="modal-dialog modal-dialog-centered modal-uch" id="otzivi_colorbox" role="document" bis_skin_checked="1">
         <div class="contact-message-callback-form contact-message-form contact-form block modal-content block-contact-block" data-user-info-from-browser="" data-drupal-selector="contact-message-callback-form" bis_skin_checked="1">
            <div class="modal-body" bis_skin_checked="1">
               <div role="dialog" tabindex="-1">
                  <article role="article" class="node row node--type-testimonial node--promoted node--view-mode-full"> 
                     <?if($arItem["PREVIEW_PICTURE"]["SRC"]){?>
                        <div class="testimonial-full-image">
                           <div class="field field--name-field-image field--type-image field--label-hidden field__item">
                              <img src="<?=$arItem["PREVIEW_PICTURE"]["SRC"]?>"  alt="строительство и продажа домов в Анапе и Анапском районе" loading="lazy" class="image-style-full">
                           </div>
                        </div>
                        <?}?>
                        <div class="node__content">
                           <?if($arItem['PROPERTIES']['NUMBER_OF_PLOT']['VALUE']){?>
                              <div>Номер участка: <?=$arItem['PROPERTIES']['NUMBER_OF_PLOT']['VALUE']?></div>
                           <?}?>
                           <?if($arItem['PROPERTIES']['SQUARE']['VALUE']){?>
                              <div>Площадь участка: <?=$arItem['PROPERTIES']['SQUARE']['VALUE']?> кв. м.</div>
                           <?}?>
                           <?if($arResult['PROJECT_NAME'][$arItem['ID']]){?>
                              <div>Проект: <?=$arResult['PROJECT_NAME'][$arItem['ID']]?></div>
                           <?}?>
                           <?if($arItem['PREVIEW_TEXT']){?>
                              <div>Особенности: <?=$arItem['PREVIEW_TEXT']?></div>
                           <?}?>
                           <?if($arItem['PROPERTIES']['STATUS']['VALUE']){?>
                              <div>Статус: <span style="color:<?=$arResult['status_color'][$arItem['ID']]?>"><?= $arResult['status_name'][$arItem['ID']] ?></span></div>
                           <?}?>                        
                        </div>
                           <a  href="<?=$arResult['DETAIL_PAGE_URL_UCH'][$arItem['ID']]?>" type="button"  name="button" class="look-full btn btn--main">Подробнее</a >
                       
                     </article>
                  </div>
            </div>
         </div>
      </div>
   </div>
   <?}?>
<?endforeach;?>

</div>


