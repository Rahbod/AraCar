<?php
/* @var $this CarSearchController */
/* @var $brand Brands */
/* @var $model Brands */
/* @var $dataProvider CActiveDataProvider */
?>

<div class="page-header">
    <div class="top">
        <div class="center-box">
            <div class="row">
                <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12"></div>
                <div class="col-lg-9 col-md-9 col-sm-9 col-xs-12">
                    <img src="<?= Yii::app()->baseUrl . '/uploads/brands/' . $brand->logo;?>" class="brand-logo">
                    <?php if(isset($model)):?>
                        <h2 class="brand-name"><?= $brand->title?><span> | <?= $model->title?></span><small><b><?= strtoupper(str_replace('-', ' ', $brand->slug))?></b> | <?= str_replace('-', ' ', $model->slug)?></small></h2>
                    <?php else:?>
                        <h2 class="brand-name"><?= $brand->title?><small><b><?= strtoupper(str_replace('-', ' ', $brand->slug))?></b></small></h2>
                    <?php endif;?>
                </div>
            </div>
        </div>
    </div>
    <div class="bottom">
        <div class="center-box">
            <div class="row">
                <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12"></div>
                <div class="col-lg-9 col-md-9 col-sm-9 col-xs-12">
                    <span>انتخاب شما</span>
                    <div class="filters">
                        <div class="filter">تهران<i></i></div>
                        <div class="filter">دنده ای<i></i></div>
                        <div class="filter">بدون رنگ<i></i></div>
                        <div class="filter">از 100.000.000 تا 220.000.000 تومان<i></i></div>
                        <a href="#" class="clear-filters-link">پاک کردن همه</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="content-box">
    <div class="center-box">
        <div class="row">
            <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                <?php $this->renderPartial('_filter_box', array('selectedBrands' => [$brand->id]));?>
            </div>
            <div class="col-lg-9 col-md-9 col-sm-9 col-xs-12">
                <?php $this->widget('zii.widgets.CListView', array(
                    'dataProvider'=>$dataProvider,
                    'itemView'=>'_car_item',
                    'itemsCssClass' => 'advertising-list'
                )); ?>
                <a href="#" class="load-more">موارد بیشتر</a>
                <a href="#" class="load-more on-loading">در حال بارگذاری</a>
            </div>
        </div>
    </div>
</div>