<?php
/* @var $this CarSearchController */
/* @var $filters array */
/* @var $selectedBrand Brands */
$queryStrings = [];
if(Yii::app()->request->getQueryString())
    $queryStrings = explode('&', Yii::app()->request->getQueryString());

$price = [
    'min' => 1,
    'max' => 100,
];
if(isset($filters['price'])) {
    $prices = explode('-', $filters['price']);
    $price['min'] = $prices[0];
    $price['max'] = isset($prices[1])?$prices[1]:false;
}
?>
<div class="filter-box">
    <div class="head" data-toggle="collapse" data-target="#context-2">
        <span>قیمت</span>
        <i class="toggle-icon minus"></i>
    </div>
    <div class="context collapse in" aria-expanded="true" id="context-2">
        <div class="range-slider-container">
            <input type="text" class="range-min-input digitFormat text-field ltr" value="<?= $price['min']?>" placeholder="از">
            <span class="currency">میلیون تومان</span>
            <input type="text" class="range-max-input digitFormat text-field ltr" value="<?= $price['max']?:''?>" placeholder="تا">
            <span class="currency">میلیون تومان</span>
            <a href="<?= $this->createFilterUrl('price', isset($filters['price']) ? $filters['price'] : '1-100')?>" class="price-filter btn-blue center-block text-center">اعمال فیلتر قیمت</a>
        </div>
    </div>
</div>
<div class="filter-box by-brand">
    <div class="head" data-toggle="collapse" data-target="#context-3">
        <span>بر اساس برند</span>
        <i class="toggle-icon minus"></i>
    </div>
    <div class="context collapse in" aria-expanded="true" id="context-3">
        <input type="text" class="text-field" placeholder="جستجو برند...">
        <div class="nicescroll" data-cursorcolor="#b7b7b7" data-cursorborder="none" data-railpadding='js:{"top":0,"right":-12,"bottom":0,"left":0}' data-autohidemode="leave">
            <ul class="brands-list">
                <?php foreach($this->brands as $brand):?>
                    <?php /* @var Brands $brand */ ?>
                    <li<?= (isset($selectedBrand) and $brand->id == $selectedBrand->id) ? ' class="selected"' : ''?>>
                        <?php if(count($queryStrings) == 0):?>
                            <label><a href="<?= $this->createUrl('brand', ['title' => $brand->slug])?>"><span class="title"><?= $brand->title?></span><span><?= $brand->carsCount?></span></a></label>
                        <?php else:?>
                            <label><a href="<?= $this->createUrl('brand', ['title' => $brand->slug])?>?<?= Yii::app()->request->getQueryString()?>"><span class="title"><?= $brand->title?></span><span><?= $brand->carsCount?></span></a></label>
                        <?php endif;?>
                    </li>
                <?php endforeach;?>
            </ul>
        </div>
    </div>
</div>
<?php if(isset($selectedBrand)):?>
<div class="filter-box">
    <div class="head" data-toggle="collapse" data-target="#context-8">
        <span>مدل</span>
        <i class="toggle-icon <?= isset($filters['model']) ? 'minus' : 'plus'?>"></i>
    </div>
    <div class="context collapse<?= isset($filters['model']) ? ' in' : ''?>" aria-expanded="true" id="context-8">
        <ul class="list nicescroll" data-cursorcolor="#b7b7b7" data-cursorborder="none" data-railpadding='js:{"top":0,"right":-12,"bottom":0,"left":0}' data-autohidemode="leave">
            <?php foreach($selectedBrand->models as $model):?>
                <li><a href="<?= $this->createFilterUrl('model', $model->slug)?>" class="<?= (isset($filters['model']) and $model->slug == $filters['model']) ? 'selected' : ''?>"><?= $model->title?><span><?= $model->carsCount?></span></a></li>
            <?php endforeach;?>
        </ul>
    </div>
