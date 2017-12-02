<?php
/* @var $this UsersPlansController */
/* @var $model Plans */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'plans-form',
	'enableAjaxValidation'=>true,
)); ?>
    <?php $this->renderPartial('//partial-views/_flashMessage');?>
    <p class="note">فیلد های دارای <span class="required">*</span> الزامی هستند .</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="form-group">
		<?php echo $form->labelEx($model,'title' ,array('class'=>'control-label')); ?>
		<?php echo $form->textField($model,'title',array('size'=>60,'maxlength'=>255, 'class' => 'form-control')); ?>
		<?php echo $form->error($model,'title'); ?>
	</div>

    <?php if($model->id != 1):?>
        <div class="form-group">
            <?php echo $form->labelEx($model,'price' ,array('class'=>'control-label')); ?>
            <div class="input-group">
                <span class="input-group-addon">تومان</span>
                <?php echo $form->textField($model,'price',array('class' => 'form-control')); ?>
            </div>
            <?php echo $form->error($model,'price'); ?>
        </div>
    <?php else:?>
        <div class="form-group">
            <?php echo $form->labelEx($model,'price' ,array('class'=>'control-label')); ?>
            رایگان
        </div>
    <?php endif;?>

	<div class="form-group">
		<?php echo $form->labelEx($model,'adsCount' ,array('class'=>'control-label')); ?>
		<?php echo $form->textField($model,'adsCount',array('maxlength'=>4, 'class' => 'form-control')); ?>
		<?php echo $form->error($model,'adsCount'); ?>
	</div>

    <div class="form-group">
		<?php echo $form->labelEx($model,'adsDuration' ,array('class'=>'control-label')); ?>
        <div class="input-group">
            <span class="input-group-addon">روز</span>
            <?php echo $form->textField($model,'adsDuration',array('maxlength'=>4, 'class' => 'form-control')); ?>
        </div>
		<?php echo $form->error($model,'adsDuration'); ?>
	</div>

    <div class="form-group">
		<?php echo $form->labelEx($model,'adsImageCount' ,array('class'=>'control-label')); ?>
		<?php echo $form->textField($model,'adsImageCount',array('maxlength'=>4, 'class' => 'form-control')); ?>
		<?php echo $form->error($model,'adsImageCount'); ?>
	</div>

	<div class="form-group">
		<?php echo $form->labelEx($model,'status' ,array('class'=>'control-label')); ?>
		<?php echo $form->dropDownList($model,'status',Plans::$statusLabels, array('class' => 'form-control')); ?>
		<?php echo $form->error($model,'status'); ?>
	</div>

	<div class="form-group buttons">
        <?php echo CHtml::submitButton($model->isNewRecord ? 'افزودن' : 'ویرایش', array('class'=>'btn btn-success'));?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->