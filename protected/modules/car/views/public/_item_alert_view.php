<?php
/* @var $this CarManageController */
/* @var $data CarAlerts */
/* @var $form CActiveForm */
$imagePath = Yii::getPathOfAlias('webroot').'/uploads/brands/';
?>
<article class="relative alerts-item">
    <?php $this->renderPartial('//partial-views/_loading') ?>
    <div class="item-image">
        <?php
        if($data->model->brand->logo && file_exists($imagePath.$data->model->brand->logo)):
        ?>
            <img src="<?= Yii::app()->getBaseUrl(true).'/uploads/brands/'.$data->model->brand->logo ?>">
        <?php
        else:
            ?>
            <div class="no-image"></div>
        <?php
        endif;
        ?>
    </div>
    <div class="item-content">
        <div class="row">
            <div class="col-lg-4 col-md-4 item-col">
                <div class="item-title text-blue ">برند</div>
                <div class="item-attribute">مدل</div>
                <?php if($data->from_year || $data->to_year):?><div class="item-attribute">سال</div><?php endif; ?>
                <?php if($data->from_price || $data->to_price):?><div class="item-attribute">قیمت</div><?php endif; ?>
            </div>
            <div class="col-lg-8 col-md-8 item-col">
                <div class="item-title text-blue "><?= $data->model->brand->title ?></div>
                <div class="item-attribute"><?= $data->model->title ?></div>
                <?php if($data->from_year || $data->to_year):?>
                    <div class="item-attribute">
                    <?php if($data->from_year):?> از <?= Controller::normalizeNumber($data->from_year,false, true,'') ?><?php endif; ?>
                    <?php if($data->to_year):?> تا <?= Controller::normalizeNumber($data->to_year,false, true,'') ?><?php endif; ?>
                    </div>
                <?php endif; ?>
                
                <?php if($data->from_price || $data->to_price):?>
                    <div class="item-attribute">
                    <?php if($data->from_price):?> از <?= Controller::normalizeNumber($data->from_price,true, true,'میلیون تومان') ?><?php endif; ?>
                    <?php if($data->to_price):?> تا <?= Controller::normalizeNumber($data->to_price,true, true,'میلیون تومان') ?><?php endif; ?>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
    <div class="item-actions">
        <?php
        echo CHtml::ajaxLink(' حذف<i class="addon-icon icon icon-remove"></i>',array('/car/public/authJson'),array(
            'type' => 'POST',
            'dataType' => 'JSON',
            'data' => array('method' => 'removeAlert','hash'=>base64_encode($data->id)),
            'beforeSend' => 'js: function(data){
                alert.find(\'.loading-container\').show();
            }',
            'success' => 'js: function(data){
                alert.find(\'.loading-container\').show();
                if(data.status){
                    alert.remove();
                    $("#alerts-tab #count-alert").text((parseInt($("#alerts-tab #count-alert").text()) - 1));
                    $("#alerts-tab .view-alert").addClass("alert-success").find("span").text(data.message);
                }
                else{
                    $("#alerts-tab .view-alert").addClass("alert-warning").find("span").text(data.message); 
                }   
                $("#alerts-tab .view-alert").removeClass("hidden");
            }'
        ),array('class' => 'btn btn-gray remove-alert'));
        ?>
    </div>
</article>
<script>
    var alert;
    $(function () {
        $('body').on("click",".remove-alert", function () {
            alert = $(this).parents("article");
        });
    })
</script>