</div>
<?php endif; ?>
<div class="filter-box">
    <div class="head" data-toggle="collapse" data-target="#context-1">
        <span>استان</span>
        <i class="toggle-icon <?= isset($filters['state']) ? 'minus' : 'plus'?>"></i>
    </div>
    <div class="context collapse<?= isset($filters['state']) ? ' in' : ''?>" aria-expanded="true" id="context-1">
        <ul class="list nicescroll" data-cursorcolor="#b7b7b7" data-cursorborder="none" data-railpadding='js:{"top":0,"right":-12,"bottom":0,"left":0}' data-autohidemode="leave">
            <?php foreach(Towns::model()->findAll() as $town):?>
                <li><a href="<?= $this->createFilterUrl('state', $town->slug)?>" class="<?= (isset($filters['state']) and $town->slug == $filters['state']) ? 'selected' : ''?>"><?= $town->name?><span><?= $town->carsCount?></span></a></li>
            <?php endforeach;?>
        </ul>
    </div>
</div>
<div class="filter-box">
    <div class="head" data-toggle="collapse" data-target="#context-4">
        <span>شاسی</span>
        <i class="toggle-icon <?= isset($filters['body']) ? 'minus' : 'plus'?>"></i>
    </div>
    <div class="context collapse<?= isset($filters['body']) ? ' in' : ''?>" aria-expanded="true" id="context-4">
        <ul class="list nicescroll" data-cursorcolor="#b7b7b7" data-cursorborder="none" data-railpadding='js:{"top":0,"right":-12,"bottom":0,"left":0}' data-autohidemode="leave">
            <?php foreach(Lists::getList('body_types', true) as $body):?>
                <li><a href="<?= $this->createFilterUrl('body', $body->id)?>" class="<?= (isset($filters['body']) and ($body->id == $filters['body'] or $body->title == str_replace('-', ' ', urldecode($filters['body'])))) ? 'selected' : ''?>"><?= $body->title?></a></li>
            <?php endforeach;?>
        </ul>
    </div>
</div>
<div class="filter-box">
    <div class="head" data-toggle="collapse" data-target="#context-5">
        <span>وضعیت خودرو</span>
        <i class="toggle-icon <?= isset($filters['car_type']) ? 'minus' : 'plus'?>"></i>
    </div>
    <div class="context collapse<?= isset($filters['car_type']) ? ' in' : ''?>" aria-expanded="true" id="context-5">
        <ul class="list nicescroll" data-cursorcolor="#b7b7b7" data-cursorborder="none" data-railpadding='js:{"top":0,"right":-12,"bottom":0,"left":0}' data-autohidemode="leave">
            <?php foreach(Lists::getList('car_types', true) as $carType):?>
                <li><a href="<?= $this->createFilterUrl('car_type', $carType->id)?>" class="<?= (isset($filters['car_type']) and $carType->id == $filters['car_type']) ? 'selected' : ''?>"><?= $carType->title?></a></li>
            <?php endforeach;?>
        </ul>
    </div>
</div>
<div class="filter-box">
    <div class="head" data-toggle="collapse" data-target="#context-6">
        <span>گیربکس</span>
        <i class="toggle-icon <?= isset($filters['gearbox']) ? 'minus' : 'plus'?>"></i>
    </div>
    <div class="context collapse<?= isset($filters['gearbox']) ? ' in' : ''?>" aria-expanded="true" id="context-6">
        <ul class="list nicescroll" data-cursorcolor="#b7b7b7" data-cursorborder="none" data-railpadding='js:{"top":0,"right":-12,"bottom":0,"left":0}' data-autohidemode="leave">
            <?php foreach(Lists::getList('gearbox_types', true) as $gearboxType):?>
                <li><a href="<?= $this->createFilterUrl('gearbox', $gearboxType->id)?>" class="<?= (isset($filters['gearbox']) and $gearboxType->id == $filters['gearbox']) ? 'selected' : ''?>"><?= $gearboxType->title?></a></li>
            <?php endforeach;?>
        </ul>
    </div>
</div>
<div class="filter-box">
    <div class="head" data-toggle="collapse" data-target="#context-7">
        <span>وضعیت بدنه</span>
        <i class="toggle-icon <?= isset($filters['body_state']) ? 'minus' : 'plus'?>"></i>
    </div>
    <div class="context collapse<?= isset($filters['body_state']) ? ' in' : ''?>" aria-expanded="true" id="context-7">
        <ul class="list nicescroll" data-cursorcolor="#b7b7b7" data-cursorborder="none" data-railpadding='js:{"top":0,"right":-12,"bottom":0,"left":0}' data-autohidemode="leave">
            <?php foreach(Lists::getList('body_states', true) as $bodyState):?>
                <li><a href="<?= $this->createFilterUrl('body_state', $bodyState->id)?>" class="<?= (isset($filters['body_state']) and $bodyState->id == $filters['body_state']) ? 'selected' : ''?>"><?= $bodyState->title?></a></li>
            <?php endforeach;?>
        </ul>
    </div>
