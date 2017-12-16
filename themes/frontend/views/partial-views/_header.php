<?php
/* @var $this Controller */
/* @var $class string */
?>

<div class="header<?= $this->layout == '//layouts/inner' || $this->layout == '//layouts/panel'?' inner-page':'' ?>">
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
                    <li class="login-link"><a href="<?= $this->createUrl('/dashboard') ?>"><?= Yii::app()->user->first_name.' '.Yii::app()->user->last_name ?></a></li>
                <?
                endif;
                ?>
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">برند</a>
                    <div class="dropdown-menu">
                        <ul class="linear-menu">
                            <?php foreach($this->brands as $brand):?>
                                <li><a href="<?= $this->createUrl('/car/brand/' . $brand->slug)?>"><?= $brand->title?></a></li>
                            <?php endforeach;?>
                        </ul>
                    </div>
                </li>
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">شاسی</a>
                    <div class="dropdown-menu">
                        <ul class="linear-menu">
                            <?php foreach($this->chassis as $chassis):?>
                                <li><a href="<?= $this->createUrl('/car/search/all?body=' . str_replace(' ', '-', $chassis))?>"><?= $chassis?></a></li>
                            <?php endforeach;?>
                        </ul>
                    </div>
                </li>
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">قیمت</a>
                    <div class="dropdown-menu price-menu">
                        <ul class="linear-menu">
                            <!--<li><a href="--><?//= $this->createUrl('/car/search/all?price=0-5')?><!--">تا 5 میلیون تومان</a></li>-->
                            <?php foreach($this->prices as $price):?>
                                <li><a href="<?= $this->createUrl('/car/search/all?price=' . $price)?>"><?= "از ".implode(' تا ', explode('-', $price))." میلیون تومان"?></a></li>
                            <?php endforeach;?>
                            <li><a href="<?= $this->createUrl('/car/search/all?price=900-1000')?>">از 900 تا یک میلیارد تومان</a></li>
                            <li><a href="<?= $this->createUrl('/car/search/all?price=1000')?>">از یک میلیارد به بالا</a></li>
                        </ul>
                    </div>
                </li>
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">موارد خاص</a>
                    <div class="dropdown-menu special-menu">
                        <ul class="linear-menu">
                            <li><a href="<?= $this->createUrl('/car/search/all?plate=' . str_replace(' ', '-', 'منطقه آزاد'))?>">منطقه آزاد</a></li>
                            <li><a href="<?= $this->createUrl('/car/search/all?plate=' . str_replace(' ', '-', 'گذر موقت'))?>">گذر موقت</a></li>
                        </ul>
                    </div>
                </li>
                <li><a href="<?= $this->createUrl('/research') ?>">بررسی خودرو</a></li>
<!--                <li><a href="#">قیمت صفر</a></li>-->
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
