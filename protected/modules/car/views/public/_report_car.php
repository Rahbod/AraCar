<?php
/* @var $this AppsController */
/* @var $model Reports */
/* @var $form CActiveForm */
?>
<div id="report-container">
    <?php $this->renderPartial('//partial-views/_loading'); ?>
    <?php $form=$this->beginWidget('CActiveForm', array(
        'id'=>'car-report-form',
        'action' => $this->createUrl('/car/public/json'),
        'enableAjaxValidation'=>false,
        'enableClientValidation'=>true,
        'clientOptions' => array(
            'validateOnSubmit' => true,
            'afterValidate' => 'js:function(form ,data ,hasError){
                if(!hasError)
                {
                    var loading = $("#report-container .loading-container");
                    var url = form.attr("action");
                    $.ajax({
                        type: "POST",
                        url: url,
                        data: form.serialize(),
                        dataType: "json",
                        beforeSend: function () {
                            if(loading)
                                loading.show();
                            $(".view-alert").addClass("hidden").removeClass("alert-success alert-warning").find("span").text("");
                        },
                        success: function (data) {
                            if(loading)
                                loading.hide();
                            if(data.status)
                                $(".view-alert").addClass("alert-success").find("span").text(data.message);
                            else
                                $(".view-alert").addClass("alert-warning").find("span").text(data.message); 
                            $(".view-alert").removeClass("hidden");
                            $("#report-modal").modal("hide");
                        }
                    });
                }
            }'
        )

    ));?>
        <div class="alert hidden"></div>
        <?= CHtml::hiddenField('method', 'report') ?>
        <?= CHtml::hiddenField('hash', base64_encode($model->car_id)) ?>
        <div class="form-group">
            <?php echo $form->labelEx($model, 'reason', array('class' => 'control-label')); ?><br>
            <?php echo $form->radioButtonList($model, 'reason', $model->reasons); ?>
            <?php echo $form->error($model, 'reason'); ?>
        </div>

        <div class="form-group">
            <?php echo $form->labelEx($model, 'description', array('class' => 'control-label')); ?>
            <?php echo $form->textArea($model, 'description', array('class' => 'form-control')); ?>
            <?php echo $form->error($model, 'description'); ?>
        </div>

        <div class="form-group buttons">
            <button type="button" data-dismiss="modal" class="btn btn-default pull-left">انصراف</button>
            <?php echo CHtml::submitButton($model->isNewRecord ? 'ثبت' : 'ذخیره', array('class'=>'btn btn-success')); ?>
        </div>

    <?php $this->endWidget(); ?>
</div>
