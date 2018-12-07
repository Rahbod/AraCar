<?php
/* @var $this CarManageController */
/* @var $data Cars */
/* @var $form CActiveForm */
$imagePath = Yii::getPathOfAlias('webroot').'/uploads/cars/';
$adsUpdateCount = $data->getCarPlanRule('adsUpdateCount');
?>
<article>
    <div class="item-image">
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
    <div class="item-content">
        <div class="row">
            <div class="col-lg-6 col-md-4 col-sm-4 col-xs-4 item-col">
                <div class="item-title text-blue "><?= $data->title ?></div>
                <div class="item-attribute"><?= $data->getPrice() ?></div>
                <div class="item-attribute"><?= Controller::parseNumbers(number_format($data->distance)) ?> کیلومتر</div>
                <div class="item-attribute"><?= $data->bodyState->title  ?></div>
            </div>
            <div class="col-lg-3 col-md-4 col-sm-4 col-xs-4 item-col">
                <div class="item-attribute">عضویت: <?= $data->plan_title ?></div>
                <div class="item-attribute">به روزرسانی مجاز</div>
                <div class="item-attribute">تاریخ درج</div>
                <div class="item-attribute">تاریخ انقضا</div>
            </div>
            <div class="col-lg-3 col-md-4 col-sm-4 col-xs-4 item-col">
                <div class="item-attribute"><b class="text-<?php
                    if($data->status == Cars::STATUS_PENDING) echo 'warning';
                    if($data->status == Cars::STATUS_APPROVED) echo 'success';
                    if($data->status == Cars::STATUS_REFUSED) echo 'danger';
                    ?>"><?= $data->getStatusLabel() ?></b></div>
                <div class="item-attribute"><?= Controller::parseNumbers(number_format($adsUpdateCount - $data->update_count)) ?></div>
                <div class="item-attribute text-blue"><?= JalaliDate::date('Y/m/d', $data->create_date) ?></div>
                <div class="item-attribute text-blue"><?= $data->expire_date?JalaliDate::date('Y/m/d', $data->expire_date):'-' ?></div>
            </div>
        </div>
    </div>
    <div class="actions-icon-btn item-actions-trigger"><i class="actions-icon"></i></div>
    <div class="item-actions">
        <a href="<?php echo $data->getViewUrl(); ?>" class="btn btn-gray">
            <span>نمایش خودرو</span>
            <i class="addon-icon icon icon-search"></i>
        </a>
        <?php if($data->expire_date < time() && $adsUpdateCount - $data->update_count > 0): ?><a href="<?= $this->createUrl('/car/public/update/'.$data->id) ?>" class="btn btn-gray"><?php else: ?><a class="btn btn-gray" disabled="disabled" ><?php endif; ?>
                <span>به روزرسانی</span>
            <i class="addon-icon icon icon-refresh"></i>
        </a>
        <a href="<?= $this->createUrl('/car/public/edit/'.$data->id) ?>" class="btn btn-gray">
            <span>ویرایش خودرو</span>
            <i class="addon-icon icon icon-edit"></i>
        </a>
        <a onclick="if(!confirm('آیا از حذف این خودرو اطمینان دارید؟')) return false;" href="<?= $this->createUrl('/car/public/delete/'.$data->id) ?>" class="btn btn-gray">
            <span>حذف خودرو</span>
            <i class="addon-icon icon icon-remove"></i>
        </a>
    </div>
</article>
