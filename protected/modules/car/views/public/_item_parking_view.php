<?php
/* @var $this CarManageController */
/* @var $data UserParking */
/* @var $form CActiveForm */
$imagePath = Yii::getPathOfAlias('webroot').'/uploads/cars/';
?>
<article>
    <div class="item-image">
        <?php
        if($data->car->carImages):
        ?>
            <img src="<?= Yii::app()->getBaseUrl(true).'/uploads/cars/'.$data->car->carImages[0]->filename ?>">
        <?php
        endif;
        ?>
    </div>
    <div class="item-content">
        <div class="row">
            <div class="col-lg-6 col-md-6 item-col">
                <div class="item-title text-blue "><?= $data->car->title ?></div>
                <div class="item-attribute"><?= Controller::parseNumbers(number_format($data->car->purchase_details)) ?> تومان</div>
                <div class="item-attribute"><?= Controller::parseNumbers(number_format($data->car->distance)) ?> کیلومتر</div>
                <div class="item-attribute"><?= $data->car->bodyState->title  ?></div>
            </div>
        </div>
    </div>
    <div class="item-actions">
        <?php
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
        ?>
        <a href="<?= $this->createUrl('/car/public/delete/'.$data->car->id) ?>" class="btn btn-default">
            حذف از پارکینگ
            <i class="addon-icon icon icon-remove"></i>
        </a>
    </div>
</article>
