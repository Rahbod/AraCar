<?php
/* @var $this UsersPublicController */
/* @var $plans Plans[] */
$this->breadcrumbs =[
    'داشبورد' => array('/dashboard'),
    'تغییر مشخصات' => array('/profile'),
    'کلمه عبور' => array('/changePassword'),
];
?>

<div class="content-box white-bg">
    <div class="center-box plans-page">
        <h4>ارتقای حساب کاربری</h4>
        <?php foreach($plans as $plan): ?>
            <div class="plan-box">
                <a href="<?= $this->createUrl('public/buyPlan/'.$plan->id) ?>">
                    <p><?php $plan->title ?></p>
                    <p><?php $plan->price ?></p>
                </a>
            </div>
        <?php endforeach; ?>
    </div>
</div>
