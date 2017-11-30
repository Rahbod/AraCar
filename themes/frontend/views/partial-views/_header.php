<?php
/**
 * @var $class string
 */
?>
<div class="header <?= $class?:'' ?>">
    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
        <div class="row">
            <ul class="nav navbar-nav">
                <li class="login-link"><a href="#">ثبت نام / ورود</a></li>
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
        <div class="logo-box">
            <img src="<?= Yii::app()->theme->baseUrl ?>images/logo.png">
        </div>
        <a href="#" class="new-link"></a>
    </div>
</div>