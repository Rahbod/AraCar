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
            <input type="text" class="text-field" value="<?= isset($_GET['name'])?$_GET['name']:'' ?>" placeholder="نام نمایشگاه را وارد کنید">
            <a href="<?= $this->createFilterUrl('term','')?>" class="btn-blue center-block text-center search-form">
                جستجو
            </a>
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
                <li><a href="<?= $this->createFilterUrl('state', $town->slug)?>" class="<?= (isset($filters['state']) and $town->slug == $filters['state']) ? 'selected' : ''?>"><?= $town->name?><span><?= $town->carsCount?></span></a></li>
            <?php endforeach;?>
        </ul>
    </div>
</div>

<?php
Yii::app()->clientScript->registerScript('asd', '
    $("body").on("click", ".search-form", function(){
        
    });
');