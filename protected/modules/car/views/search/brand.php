<?php
/* @var $this CarSearchController */
/* @var $brand Brands */
/* @var $filters array */
/* @var $model Models */
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
                            <?= $this->createFiltersBar($filters);?>
                            <a href="<?= $this->createUrl('/'.Yii::app()->request->pathInfo)?>" class="clear-filters-link">پاک کردن همه</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    <?php endif;?>
</div>
<div class="content-box">
    <div class="center-box">
        <a href="#" class="filter-btn floating-button left filter-box-trigger" data-title="فیلترها"></a>
        <div class="row">
            <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12 filters-container">
                <div class="close-container"><i class="menu-close-icon filter-box-trigger"></i></div>
                <?php $this->renderPartial('_filter_box', array('filters' => $filters, 'selectedBrand' => $brand));?>
            </div>
            <div class="col-lg-9 col-md-9 col-sm-12 col-xs-12">
                <?php $this->renderPartial('_top_filter_box', array('filters' => $filters, 'selectedBrand' => $brand));?>
                <?php $this->widget('zii.widgets.CListView', array(
                    'id' => 'advertising-list',
                    'dataProvider'=>$dataProvider,
                    'itemView'=>'_car_item',
                    'itemsCssClass' => 'advertising-list',
                    'template' => '{items}{pager}',
                    'pager' => array(
                        'class' => 'ext.infiniteScroll.IasPager',
                        'rowSelector'=>'.advertising-item',
                        'listViewId' => 'advertising-list',
                        'header' => '',
                        'loaderText'=>'Loading...',
                        'options' => array('history' => false, 'triggerPageTreshold' => 1, 'trigger'=>'Load more'),
                    )
                )); ?>
<!--                <a href="#" class="load-more">موارد بیشتر</a>-->
<!--                <a href="#" class="load-more on-loading">در حال بارگذاری</a>-->
            </div>
        </div>
    </div>
</div>