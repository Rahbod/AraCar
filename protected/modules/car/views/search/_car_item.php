<?php
/* @var $data Cars */
$imagePath = Yii::getPathOfAlias('webroot').'/uploads/cars/';
?>
<div class="advertising-item<?= $data->show_in_top?' special':'' ?>">
    <a href="<?php echo $data->getViewUrl(); ?>" class="link"></a>
    <div class="image-container">
        <?php
        if($data->mainImage && file_exists($imagePath.$data->mainImage->filename)):
            ?>
            <img src="<?= Yii::app()->getBaseUrl(true).'/uploads/cars/'.$data->mainImage->filename ?>">
            <?php
        else:
            ?>
            <div class="no-image"></div>
            <?php
        endif;
        ?>
    </div>
    <div class="info-container">
        <?php if($data->purchase_type_id == Cars::PURCHASE_TYPE_INSTALMENT):?>
            <span class="instalment-box">اقساطی</span>
        <?php endif;?>
        <h2><?= $data->getTitle()?> | <span class="time"><?= JalaliDate::differenceTime($data->update_date)?></span></h2>
        <div class="public-info">
            <span class="place"><?= $data->city->name?>/ <?= $data->visit_district?></span>
            <div class="desc"><?= strip_tags($data->description)?></div>
            <div class="last-row">
                <span>کارکرد <?= $data->distance == 0 ? "صفر کیلومتر" : Controller::normalizeNumber($data->distance,true, true,'کیلومتر')?></span>
                <span class="pull-left price"><?php if($data->purchase_type_id == Cars::PURCHASE_TYPE_INSTALMENT) echo 'قیمت تمام شده '?><?= $data->getPrice() ?></span>
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
            <span class="pull-left price"><?= $data->getPrice() ?></span>
        </div>
    </div>
</div>
