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
        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
<!--            --><?php //if(isset($selectedBrand)):?>
<!--                <div class="filter-box">-->
<!--                    <div class="head" data-toggle="collapse" data-target="#context-8">-->
<!--                        <span>مدل</span>-->
<!--                        <i class="toggle-icon --><?//= isset($filters['model']) ? 'minus' : 'plus'?><!--"></i>-->
<!--                    </div>-->
<!--                    <div class="context collapse--><?//= isset($filters['model']) ? ' in' : ''?><!--" aria-expanded="true" id="context-8">-->
<!--                        <ul class="list nicescroll" data-cursorcolor="#b7b7b7" data-cursorborder="none" data-railpadding='js:{"top":0,"right":-12,"bottom":0,"left":0}' data-autohidemode="leave">-->
<!--                            --><?php //foreach($selectedBrand->models as $model):?>
<!--                                <li><a href="--><?//= $this->createFilterUrl('model', $model->slug)?><!--" class="--><?//= (isset($filters['model']) and $model->slug == $filters['model']) ? 'selected' : ''?><!--">--><?//= $model->title?><!--<span>--><?//= $model->carsCount?><!--</span></a></li>-->
<!--                            --><?php //endforeach;?>
<!--                        </ul>-->
<!--                    </div>-->
<!--                </div>-->
<!--            --><?php //endif; ?>
            <?= CHtml::dropDownList('model_id',isset($filters['model']) ? $filters['model'] : '',
                isset($selectedBrand)?CHtml::listData($selectedBrand->models, function ($model){ return urlencode($model->slug); }, "title"):array(), [
                    'class' => 'selectpicker select-field',
                    'data-live-search' => true,
                    'id' => 'Cars_brand',
                    'disabled' => !isset($selectedBrand),
                    'prompt' => "همه مدل ها",
            ])?>
        </div>
        <div class="col-lg-2 col-md-2 col-sm-2 col-xs-6">
            <input type="text" value="<?= isset($filters['min-year']) ? $filters['min-year'] : '' ?>" class="text-field" id="min-year" data-toggle="popover" data-placement="bottom" data-trigger="focus" data-content="4 رقمی، شمسی یا میلادی" placeholder="از سال">
        </div>
        <div class="col-lg-2 col-md-2 col-sm-2 col-xs-6">
            <input type="text" value="<?= isset($filters['max-year']) ? $filters['max-year'] : '' ?>" class="text-field" id="max-year" data-toggle="popover" data-placement="bottom" data-trigger="focus" data-content="4 رقمی، شمسی یا میلادی" placeholder="تا سال">
        </div>
        <div class="col-lg-2 col-md-2 col-sm-2 col-xs-6">
            <input type="text" value="<?= isset($filters['min-distance']) ? $filters['min-distance'] : '' ?>" class="text-field" id="min-distance" data-toggle="popover" data-placement="bottom" data-trigger="focus" data-content="بر حسب هزار کیلومتر" placeholder="از کارکرد">
        </div>
        <div class="col-lg-2 col-md-2 col-sm-2 col-xs-6">
            <input type="text" value="<?= isset($filters['max-distance']) ? $filters['max-distance'] : '' ?>" class="text-field" id="max-distance" data-toggle="popover" data-placement="bottom" data-trigger="focus" data-content="بر حسب هزار کیلومتر" placeholder="تا کارکرد">
        </div>
    </div>
    <div class="row">
        <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
            <?= CHtml::dropDownList('', isset($filters['purchase']) ? $filters['purchase'] : 'all', array_merge(['all' => 'نوع پرداخت مهم نیست'], Cars::$purchase_types), [
                'class' => 'selectpicker select-field',
                'id' => 'purchase'
            ])?>
        </div>
        <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
            <?= CHtml::dropDownList('', isset($_GET['order']) ? $_GET['order'] : 'time', $orderTypes, [
                'class' => 'selectpicker select-field',
                'id' => 'order'
            ])?>
        </div>
        <div class="col-lg-3 col-md-3 col-sm-3 col-xs-6">
            <div class="row">
                <span class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
                    <input type="checkbox" id="has-image"<?= (isset($filters['has-image']) and $filters['has-image']) ? ' checked' : ''?>>
                    <label for="has-image">عکس دار</label>
                </span>
                <span class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
                    <input type="checkbox" id="special"<?= (isset($filters['special']) and $filters['special']) ? ' checked' : ''?>>
                    <label for="special">ویژه</label>
                </span>
            </div>
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
            if(!item.match(/model/) && !item.match(/min-year/) && !item.match(/max-year/) && !item.match(/min-distance/) && !item.match(/max-distance/) && !item.match(/purchase/) && !item.match(/has-image/) && !item.match(/order/))
                filteredQueryStrings[filteredQueryStrings.length] = item;
        });

        if($("#Cars_brand").val() != "")
            topFilters[topFilters.length] = "model="+$("#Cars_brand").val();
        
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
            
        if($("#special").is(":checked"))
            topFilters[topFilters.length] = "special=1";

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