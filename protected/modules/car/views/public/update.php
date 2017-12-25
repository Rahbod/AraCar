<?php
/* @var $this CarManageController */
/* @var $model Cars */
/* @var $user Users */
/* @var $form CActiveForm */
/* @var $images UploadedFiles|[] */

$this->breadcrumbs = array(
	'داشبورد' => array('/dashboard'),
	'ویرایش خودرو'
);

?>
<div class="content-box white-bg">
	<div class="center-box">
		<div class="row">
			<?php
			$this->renderPartial('_form', ['model' => $model, 'images' => $images, 'adImageCount' => $adImageCount]);
			?>
		</div>
	</div>
</div>