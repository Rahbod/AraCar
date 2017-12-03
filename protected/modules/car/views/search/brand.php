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
                <div class="filter-box">
                    <div class="head">
                        <span>استان</span>
                        <i class="toggle-icon minus" data-toggle="collapse" data-target="#context-1"></i>
                    </div>
                    <div class="context collapse in" aria-expanded="true" id="context-1">
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
                        <i class="toggle-icon minus" data-toggle="collapse" data-target="#context-2"></i>
                    </div>
                    <div class="context collapse in" aria-expanded="true" id="context-2">
                        <div class="range-slider-container">
                            <div class="range-slider" data-min="1000000" data-max="3000000" data-values="[1500000, 2500000]" data-step="1000" data-min-input=".range-min-input" data-max-input=".range-max-input"></div>
                            <input type="text" class="range-min-input currency-format text-field" value="1500000">
                            <span class="currency">تومان</span>
                            <input type="text" class="range-max-input currency-format text-field" value="2500000">
                            <span class="currency">تومان</span>
                            <input type="button" class="btn-blue" value="اعمال فیلتر قیمت">
                        </div>
                    </div>
                </div>
                <div class="filter-box by-brand">
                    <div class="head">
                        <span>بر اساس برند</span>
                        <i class="toggle-icon minus" data-toggle="collapse" data-target="#context-3"></i>
                    </div>
                    <div class="context collapse in" aria-expanded="true" id="context-3">
                        <input type="text" class="text-field" placeholder="جستجو برند...">
                        <div class="nicescroll" data-cursorcolor="#b7b7b7" data-cursorborder="none" data-railpadding='js:{"top":0,"right":-12,"bottom":0,"left":0}' data-autohidemode="leave">
                            <ul class="brands-list">
                                <li>
                                    <input type="checkbox" id="chb-1" checked>
                                    <label for="chb-1"><span class="title">آئودی</span><span>74</span></label>
                                </li>
                                <li>
                                    <input type="checkbox" id="chb-2">
                                    <label for="chb-2"><span class="title">اپل</span><span>14</span></label>
                                </li>
                                <li>
                                    <input type="checkbox" id="chb-3">
                                    <label for="chb-3"><span class="title">اسمارت</span><span>20</span></label>
                                </li>
                                <li>
                                    <input type="checkbox" id="chb-4">
                                    <label for="chb-4"><span class="title">ام وی ام</span><span>56</span></label>
                                </li>
                                <li>
                                    <input type="checkbox" id="chb-5">
                                    <label for="chb-5"><span class="title">بنز</span><span>24</span></label>
                                </li>
                                <li>
                                    <input type="checkbox" id="chb-6">
                                    <label for="chb-6"><span class="title">بی ام و</span><span>35</span></label>
                                </li>
                                <li>
                                    <input type="checkbox" id="chb-1" checked>
                                    <label for="chb-1"><span class="title">آئودی</span><span>74</span></label>
                                </li>
                                <li>
                                    <input type="checkbox" id="chb-2">
                                    <label for="chb-2"><span class="title">اپل</span><span>14</span></label>
                                </li>
                                <li>
                                    <input type="checkbox" id="chb-3">
                                    <label for="chb-3"><span class="title">اسمارت</span><span>20</span></label>
                                </li>
                                <li>
                                    <input type="checkbox" id="chb-4">
                                    <label for="chb-4"><span class="title">ام وی ام</span><span>56</span></label>
                                </li>
                                <li>
                                    <input type="checkbox" id="chb-5">
                                    <label for="chb-5"><span class="title">بنز</span><span>24</span></label>
                                </li>
                                <li>
                                    <input type="checkbox" id="chb-6">
                                    <label for="chb-6"><span class="title">بی ام و</span><span>35</span></label>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
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