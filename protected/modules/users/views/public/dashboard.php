<?php
/* @var $this UsersPublicController */
/* @var $user Users */
/* @var $sells Cars */
$this->breadcrumbs =[
    'داشبورد' => array('/dashboard'),
    'تغییر مشخصات' => array('/profile'),
    'کلمه عبور' => array('/changePassword'),
];
?>

<div class="content-box white-bg">
    <div class="center-box">
        <ul class="nav nav-pills">
            <li class="active"><a class="btn btn-gray btn-wide" data-toggle="tab" href="#sell-tab">آگهی فروش</a></li>
            <li><a class="btn btn-gray btn-wide" data-toggle="tab" href="#parking-tab">پارکینگ</a></li>
<!--            <li><a class="btn btn-gray btn-wide" data-toggle="tab" href="#exchange-tab">معاوضه</a></li>-->
<!--            <li><a class="btn btn-gray btn-wide" data-toggle="tab" href="#">گوش به زنگ</a></li>-->
        </ul>
        <div class="tab-content panel-tabs">
            <div class="tab-pane fade active in" id="sell-tab">
                <div class="row">
                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                        <a type="button" class="btn btn-success btn-wide-2x" href="<?= $this->createUrl('/sell') ?>">
                            <i class="addon-icon icon icon-plus"></i>
                            درج آگهی جدید
                        </a>
                    </div>
                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                        <h5 class="text-blue pull-left">تعداد آگهی های مجاز 1</h5>
                    </div>
                </div>
                <?php $this->widget('zii.widgets.CListView', array(
                    'id'=>'brands-list',
                    'dataProvider'=>new CArrayDataProvider($sells),
                    'itemsCssClass'=>'advertise-panel-list',
                    'template' => '{items} {pager}',
                    'ajaxUpdate' => true,
                    'afterAjaxUpdate' => "function(id, data){
                        $('html, body').animate({
                            scrollTop: ($('#'+id).offset().top-130)
                        },1000,'easeOutCubic');
                    }",
                    'pager' => array(
                        'header' => '',
                        'firstPageLabel' => '<<',
                        'lastPageLabel' => '>>',
                        'prevPageLabel' => '<',
                        'nextPageLabel' => '>',
                        'cssFile' => false,
                        'htmlOptions' => array(
                            'class' => 'pagination pagination-sm',
                        ),
                    ),
                    'pagerCssClass' => 'blank',
                    'itemView' => 'car.views.public._item_panel_view'
                )); ?>
            </div>
            <div class="tab-pane fade" id="parking-tab">
                <div class="row">
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        <h5 class="text-blue pull-left">تعداد خودرو های پارکینگ <span id="count-parked"><?= $user->countParked ?></span></h5>
                    </div>
                </div>
                <div class="alert alert-success view-alert hidden">
                    <p>
                        <span>خودرو با موفقیت از پارکینگ شما خارج شد.</span>
                        <button type="button" class="close" data-dismiss="alert">&times;</button>
                    </p>
                </div>
                <?php $this->widget('zii.widgets.CListView', array(
                    'id'=>'brands-list',
                    'dataProvider'=>new CArrayDataProvider($user->parked),
                    'itemsCssClass'=>'advertise-panel-list',
                    'template' => '{items} {pager}',
                    'ajaxUpdate' => true,
                    'afterAjaxUpdate' => "function(id, data){
                        $('html, body').animate({
                            scrollTop: ($('#'+id).offset().top-130)
                        },1000,'easeOutCubic');
                    }",
                    'pager' => array(
                        'header' => '',
                        'firstPageLabel' => '<<',
                        'lastPageLabel' => '>>',
                        'prevPageLabel' => '<',
                        'nextPageLabel' => '>',
                        'cssFile' => false,
                        'htmlOptions' => array(
                            'class' => 'pagination pagination-sm',
                        ),
                    ),
                    'pagerCssClass' => 'blank',
                    'itemView' => 'car.views.public._item_parking_view'
                )); ?>
            </div>
<!--            <div class="tab-pane fade" id="exchange-tab">-->
<!--                <div class="row">-->
<!--                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">-->
<!--                        <button type="button" class="btn btn-success btn-wide-2x">-->
<!--                            <i class="addon-icon icon icon-plus"></i>-->
<!--                            درج آگهی جدید-->
<!--                        </button>-->
<!--                    </div>-->
<!--                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">-->
<!--                        <h5 class="text-blue pull-left">تعداد آگهی های مجاز 1</h5>-->
<!--                    </div>-->
<!--                </div>-->
<!--                <div class="advertise-panel-list">-->
<!--                    <article>-->
<!--                        <div class="item-image">-->
<!--                            <img src="uploads/advertising/11.jpg">-->
<!--                        </div>-->
<!--                        <div class="item-content">-->
<!--                            <div class="row">-->
<!--                                <div class="col-lg-6 col-md-6 item-col">-->
<!--                                    <div class="item-title text-blue ">1393 | پژوپارس دوگانه سوز</div>-->
<!--                                    <div class="item-attribute">30,000,000 تومان</div>-->
<!--                                    <div class="item-attribute">69,000 کیلومتر</div>-->
<!--                                    <div class="item-attribute">سفید گلگیر تعویض</div>-->
<!--                                </div>-->
<!--                                <div class="col-lg-3 col-md-3 item-col">-->
<!--                                    <div class="item-attribute">تیپ 1</div>-->
<!--                                    <div class="item-attribute">به روزرسانی مجاز</div>-->
<!--                                    <div class="item-attribute">تاریخ درج</div>-->
<!--                                    <div class="item-attribute">تاریخ انقضا</div>-->
<!--                                </div>-->
<!--                                <div class="col-lg-3 col-md-3 item-col">-->
<!--                                    <div class="item-attribute text-success"><b>فعال</b></div>-->
<!--                                    <div class="item-attribute">1</div>-->
<!--                                    <div class="item-attribute text-blue">1396/06/03</div>-->
<!--                                    <div class="item-attribute text-blue">1396/07/03</div>-->
<!--                                </div>-->
<!--                            </div>-->
<!--                        </div>-->
<!--                        <div class="item-actions">-->
<!--                            <a href="#" class="btn btn-default">-->
<!--                                ارتقا آگهی-->
<!--                                <i class="addon-icon icon icon-bolt"></i>-->
<!--                            </a>-->
<!--                            <a href="#" class="btn btn-default">-->
<!--                                به روزرسانی-->
<!--                                <i class="addon-icon icon icon-refresh"></i>-->
<!--                            </a>-->
<!--                            <a href="#" class="btn btn-default">-->
<!--                                ویرایش آگهی-->
<!--                                <i class="addon-icon icon icon-edit"></i>-->
<!--                            </a>-->
<!--                            <a href="#" class="btn btn-default">-->
<!--                                حذف آگهی-->
<!--                                <i class="addon-icon icon icon-remove"></i>-->
<!--                            </a>-->
<!--                        </div>-->
<!--                    </article>-->
<!--                </div>-->
<!--            </div>-->
        </div>
    </div>
</div>
