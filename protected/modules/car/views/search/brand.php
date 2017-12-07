<?php
/* @var $this CarSearchController */
/* @var $brand Brands */
/* @var $filters array */
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
    <?php if(count($filters)):?>
        <div class="bottom">
            <div class="center-box">
                <div class="row">
                    <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12"></div>
                    <div class="col-lg-9 col-md-9 col-sm-9 col-xs-12">
                        <span>انتخاب شما</span>
                        <div class="filters">
                            <?php foreach($filters as $filter => $value):?>
                                <div class="filter"><?= $value?><a href="<?php ?>"><i></i></a></div>
                            <?php endforeach;?>
                            <a href="#" class="clear-filters-link">پاک کردن همه</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    <?php endif;?>
</div>
<div class="content-box">
    <div class="center-box">
        <div class="row">
            <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                <?php $this->renderPartial('_filter_box', array('filters' => $filters, 'selectedBrand' => $brand));?>
            </div>
            <div class="col-lg-9 col-md-9 col-sm-9 col-xs-12">
                <?php $this->widget('zii.widgets.CListView', array(
                    'dataProvider'=>$dataProvider,
                    'itemView'=>'_car_item',
                    'itemsCssClass' => 'advertising-list',
                    'template' => '{items}'
                )); ?>
                <a href="#" class="load-more">موارد بیشتر</a>
                <a href="#" class="load-more on-loading">در حال بارگذاری</a>
            </div>
        </div>
    </div>
</div>