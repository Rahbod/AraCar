<?php
/* @var $this CarSearchController */
/* @var $selectedBrands array */
/* @var $selectedStates array */
/* @var $priceRange array */
?>
<div class="filter-box">
    <div class="head">
        <span>استان</span>
        <i class="toggle-icon <?= (isset($selectedStates) and empty($selectedStates)) ? 'minus' : 'plus'?>" data-toggle="collapse" data-target="#context-1"></i>
    </div>
    <div class="context collapse<?= (isset($selectedStates) and empty($selectedStates)) ? ' in' : ''?>" aria-expanded="true" id="context-1">
        <ul class="list">
            <li><a href="#">تهران<span>19960</span></a></li>
            <li><a href="#">اصفهان<span>9460</span></a></li>
            <li><a href="#">البرز<span>45324</span></a></li>
            <li><a href="#">قم<span>7865</span></a></li>
            <li><a href="#">فارس<span>12345</span></a></li>
            <li><a href="#">مازندران<span>9464</span></a></li>
        </ul>
    </div>
</div>
<div class="filter-box">
    <div class="head">
        <span>قیمت</span>
        <i class="toggle-icon <?= (isset($priceRange) and empty($priceRange)) ? 'minus' : 'plus'?>" data-toggle="collapse" data-target="#context-2"></i>
    </div>
    <div class="context collapse<?= (isset($priceRange) and empty($priceRange)) ? ' in' : ''?>" aria-expanded="true" id="context-2">
        <div class="range-slider-container">
            <div class="range-slider" data-min="1000000" data-max="3000000" data-values="[1500000, 2500000]" data-step="1000" data-min-input=".range-min-input" data-max-input=".range-max-input"></div>
            <input type="text" class="range-min-input digitFormat text-field" value="1500000">
            <span class="currency">تومان</span>
            <input type="text" class="range-max-input digitFormat text-field" value="2500000">
            <span class="currency">تومان</span>
            <input type="button" class="btn-blue" value="اعمال فیلتر قیمت">
        </div>
    </div>
</div>
<div class="filter-box by-brand">
    <div class="head">
        <span>بر اساس برند</span>
        <i class="toggle-icon <?= (isset($selectedBrands) and empty($selectedBrands)) ? 'plus' : 'minus'?>" data-toggle="collapse" data-target="#context-3"></i>
    </div>
    <div class="context collapse<?= (isset($selectedBrands) and empty($selectedBrands)) ? '' : ' in'?>" aria-expanded="true" id="context-3">
        <input type="text" class="text-field" placeholder="جستجو برند...">
        <div class="nicescroll" data-cursorcolor="#b7b7b7" data-cursorborder="none" data-railpadding='js:{"top":0,"right":-12,"bottom":0,"left":0}' data-autohidemode="leave">
            <ul class="brands-list">
                <?php foreach($this->brands as $brand):?>
                    <?php /* @var Brands $brand */ ?>
                    <li<?= in_array($brand->id, $selectedBrands) ? ' class="selected"' : ''?>>
                        <label><a href="<?= $this->createUrl('brand', ['title' => $brand->slug])?>"><span class="title"><?= $brand->title?></span><span><?= $brand->carsCount?></span></a></label>
                    </li>
                <?php endforeach;?>
            </ul>
        </div>
    </div>
</div>