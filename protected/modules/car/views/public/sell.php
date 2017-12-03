<?php
/* @var $this CarManageController */
/* @var $model Cars */
/* @var $form CActiveForm */
/* @var $images UploadedFiles|[] */

$this->breadcrumbs = array(
	'فروش خودرو'
);
?>
<div class="content-box white-bg">
	<div class="center-box">
		<div class="row">
            <?php $this->renderPartial('_form', ['model' => $model, 'images' => $images]);  ?>
		</div>
	</div>
</div>