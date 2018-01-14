<?php
/* @var $this CarSearchController */
/* @var $filters array */
/* @var $selectedBrand Brands */
$queryStrings = [];
if(Yii::app()->request->getQueryString())
    $queryStrings = explode('&', Yii::app()->request->getQueryString());
$orderTypes = [
    //"all"     => "مرتب سازی بر اساس",
    "time"     => "به روزترین آگهی",
    "max-cast" => "گرانترین",
    "min-cast" => "ارزانترین",
    "new-year" => "جدیدترین سال",
    "old-year" => "قدیمی ترین سال",
    "min-dist" => "کم کارکرد ترین",
    "max-dist" => "پر کارکرد ترین"
];
?>
<div class="top-filter-box">
    <div class="row">
        <div class="col-lg-3 col-md-3 col-sm-3 col-xs-6">
            <input type="text" value="<?= isset($filters['min-year']) ? $filters['min-year'] : '' ?>" class="text-field" id="min-year" data-toggle="popover" data-placement="bottom" data-trigger="focus" data-content="4 رقمی، شمسی یا میلادی" placeholder="از سال">
        </div>
        <div class="col-lg-3 col-md-3 col-sm-3 col-xs-6">
            <input type="text" value="<?= isset($filters['max-year']) ? $filters['max-year'] : '' ?>" class="text-field" id="max-year" data-toggle="popover" data-placement="bottom" data-trigger="focus" data-content="4 رقمی، شمسی یا میلادی" placeholder="تا سال">
        </div>
        <div class="col-lg-3 col-md-3 col-sm-3 col-xs-6">
            <input type="text" value="<?= isset($filters['min-distance']) ? $filters['min-distance'] : '' ?>" class="text-field" id="min-distance" data-toggle="popover" data-placement="bottom" data-trigger="focus" data-content="بر حسب هزار کیلومتر" placeholder="از کارکرد">
        </div>
        <div class="col-lg-3 col-md-3 col-sm-3 col-xs-6">
            <input type="text" value="<?= isset($filters['max-distance']) ? $filters['max-distance'] : '' ?>" class="text-field" id="max-distance" data-toggle="popover" data-placement="bottom" data-trigger="focus" data-content="بر حسب هزار کیلومتر" placeholder="تا کارکرد">
        </div>
    </div>
    <div class="row">
        <div class="col-lg-3 col-md-3 col-sm-3 col-xs-6">
            <?= CHtml::dropDownList('', isset($filters['purchase']) ? $filters['purchase'] : 'all', array_merge(['all' => 'نوع پرداخت مهم نیست'], Cars::$purchase_types), [
                'class' => 'selectpicker select-field',
                'id' => 'purchase'
            ])?>
        </div>
        <div class="col-lg-3 col-md-3 col-sm-3 col-xs-6">
            <?= CHtml::dropDownList('', isset($_GET['order']) ? $_GET['order'] : 'time', $orderTypes, [
                'class' => 'selectpicker select-field',
                'id' => 'order'
            ])?>
        </div>
        <div class="col-lg-3 col-md-3 col-sm-3 col-xs-6">
            <input type="checkbox" id="has-image"<?= (isset($filters['has-image']) and $filters['has-image']) ? ' checked' : ''?>>
            <label for="has-image">عکس دار</label>
        </div>
        <div class="col-lg-3 col-md-3 col-sm-3 col-xs-6">
            <input type="button" class="btn-blue center-block text-center" onclick="submitTopFilter()" value="جستجو">
        </div>
    </div>
</div>
<?php Yii::app()->clientScript->registerScript('submitTopFilter', '
    function submitTopFilter() {
        var queryStrings = ' . (count($queryStrings) == 0 ? "[]" : CJSON::encode($queryStrings)) . ',
            topFilters = [],
            filteredQueryStrings = [];

        $.each(queryStrings, function(index, item) {
            if(!item.match(/min-year/) && !item.match(/max-year/) && !item.match(/min-distance/) && !item.match(/max-distance/) && !item.match(/purchase/) && !item.match(/has-image/) && !item.match(/order/))
                filteredQueryStrings[filteredQueryStrings.length] = item;
        });

        if($("#min-year").val() != "")
            topFilters[topFilters.length] = "min-year="+$("#min-year").val();

        if($("#max-year").val() != "")
            topFilters[topFilters.length] = "max-year="+$("#max-year").val();

        if($("#min-distance").val() != "")
            topFilters[topFilters.length] = "min-distance="+$("#min-distance").val();

        if($("#max-distance").val() != "")
            topFilters[topFilters.length] = "max-distance="+$("#max-distance").val();

        if($("#purchase").val() != "" && $("#purchase").val() != "all")
            topFilters[topFilters.length] = "purchase="+$("#purchase").val();

        if($("#order").val() != "" && $("#order").val() != "all")
            topFilters[topFilters.length] = "order="+$("#order").val();

        if($("#has-image").is(":checked"))
            topFilters[topFilters.length] = "has-image=1";
//        else
//            topFilters[topFilters.length] = "has-image=0";

        if(filteredQueryStrings.length == 0) {
            if(topFilters.length != 0)
                window.location.href = "' . Yii::app()->createUrl(Yii::app()->request->pathInfo) . '?" + topFilters.join("&");
        } else {
            if(topFilters.length != 0)
                window.location.href = "' . Yii::app()->createUrl(Yii::app()->request->pathInfo) . '?" + filteredQueryStrings.join("&") + "&" + topFilters.join("&");
            else
                window.location.href = "' . Yii::app()->createUrl(Yii::app()->request->pathInfo) . '?" + filteredQueryStrings.join("&");
        }
    }
', CClientScript::POS_BEGIN);?>