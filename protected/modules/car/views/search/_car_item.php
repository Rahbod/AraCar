<?php
/* @var $data Cars */
$imagePath = Yii::getPathOfAlias('webroot').'/uploads/cars/';
global $counter;
?>
<div class="advertising-item<?= $data->show_in_top?' special':'' ?><?= $data->purchase_type_id == Cars::PURCHASE_TYPE_INSTALMENT?' instalment-item':'' ?>">
    <a href="<?php echo $data->getViewUrl(); ?>" class="link"></a>
    <div class="image-container">
        <?php
        if($data->mainImage && file_exists($imagePath.'thumbs/180x140/'.$data->mainImage->filename)):
            ?>
            <img src="<?= Yii::app()->getBaseUrl(true).'/uploads/cars/thumbs/180x140/'.$data->mainImage->filename ?>">
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
<!--        --><?php //if($data->user->role_id == 2):?>
<!--            <span class="dealership-box">نمایشگاه</span>-->
<!--        --><?php //endif;?>
        <h2>
            <span class="hidden-xs"><?= $data->getTitle()?> | <span class="time"><?= JalaliDate::differenceTime($data->update_date)?></span></span>
            <span class="hidden-lg hidden-md hidden-sm"><?= $data->getRawTitle()?></span>
        </h2>
        <div class="public-info">
            <div class="last-row hidden-lg hidden-md- hidden-sm"><span class="time"><?= JalaliDate::differenceTime($data->update_date)?></span></div>
            <span class="place"><?= $data->city->name?> / <?= $data->visit_district?></span>
            <div class="last-row">کارکرد <?= $data->distance == 0 ? "صفر کیلومتر" : Controller::normalizeNumber($data->distance,true, true,'کیلومتر')?></div>
            <div class="desc hidden-xs"><?= strip_tags($data->description)?></div>
            <span class="pull-left price">
                <?php if($data->purchase_type_id == Cars::PURCHASE_TYPE_INSTALMENT):
                    $eachPay = $data->getPurchaseDetail('monthlyPayment');
                    $perTime = (int)$data->getPurchaseDetail('numberOfMonth');
                    $monthly = $eachPay/$perTime;
                    ?>
                    <span>پیش پرداخت <?= Controller::normalizeNumber($data->getPurchaseDetail('downPayment')) ?></span>
                    <span>ماهیانه <?= Controller::normalizeNumber($monthly) ?></span>
                <?php endif;?>
                <span><?php if($data->purchase_type_id == Cars::PURCHASE_TYPE_INSTALMENT) echo 'قیمت تمام شده '?><?= $data->getPrice() ?></span>
            </span>
        </div>
        <div class="full-info">
            <div class="info-item">کارکرد<span class="pull-left"><?= $data->distance?> کیلومتر</span></div>
            <div class="info-item">سوخت<span class="pull-left"><?= $data->fuel->title?></span></div>
            <div class="info-item">رنگ<span class="pull-left"><?= $data->bodyColor->title?></span></div>
            <div class="clearfix"></div>
            <div class="info-item">گیربکس<span class="pull-left"><?= $data->gearbox->title?></span></div>
            <div class="info-item">بدنه<span class="pull-left"><?= $data->bodyState->title?></span></div>
            <div class="info-item">استان<span class="pull-left"><?= $data->state->name?></span></div>
            <span class="pull-left price"><span><?= $data->getPrice() ?></span></span>
        </div>
    </div>
</div>

<!--Render Advertise-->
<?php
if($counter === 3):
    $this->renderPartial('advertises.views.manage._advertise_item', [
        'placement' => Advertises::PLACE_CAR_LIST_BETWEEN_CARS,
        'cssClass' => 'advertise-between-cars'
    ]);
endif;
$counter++;
?>