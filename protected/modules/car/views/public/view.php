<?php
/* @var $this CarPublicController */
/* @var $car Cars */
/* @var $similar Cars[] */
// load owl carousel plugin
$cs = Yii::app()->clientScript;
$baseUrl = Yii::app()->theme->baseUrl;
$cs->registerCssFile($baseUrl.'/css/owl.carousel.css');
$cs->registerCssFile($baseUrl.'/css/owl.theme.default.min.css');
$cs->registerScriptFile($baseUrl.'/js/owl.carousel.min.js', CClientScript::POS_END);

// jquery mobile
//$cs->registerCssFile($baseUrl.'/css/jquery.mobile.structure-1.4.5.min.css');
//$cs->registerScriptFile($baseUrl.'/js/jquery.mobile-1.4.5.min.js', CClientScript::POS_HEAD);

$breadcrumbs= [
	$car->brand->title => array('/car/brand/'.$car->brand->slug),
	$car->model->title => array('/car/brand/'.$car->brand->slug.'?model='.$car->model->slug),
	$car->creation_date,
//	$car->creation_date => array('/car/brand/'.$car->brand->slug.'/'.$car->model->slug.'/'.$car->creation_date),
	'جزییات'
];

$brand = $car->brand;
$model = $car->model;
$images = $car->carImages;

$imagePath = Yii::getPathOfAlias('webroot').DIRECTORY_SEPARATOR.$this->imagePath.DIRECTORY_SEPARATOR;
$imageUrl = Yii::app()->getBaseUrl(true).'/'.$this->imagePath.'/';

$parked = UserParking::model()->findByAttributes(['user_id' => $car->user_id, 'car_id' => $car->id])?true:false;
?>
<div class="page-header view-page">
	<div class="top">
		<div class="center-box">
				<img src="<?= Yii::app()->baseUrl . '/uploads/brands/' . $brand->logo;?>" class="brand-logo">
				<?php if(isset($model)):?>
					<h2 class="brand-name"><?= $brand->title?><span> | <?= $model->title?></span><small><b><?= strtoupper(str_replace('-', ' ', $brand->slug))?></b> | <?= str_replace('-', ' ', $model->slug)?></small></h2>
				<?php else:?>
					<h2 class="brand-name"><?= $brand->title?><small><b><?= strtoupper(str_replace('-', ' ', $brand->slug))?></b></small></h2>
				<?php endif;?>
		</div>
	</div>
	<div class="bottom overflow-fix">
		<?php $this->widget('zii.widgets.CBreadcrumbs', array(
			'links'=>$breadcrumbs,
			'homeLink' => '<li class="breadcrumb-item">'.CHtml::link(Yii::app()->name, Yii::app()->homeUrl).'</li>',
			'htmlOptions'=>array('class'=>'breadcrumb pull-right'),
			'tagName' => 'ul',
			'activeLinkTemplate' => '<li class="breadcrumb-item"><a href="{url}">{label}</a></li>',
			'inactiveLinkTemplate' => '<li class="breadcrumb-item"><span>{label}</span></li>',
			'separator' => ''
		)); ?>
		<div class="pull-left page-info"><?= $car->getTitle(false)?> برای فروش در <?= $car->state->name ?></div>
	</div>
