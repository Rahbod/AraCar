<?php
/* @var $this CarManageController */
/* @var $data Cars */
/* @var $form CActiveForm */
$imagePath = Yii::getPathOfAlias('webroot').'/uploads/cars/';
?>
<article>
    <div class="item-image">
        <?php
        if($data->carImages):
        ?>
            <img src="<?= Yii::app()->getBaseUrl(true).'/uploads/cars/'.$data->carImages[0]->filename ?>">
        <?php
        endif;
        ?>
    </div>
    <div class="item-content">
        <div class="row">
            <div class="col-lg-6 col-md-6 item-col">
                <div class="item-title text-blue "><?= $data->title ?></div>
                <div class="item-attribute"><?= Controller::parseNumbers(number_format($data->purchase_details)) ?> تومان</div>
                <div class="item-attribute"><?= Controller::parseNumbers(number_format($data->distance)) ?> کیلومتر</div>
                <div class="item-attribute"><?= $data->bodyState->title  ?></div>
            </div>
            <div class="col-lg-3 col-md-3 item-col">
                <div class="item-attribute">آرا دوست</div>
                <div class="item-attribute">به روزرسانی مجاز</div>
                <div class="item-attribute">تاریخ درج</div>
                <div class="item-attribute">تاریخ انقضا</div>
            </div>
            <div class="col-lg-3 col-md-3 item-col">
                <div class="item-attribute text-success"><b>فعال</b></div>
                <div class="item-attribute">1</div>
                <div class="item-attribute text-blue"><?= JalaliDate::date('Y/m/d', $data->create_date) ?></div>
                <div class="item-attribute text-blue"><?= $data->expire_date?JalaliDate::date('Y/m/d', $data->expire_date):'-' ?></div>
            </div>
        </div>
    </div>
    <div class="item-actions">
        <a href="#" class="btn btn-default">
            ارتقا خودرو
            <i class="addon-icon icon icon-bolt"></i>
        </a>
        <a href="<?= $this->createUrl('/car') ?>" class="btn btn-default">
            به روزرسانی
            <i class="addon-icon icon icon-refresh"></i>
        </a>
        <a href="#" class="btn btn-default">
            ویرایش خودرو
            <i class="addon-icon icon icon-edit"></i>
        </a>
        <a href="<?= $this->createUrl('/car/public/delete/'.$data->id) ?>" class="btn btn-default">
            حذف خودرو
            <i class="addon-icon icon icon-remove"></i>
        </a>
    </div>
</article>
