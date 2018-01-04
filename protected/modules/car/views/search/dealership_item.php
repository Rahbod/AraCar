<?php
/* @var $this CarPublicController */
/* @var $data Users */
$data->loadPropertyValues();
$imagePath = Yii::getPathOfAlias("webroot.uploads").'/users/';
$url = $data->id;
?>
<li class="dealer-item">

    <div class="photo">
        <a href="<?= $this->createUrl('/dealership/'.$url) ?>" title="<?= $data->dealership_name ?>">
            <?php
            if($data->avatar && file_exists($imagePath.$data->avatar)):
                ?>
                <img src="<?= Yii::app()->getBaseUrl(true).'/uploads/users/'.$data->avatar ?>" alt="<?= $data->dealership_name ?>">
                <?php
            else:
                ?>
                <div class="no-image"></div>
                <?php
            endif;
            ?>
        </a>
    </div>
    <div class="listdata">
        <div class="detail">
            <h3>
                <a href="<?= $this->createUrl('/dealership/'.$url) ?>" title="<?= $data->dealership_name ?>">
                    <span><?= $data->dealership_name ?></span>
                </a>
                <span class="dealer-ad-details visible-xs" style="width:100% !important;margin-bottom:2px; font-size:11px;">
                        <span><?= Controller::normalizeNumber($data->countCars, true, true, 'خودرو') ?></span>
                </span>
                <small style="font-size:11px;font-weight: normal !important;padding-right:5px;">[<?= JalaliDate::differenceTime($data->create_date) ?>]</small>
            </h3>
            <p class="address hidden-xs">
                <?= strip_tags($data->userDetails->address) ?>
            </p>
        </div>
        <div class="dealer-ad-details hidden-xs">
            <p style="float: left;">
                <span><?= Controller::normalizeNumber($data->countCars, true, true, 'خودرو') ?></span>
            </p>
        </div>
        <div class="overview">
            <span class="tn ltr">
                <?= Controller::normalizeNumber($data->phone, false, true, '') ?>
            </span>
        </div>
    </div>
</li>