</div>
<div class="filter-box">
    <div class="head" data-toggle="collapse" data-target="#context-9">
        <span>سوخت</span>
        <i class="toggle-icon <?= isset($filters['fuel']) ? 'minus' : 'plus'?>"></i>
    </div>
    <div class="context collapse<?= isset($filters['fuel']) ? ' in' : ''?>" aria-expanded="true" id="context-9">
        <ul class="list nicescroll" data-cursorcolor="#b7b7b7" data-cursorborder="none" data-railpadding='js:{"top":0,"right":-12,"bottom":0,"left":0}' data-autohidemode="leave">
            <?php foreach(Lists::getList('fuel_types', true) as $fuel):?>
                <li><a href="<?= $this->createFilterUrl('fuel', $fuel->id)?>" class="<?= (isset($filters['fuel']) and $fuel->id == $filters['fuel']) ? 'selected' : ''?>"><?= $fuel->title?></a></li>
            <?php endforeach;?>
        </ul>
    </div>
</div>
<div class="filter-box">
    <div class="head" data-toggle="collapse" data-target="#context-10">
        <span>موارد خاص</span>
        <i class="toggle-icon <?= isset($filters['plate']) ? 'minus' : 'plus'?>"></i>
    </div>
    <div class="context collapse<?= isset($filters['plate']) ? ' in' : ''?>" aria-expanded="true" id="context-10">
        <ul class="list nicescroll" data-cursorcolor="#b7b7b7" data-cursorborder="none" data-railpadding='js:{"top":0,"right":-12,"bottom":0,"left":0}' data-autohidemode="leave">
            <?php foreach(Lists::getList('plate_types', true) as $plate):?>
                <li><a href="<?= $this->createFilterUrl('plate', $plate->id)?>" class="<?= (isset($filters['plate']) and ($plate->id == $filters['plate'] or $plate->title == str_replace('-', ' ', urldecode($filters['plate'])))) ? 'selected' : ''?>"><?= $plate->title?></a></li>
            <?php endforeach;?>
        </ul>
    </div>
</div>
<div class="filter-box">
    <div class="head" data-toggle="collapse" data-target="#context-11">
        <span>رنگ</span>
        <i class="toggle-icon <?= isset($filters['color']) ? 'minus' : 'plus'?>"></i>
    </div>
    <div class="context collapse<?= isset($filters['color']) ? ' in' : ''?>" aria-expanded="true" id="context-11">
        <ul class="list nicescroll" data-cursorcolor="#b7b7b7" data-cursorborder="none" data-railpadding='js:{"top":0,"right":-12,"bottom":0,"left":0}' data-autohidemode="leave">
            <?php foreach(Lists::getList('colors', true) as $color):?>
                <li><a href="<?= $this->createFilterUrl('color', $color->id)?>" class="<?= (isset($filters['color']) and $color->id == $filters['color']) ? 'selected' : ''?>"><?= $color->title?></a></li>
            <?php endforeach;?>
        </ul>
    </div>
</div>
<?php Yii::app()->clientScript->registerScript('changePriceFilterBtnUrl', '
    function changePriceFilterBtnUrl(min, max) {
        var queryStrings = ' . (count($queryStrings) == 0 ? "[]" : CJSON::encode($queryStrings)) . ',
            hasPrice = false
            filteredQueryStrings = [];

        $.each(queryStrings, function(index, item) {
            if(!item.match(/price/))
                filteredQueryStrings[filteredQueryStrings.length] = item;
        });

        if(min == null && max == null)
            $(".filter-box .range-slider-container .btn-blue").attr("href", "#");
        else{
            if(min == null)
                min = "";

            if(max == null)
                max = "";

            if(filteredQueryStrings.length == 0)
                $(".filter-box .range-slider-container .btn-blue").attr("href", "?price=" + min + "-" + max);
            else
                $(".filter-box .range-slider-container .btn-blue").attr("href", "?" + filteredQueryStrings.join("&") + "&price=" + min + "-" + max);
        }
    }
', CClientScript::POS_BEGIN);?>