<?php
/* @var $this NewslettersManageController */
/* @var $model NewsLetterMessages */

$this->breadcrumbs =array(
    'خبرنامه',
    'ارسال خبرنامه'
);

$this->menu = array(
    array('label' => 'تاریخچه خبرنامه ها' , 'url' => array('messages')),
);
?>
<h1>ارسال خبرنامه</h1>

<?php $this->renderPartial('//partial-views/_flashMessage') ?>
<?php $form=$this->beginWidget('CActiveForm', array(
    'id'=>'news-letters-form',
    'enableAjaxValidation'=>false,
)); ?>
    <div class="row">
        <?php echo $form->labelEx($model,'title'); ?>
        <?php echo $form->textField($model,'title'); ?>
        <?php echo $form->error($model,'title'); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model,'body'); ?>
        <?php
        $this->widget("ext.ckeditor.CKEditor",array(
            'model' => $model,
            'attribute' => 'body'
        ));
        ?>
        <?php echo $form->error($model,'body'); ?>
    </div>

    <div class="row buttons">
        <?php echo CHtml::submitButton('ارسال', array('class' => 'btn btn-success')); ?>
    </div>

<?php $this->endWidget(); ?>