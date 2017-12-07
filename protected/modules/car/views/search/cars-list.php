<?php
/* @var $this CarSearchController */
/* @var $filters array */
/* @var $dataProvider CActiveDataProvider */
?>

<div class="page-header">
    <div class="bottom">
        <div class="center-box">
            <div class="row">
                <div class="container-fluid">
                    <span style="padding-right: 0;">انتخاب شما</span>
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
                <?php $this->renderPartial('_filter_box', array('filters' => $filters));?>
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