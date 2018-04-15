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
    <a href="<?= $this->createUrl('/dealership/'.$url) ?>" title="<?= $data->dealership_name ?>">
        <div class="listdata">
            <div class="detail">
                <h3>
                    <span><?= $data->dealership_name ?></span>
                    <span class="dealer-ad-details hidden-xs">
                            <span><?= Controller::normalizeNumber($data->countCars, true, true, 'خودرو') ?></span>
                    </span>
                    <small style="font-size:11px;font-weight: normal !important;padding-right:5px;">[<?= JalaliDate::differenceTime($data->create_date) ?>]</small>
                </h3>
                <p class="address hidden-xs">
                    <?= strip_tags($data->userDetails->address) ?>
                </p>
            </div>
            <div class="dealer-ad-details-fix hidden-lg hidden-md hidden-sm">
                <p style="float: right;">
                    <span><?= Controller::normalizeNumber($data->countCars, true, true, 'خودرو') ?></span>
                </p>
            </div>
            <div class="overview dealer-phone">
                <span class="tn ltr">
                    <?= Controller::normalizeNumber($data->phone, false, true, '') ?>
                </span>
            </div>
        </div>
    </a>
</li>