</div>
<div class="content-box view-page-box" data-enhance="false">
	<div class="center-box">
		<div class="row advertise-info-box">
			<a href="#" class="call-btn floating-button left" data-title="تماس" data-url="<?= $this->createUrl('/car/public/json') ?>" data-hash="<?= base64_encode($car->id) ?>"></a>
			<div class="col-lg-5 col-md-5 col-sm-12 col-xs-12">
				<div class="image-container">
					<div class="hidden-sm hidden-xs">
						<div class="main-image-container">
							<?php
							if($car->mainImage && $car->mainImage->filename && is_file($imagePath.$car->mainImage->filename)):
								?>
								<img src="<?= $imageUrl.$car->mainImage->filename ?>" alt="<?= $car->getTitle(false)?>">
								<?php
							else:
								?>
								<div class="no-image"></div>
								<?php
							endif;
							?>
						</div>
						<div class="is-carousel" data-margin="10" data-dots="1" data-nav="0" data-mouse-drag="1" data-responsive='{"1920":{"items":5},"1200":{"items":4},"992":{"items":3},"768":{"items":3},"480":{"items":2},"0":{"items":1}}'>
							<?php
							foreach($images as $image):
								if($image && $image->filename && is_file($imagePath.$this->thumbPath.DIRECTORY_SEPARATOR.$image->filename)):
									?>
									<a href="#" class="image-slider-item">
										<img src="<?= $imageUrl.$this->thumbPath.DIRECTORY_SEPARATOR.$image->filename ?>"
											 data-origin="<?= $imageUrl.$image->filename ?>"
											 alt="<?= $car->getTitle(false)?>">
									</a>
									<?php
								endif;
							endforeach;
							?>
						</div>
					</div>
					<div class="mobile-view hidden-lg hidden-md">
						<?php
						if($images):
						?>
							<div class="main-image-container is-carousel" data-margin="0" data-dots="1" data-nav="0" data-mouse-drag="1" data-items="1">
								<?php
								foreach($images as $image):
									if($image && $image->filename && is_file($imagePath.$image->filename)):
										?>
										<img src="<?= $imageUrl.$image->filename ?>" alt="<?= $car->getTitle(false)?>">
										<?php
									else:
										?>
										<div class="no-image"></div>
										<?php
									endif;
								endforeach;
								?>
							</div>
						<?php
						else:
						?>
							<div class="no-image"></div>
						<?php
						endif;
						?>
					</div>
				</div>
			</div>
			<div class="col-lg-7 col-md-7 col-sm-12 col-xs-12 car-info">
                <div class="row col-lg-7 col-md-7 col-sm-7 col-xs-12">
                    <div class="alert alert-success view-alert hidden">
                        <p>
                            <span>خودرو با موفقیت از پارکینگ <شما></شما> خارج شد.</span>
                            <button type="button" class="close" data-dismiss="alert">&times;</button>
                        </p>
                    </div>
                </div>
                <div class="clearfix"></div>
				<?php
				if(!Yii::app()->user->isGuest && Yii::app()->user->type == 'user'):
					echo CHtml::ajaxLink('P<span>افزودن این خودرو به پارکینگ خود</span><span>حذف این خودرو از پارکینگ</span>',array('/car/public/authJson'),array(
						'type' => 'POST',
						'dataType' => 'JSON',
						'data' => array('method' => 'park','hash'=>base64_encode($car->id)),
						'beforeSend' => 'js: function(data){
                            $(".view-alert").addClass("hidden").removeClass("alert-success alert-warning").find("span").text("");
                        }',
						'success' => 'js: function(data){
                            if(data.status){
                                if($(".add-to-park").hasClass("parked"))
                                    $(".add-to-park").removeClass("parked");
                                else
                                    $(".add-to-park").addClass("parked");
                                $(".view-alert").addClass("alert-success").find("span").text(data.message);
                            }
                            else{
                                $(".view-alert").addClass("alert-warning").find("span").text(data.message); 
                            }   
                            $(".view-alert").removeClass("hidden");
                        }'
					),array('class' => 'add-to-park'.($parked?' parked':'')));
				else:
					?>
					<a href="#" class="add-to-park" data-toggle="modal" data-target="#login-modal">P<span>افزودن این خودرو به پارکینگ خود</span><span>حذف این خودرو از پارکینگ</span></a>
					<?php
				endif;
				?>
				<span class="hidden-lg hidden-md hidden-sm report-mobile">
					<a href="#" data-toggle="modal" data-target="#report-modal"><i class="icon icon-flag-alt"></i></a>
				</span>
				<div class="clearfix"></div>
				<h2 class="title"><?= $car->getTitle(false)?>
					<small class="hidden-xs">
						<a href="#" data-toggle="modal" data-target="#report-modal"><i class="icon icon-flag-alt"></i> گزارش</a>
					</small>
				</h2>
				<div class="features">
                    <?php
                    if($car->purchase_type_id == Cars::PURCHASE_TYPE_INSTALMENT):
                        ?>
                        <div class="feature-item">
                            <span class="name">پیش پرداخت</span>
                            <span class="value"><?= Controller::normalizeNumber($car->getPurchaseDetail('downPayment')) ?></span>
                        </div>
                        <?php if($car->getPurchaseDetail('downPaymentSecondary')): ?>
                            <div class="feature-item">
                                <span class="name">پیش پرداخت دوم</span>
                                <span class="value"><?= Controller::normalizeNumber($car->getPurchaseDetail('downPaymentSecondary')) ?></span>
                            </div>
                        <?php endif; ?>
                        <div class="feature-item">
                            <span class="name">تعداد اقساط</span>
                            <span class="value"><?= Controller::normalizeNumber($car->getPurchaseDetail('numberOfInstallment'),false,true,'قسط') ?></span>
                        </div>
                        <div class="feature-item">
                            <span class="name">مبلغ هر قسط</span>
                            <span class="value"><?= Controller::normalizeNumber($car->getPurchaseDetail('monthlyPayment')) ?></span>
                        </div>
                        <div class="feature-item">
                            <span class="name">موعد پرداخت</span>
                            <span class="value"><?= Controller::normalizeNumber($car->getPurchaseDetail('numberOfMonth'),false,true,'ماه یکبار') ?></span>
                        </div>
                        <?php
                    endif;
                    ?>
					<div class="feature-item">
						<span class="name">زمان ثبت</span>
						<span class="value"><?= JalaliDate::differenceTime($car->update_date) ?></span>
					</div>
                    <div class="feature-item">
                        <span class="name">وضعیت خودرو</span>
                        <span class="value"><?= $car->carType->title ?></span>
                    </div>
					<div class="feature-item">
						<span class="name">کارکرد</span>
						<span class="value"><?= (double)$car->distance?Controller::parseNumbers(number_format($car->distance)):$car->distance?> کیلومتر</span>
					</div>
					<div class="feature-item">
						<span class="name">گیربکس</span>
						<span class="value"><?= $car->gearbox->title ?></span>
					</div>
					<div class="feature-item">
						<span class="name">سوخت</span>
						<span class="value"><?= $car->fuel->title ?></span>
					</div>
					<div class="feature-item">
						<span class="name">بدنه</span>
						<span class="value"><?= $car->bodyState->title ?></span>
					</div>
					<div class="feature-item">
						<span class="name">رنگ</span>
						<span class="value"><?= $car->bodyColor->title ?> / داخل <?= $car->roomColor->title ?></span>
					</div>
					<div class="feature-item">
						<span class="name">پلاک</span>
						<span class="value"><?= $car->plateType->title ?></span>
					</div>
					<div class="feature-item">
						<span class="name">استان / شهر</span>
						<span class="value"><?= $car->state->name?> / <?= $car->city->name ?></span>
					</div>
					<div class="feature-item">
						<span class="name">بازدید</span>
						<span class="value"><?= $car->visit_district ?></span>
					</div>
					<div class="feature-item">
						<span class="name">تلفن</span>
						<span class="value"><div class="ltr hidden-num" id="phone-number"><?= $car->getSecureMobile() ?></div><a href="#" id="show-full-phone" data-url="<?= $this->createUrl('/car/public/json') ?>" data-hash="<?= base64_encode($car->id) ?>">[نمایش کامل]</a></span>
					</div>
					<div class="feature-item last">
						<span class="name"><i class="police-hat-icon"></i></span>
						<span class="value">پیش از انجام معامله و پرداخت هرگونه وجه از صحت خودرو اطمینان حاصل نمایید.</span>
						<div class="price"><?php if($car->purchase_type_id == Cars::PURCHASE_TYPE_INSTALMENT) echo 'قیمت نهایی '; ?><?= $car->getPrice() ?></div>
					</div>
				</div>
				<div class="text"><?= $car->description ?></div>
			</div>
		</div>
	</div>
	<?php
	if($similar):
	?>
	<div class="similar-box">
		<div class="center-box">
			<div class="title">مواردی که شبیه این آگهی هستند</div>
			<div class="items is-carousel" data-margin="0" data-dots="1" data-nav="1" data-mouse-drag="1" data-responsive='{"1920":{"items":5},"1200":{"items":5},"992":{"items":4},"768":{"items":3},"600":{"items":3},"480":{"items":2},"0":{"items":1}}'>
                <?php
                foreach($similar as $item):
                    ?>
                    <div class="item">
                        <a href="<?= $item->getViewUrl() ?>">
                            <div class="image-container">
								<?php
								if($item->mainImage && is_file($imagePath.$this->thumbPath.DIRECTORY_SEPARATOR.$item->mainImage->filename)):
									?>
									<img src="<?= $imageUrl.$this->thumbPath.DIRECTORY_SEPARATOR.$item->mainImage->filename ?>" alt="<?= $item->getTitle(false)?>">
									<?php
								else:
									?>
									<div class="no-image"></div>
									<?php
								endif;
								?>
                            </div>
                            <div class="info-container">
                                <h4><?= $item->getTitle(false) ?></h4>
                                <div class="text"><?= (double)$item->distance?Controller::parseNumbers(number_format($item->distance)):$item->distance ?> کیلومتر - <?= $item->gearbox->title ?> - <?= $item->fuel->title ?> - <?= $item->bodyState->title ?> - <?= $item->bodyColor->title ?> - <?= $item->state->name ?> - <?= $item->city->name ?></div>
                                <div class="price"><?= $item->getPrice() ?></div>
                            </div>
                        </a>
                    </div>
                    <?php
                endforeach;
                ?>
			</div>
		</div>
	</div>
		<?php
	endif;
	?>
