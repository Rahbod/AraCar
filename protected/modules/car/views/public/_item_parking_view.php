<?php
/* @var $this CarManageController */
/* @var $data UserParking */
/* @var $form CActiveForm */
$imagePath = Yii::getPathOfAlias('webroot').'/uploads/cars/';
?>
<article class="relative parking-item">
    <?php if($data->car->purchase_type_id == Cars::PURCHASE_TYPE_INSTALMENT):?>
        <span class="instalment-box">اقساطی</span>
    <?php endif;?>
    <?php $this->renderPartial('//partial-views/_loading') ?>
    <div class="item-image">
        <?php
        if($data->car->mainImage && file_exists($imagePath.'thumbs/180x140/'.$data->car->mainImage->filename)):
        ?>
            <img src="<?= Yii::app()->getBaseUrl(true).'/uploads/cars/thumbs/180x140/'.$data->car->mainImage->filename ?>">
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
            <div class="col-lg-6 col-md-6 item-col">
                <div class="item-title text-blue "><?= $data->car->title ?></div>
                <div class="item-attribute"><?= $data->car->getPrice() ?></div>
                <div class="item-attribute"><?= Controller::parseNumbers(number_format($data->car->distance)) ?> کیلومتر</div>
                <div class="item-attribute"><?= $data->car->bodyState->title  ?></div>
            </div>
        </div>
    </div>
    <div class="actions-icon-btn item-actions-trigger"><i class="actions-icon"></i></div>
    <div class="item-actions">
        <a href="<?php echo $data->car->getViewUrl(); ?>" class="btn btn-gray">
            <span>نمایش خودرو</span>
            <i class="addon-icon icon icon-search"></i>
        </a>
        <?php
        echo CHtml::ajaxLink('<span>حذف از پارکینگ</span><i class="addon-icon icon icon-remove"></i>',array('/car/public/authJson'),array(
            'type' => 'POST',
            'dataType' => 'JSON',
            'data' => array('method' => 'park','hash'=>base64_encode($data->car->id)),
            'beforeSend' => 'js: function(data){
                article.find(\'.loading-container\').show();
            }',
            'success' => 'js: function(data){
                article.find(\'.loading-container\').show();
                if(data.status){
                    article.remove();
                    $("#parking-tab #count-parked").text((parseInt($("#parking-tab #count-parked").text()) - 1));
                    $("#parking-tab .view-alert").addClass("alert-success").find("span").text(data.message);
                }
                else{
                    $("#parking-tab .view-alert").addClass("alert-warning").find("span").text(data.message); 
                }   
                $("#parking-tab .view-alert").removeClass("hidden");
            }'
        ),array('class' => 'btn btn-gray remove-parked'));
        ?>
    </div>
</article>
<script>
    var article;
    $(function () {
        $('body').on("click",".remove-parked", function () {
            article = $(this).parents("article");
        });
    })
</script>