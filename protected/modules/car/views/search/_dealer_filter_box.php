<?php
/* @var $this CarSearchController */
/* @var $filters array */
/* @var $selectedBrand Brands */
$queryStrings = [];
if(Yii::app()->request->getQueryString())
    $queryStrings = explode('&', Yii::app()->request->getQueryString());
?>
<div class="filter-box">
    <div class="head">
        <span>جستجوی نام نمایشگاه</span>
    </div>
    <div class="context collapse in" style="padding: 15px 0">
        <div class="range-slider-container">
            <input type="text" class="text-field dealership-name" value="<?= isset($_GET['name'])?$_GET['name']:'' ?>" placeholder="نام نمایشگاه را وارد کنید">
            <a href="<?= $this->createFilterUrl('name', '')?>" class="btn-blue center-block text-center search-form">جستجو</a>
        </div>
    </div>
</div>
<div class="filter-box">
    <div class="head">
        <span>استان</span>
    </div>
    <div class="context collapse in">
        <ul class="list nicescroll" data-cursorcolor="#b7b7b7" data-cursorborder="none" data-railpadding='js:{"top":0,"right":-12,"bottom":0,"left":0}' data-autohidemode="leave">
            <?php foreach(Towns::model()->findAll() as $town):?>
                <li><a href="<?= $this->createFilterUrl('state', $town->slug)?>" class="<?= (isset($filters['state']) and $town->slug == $filters['state']) ? 'selected' : ''?>"><?= $town->name?><span><?= $town->dealershipsCount?></span></a></li>
            <?php endforeach;?>
        </ul>
    </div>
</div>

<?php Yii::app()->clientScript->registerScript('changeNameFilterBtnUrl', '
    function changeNameFilterBtnUrl(name) {
        var queryStrings = ' . (count($queryStrings) == 0 ? "[]" : CJSON::encode($queryStrings)) . ',
            filteredQueryStrings = [];

        $.each(queryStrings, function(index, item) {
            if(!item.match(/name/))
                filteredQueryStrings[filteredQueryStrings.length] = item;
        });

        if(filteredQueryStrings.length == 0)
            $(".filter-box .range-slider-container .btn-blue").attr("href", "?name=" + name);
        else
            $(".filter-box .range-slider-container .btn-blue").attr("href", "?" + filteredQueryStrings.join("&") + "&name=" + name);
    }
', CClientScript::POS_BEGIN);?>