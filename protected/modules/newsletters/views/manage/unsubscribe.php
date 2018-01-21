<?php
/* @var $flag bool */

$this->pageTitle= Yii::app()->name . ' - انصزاف از خبرنامه';

if($flag):
    ?>
    <div class="alert alert-success message">
        <p>انصراف از اشتراک خبرنامه با موفقیت انجام شد.</p>
    </div>
    <?php
else:
    ?>
    <div class="alert alert-warning message">
        <p>انصراف از اشتراک خبرنامه با مشکل مواجه شد! لطفا مجدد تلاش کنید.</p>
    </div>
    <?php
endif;