</div>

<div id="report-modal" class="modal fade" data-enhance="false" role="nojs">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<h3>
					گزارش اشکال در آگهی
					<button type="button" class="close" data-dismiss="modal">&times;</button>
				</h3>
			</div>
			<div class="modal-body">
				<?php
				$report = new Reports();
				$report->car_id = $car->id;
				$this->renderPartial('_report_car',['model' => $report])
				?>
			</div>
		</div>
	</div>
</div>

<?php
$cs->registerScript('slider-js','
if($(window).width() <= 768){
	var sh;
	sh = $(window).width() * 300 / 450;
	$(".main-image-container").css({height:sh});
//	$(".main-image-container img").css({height:sh});
}
$(window).resize(function(){
	if($(window).width() <= 768){
		var sh;
		sh = $(window).width() * 300 / 450;
		$(".main-image-container").css({height:sh});
	//	$(".main-image-container img").css({height:sh});
	}
});

var phone=null;
if(!phone){
	$.ajax({
		url: $(".call-btn").data("url"),
		type: "POST",
		data: {method: "getPhone", hash: $(".call-btn").data("hash")},
		dataType: "JSON",
		success: function (data) {
			if (data.status){
				phone = data.phone;
				$(".call-btn").attr("href", "tel:"+phone);
			}
		}
	});
}
//$("body").on("click", ".call-btn", function(e){
//	
//	$(".call-btn").click();
//});
', CClientScript::POS_READY);
