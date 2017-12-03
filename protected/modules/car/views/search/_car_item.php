<?php /* @var $data Cars */ ?>
<div class="advertising-item special">
    <div class="image-container">
        <img src="<?= Yii::app()->baseUrl . '/uploads/car/';?>">
    </div>
    <div class="info-container">
        <h2><?= $data->getTitle()?> | <span class="time"><?= JalaliDate::differenceTime($data->update_date)?></span></h2>
        <div class="public-info">
            <span class="place"><?= $data->city->name?>/ <?= $data->visit_district?></span>
            <div class="desc"><?= $data->description?></div>
            <div class="last-row">
                <span>کارکرد <?= $data->distance == 0 ? "صفر" : $data->distance?>کیلومتر</span>
                <span class="pull-left price">58/360/000 تومان</span>
            </div>
        </div>
        <div class="full-info">
            <div class="info-item">کارکرد<span class="pull-left"><?= $data->distance?> کیلومتر</span></div>
            <div class="info-item">سوخت<span class="pull-left"><?= $data->fuel->title?></span></div>
            <div class="info-item">رنگ<span class="pull-left"><?= $data->bodyColor->title?>/ داخل <?= $data->roomColor->title?></span></div>
            <div class="clearfix"></div>
            <div class="info-item">گیربکس<span class="pull-left"><?= $data->gearbox->title?></span></div>
            <div class="info-item">بدنه<span class="pull-left"><?= $data->bodyState->title?></span></div>
            <div class="info-item">استان<span class="pull-left"><?= $data->state->name?></span></div>
            <span class="pull-left price">58/360/000 تومان</span>
        </div>
    </div>
</div>
