<?php
/* @var $this CarManageController */
/* @var $model Cars */
/* @var $user Users */
/* @var $form CActiveForm */
/* @var $images UploadedFiles|[] */
$this->breadcrumbs = array(
	'گوش به زنگ'
);
?>
<div class="content-box white-bg">
	<div class="center-box">
		<div class="row">
			<?php
			if($user->countAlerts == 0):
				$this->renderPartial('_alert_form', ['model' => $model]);
			else:
				$this->breadcrumbs = array(
					'داشبورد' => array('/dashboard')
				);
				?>
				<div class="sell-not-allow silver">
					<div class="inner-flex">
						<h3>با عرض پوزش شما تنها مجاز به ثبت یک گوش به زنگ هستید.</h3><br><br>
						<a class="btn btn-info" href="<?= $this->createUrl('/dashboard#alerts-tab') ?>">بازگشت</a>
<!--						<p>تعداد آگهی مجاز در عضویت --><?//= $user->activePlan->plan->title ?><!-- --><?//= Controller::parseNumbers($user->getActivePlanRule('adsCount'))?><!-- آگهی می باشد.</p>-->
<!--						--><?php
//						if($user->activePlan->plan_id !== 4):
//							?>
<!--							<p>در صورت تمایل میتوانید عضویت خود را ارتقا دهید.</p>-->
<!--							<a class="btn btn-success" href="--><?//= $this->createUrl('/upgradePlan') ?><!--">ارتقای عضویت</a>-->
<!--							--><?php
//						endif
//						?>
					</div>
				</div>
			<?php
			endif;
			?>
		</div>
	</div>
</div>