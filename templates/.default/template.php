<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();
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

use Bitrix\Main\Application;
use Bitrix\Main\Web\Uri;

$request = Application::getInstance()->getContext()->getRequest();
$getParams = $request->getQueryList()->toArray();
$uri = new Uri($request->getRequestUri());
$currentUrlWithGetParams = $uri->getPathQuery();

$defaultSort = [
	'KEY' => 'SHOWS',
	'ORDER' => 'desc',
];

// Сортировка по полям
$sortFieldOptions = [
	[
		'KEY' => 'SHOWS',
		'ORDER' => 'desc',
		'NAME' => 'По популярности'
	],
	[
		'KEY' => 'TIMESTAMP_X',
		'ORDER' => 'desc',
		'NAME' => 'По новизне'
	],
	[
		'KEY' => 'catalog_PRICE_1',
		'ORDER' => 'asc',
		'NAME' => 'Сначала недорогие'
	],
	[
		'KEY' => 'catalog_PRICE_1',
		'ORDER' => 'desc',
		'NAME' => 'Сначала дорогие'
	],
];

// Сортировка по свойствам
$sortPropertiesOptions = [
	// сортировка по свойству типа «Список»
	[
		'KEY' => 'PROPERTY_PROP_ZAKAZ_NAL',
		'ORDER' => 'vnalichii',
		'NAME' => 'В наличии'
	],
];

$getSort = [
	"sort" => $getParams['sort'],
	"order" => $getParams['order']
];

$sortField = $getSort['sort'] ?: $defaultSort['KEY'];
$sortOrder = $getSort['order'] ?: $defaultSort['ORDER'];

$elementOrder['ELEMENT_SORT_FIELD'] = $sortField;
$elementOrder['ELEMENT_SORT_ORDER'] = $sortOrder;
?>

<div class="catalog-sorting">
	<select class="catalog-sortin__list" onchange="window.location.href=this.options[this.selectedIndex].value">
		<? foreach ($sortOptions as $sortKey => $sortValue) {
			$uri->addParams([
				'sort' => $sortValue['KEY'],
				'order' => $sortValue['ORDER']
			]);
			$resultUrl = $uri->getUri(); ?>
			<option value="<?= $resultUrl ?>"  class="catalog-sortin__item" <?= $sortField == $sortValue["KEY"] && $sortOrder == $sortValue["ORDER"] ? 'selected' : '' ?>><?= $sortValue['NAME'] ?></option>
		<? } ?>
	</select>
</div>

<!-- Перенести в script.js -->
<script>
	document.querySelector(".js-sorting-catalog").onchange = function() {
		location.assign(this.value);
	}
</script>

<script>
	let <?= $jsObjectName ?> = new JCCustom(<?= CUtil::PhpToJSObject($jsParams, false, true) ?>);
</script>
