<?php
/* @var $this UsersPublicController */
/* @var $plans Plans[] */
/* @var $user Users */
$this->breadcrumbs =[
    'داشبورد' => array('/dashboard'),
    'تغییر مشخصات' => array('/profile'),
    'کلمه عبور' => array('/changePassword'),
];
?>

<div class="content-box white-bg">
    <div class="center-box plans-page">
        <h4>ارتقای حساب کاربری</h4>
        <div class="plans">
            <?php foreach($plans as $plan): ?>
                <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                    <div class="plan-box">
                        <h4><?= $plan->title ?></h4>
                        <p><?= $plan->price !=0 ?Controller::parseNumbers(number_format($plan->price)).'  تومان':'رایگان' ?></p>
                        <?php if($plan->price != 0 && $user->activePlan->plan_id !== $plan->id): ?>
                            <a class="btn btn-primary btn-sm" href="<?= $this->createUrl('/buyPlan/'.$plan->id) ?>">انتخاب عضویت</a>
                        <?endif;?>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</div>
