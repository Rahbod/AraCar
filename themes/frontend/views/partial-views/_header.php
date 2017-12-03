<?php
/**
 * @var $this Controller
 */
?>

<div class="header<?= $this->layout == '//layouts/inner'?' inner-page':'' ?>">
    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
        <div class="row">
            <ul class="nav navbar-nav">
                <?php
                if(Yii::app()->user->isGuest || Yii::app()->user->type == 'admin'):
                ?>
                    <li class="login-link"><a href="#" data-toggle="modal" data-target="#login-modal">ثبت نام / ورود</a></li>
                <?php
                else:
                    ?>
                    <li class="login-link"><a href="#">یوسف مبشری</a></li>
                <?
                endif;
                ?>
                <li><a href="#">برند</a></li>
                <li><a href="#">شاسی</a></li>
                <li><a href="#">قیمت</a></li>
                <li><a href="#">موارد خاص</a></li>
                <li><a href="#">بررسی خودرو</a></li>
                <li><a href="#">قیمت صفر</a></li>
            </ul>
        </div>
    </div>
    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
        <a href="<?= Yii::app()->getBaseUrl(true) ?>">
            <div class="logo-box">
                <img src="<?= Yii::app()->theme->baseUrl.'/images/logo.png' ?>">
            </div>
        </a>
        <?php
        if(Yii::app()->user->isGuest || Yii::app()->user->type == 'admin'):
            ?>
            <a href="#" class="new-link" data-toggle="modal" data-target="#login-modal" data-title="ثبت آگهی جدید"></a>
            <?php
        else:
            ?>
            <a href="<?= Yii::app()->createUrl('/sell') ?>" class="new-link" data-placement="bottom" title="ثبت آگهی جدید"></a>
            <?
        endif;
        ?>
    </div>
</div>
