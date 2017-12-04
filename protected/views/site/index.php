<?php
/**
 * @var $slideShow Slideshow[]
 * @var $topBrands Brands[]
 * @var $cs CClientScript
 * @var $baseUrl string
 */
$cs = Yii::app()->clientScript;
$baseUrl = Yii::app()->theme->baseUrl;
?>


<?php if($slideShow):?>
    <?php
    $cs->registerCssFile($baseUrl.'/assets/slider/css/layerslider.css');
    $cs->registerCssFile($baseUrl.'/assets/slider/css/style-layerslider.css');
    $cs->registerCssFile($baseUrl.'/assets/slider/layerslider_skins/fullwidth/skin.css');
    // scripts
    $cs->registerScriptFile($baseUrl.'/assets/slider/js/greensock.js',CClientScript::POS_END);
    $cs->registerScriptFile($baseUrl.'/assets/slider/js/jquery.layerslider.js',CClientScript::POS_END);
    $cs->registerScriptFile($baseUrl.'/assets/slider/js/layerslider.transitions.js',CClientScript::POS_END);
    $cs->registerScriptFile($baseUrl.'/assets/slider/js/jquery-animate-background-position.js',CClientScript::POS_END);
    ?>
    <div class="slideshow-container">
        <div class="slideshow" id="slider">
            <?php foreach ($slideShow as $item):
                $this->renderPartial('//site/_slide_show_item_view',array('data' => $item));
            endforeach;
            $skinPath = $baseUrl.'/assets/slider/layerslider_skins/';
            $cs->registerScript('slider-js','
                $("#slider").layerSlider({
                    startInViewport: false,
                    responsive : false ,
                    responsiveUnder : 768 ,
                    forceLoopNum: false,
                    autoPlayVideos: false,
                    skinsPath: \''.$skinPath.'\',
                    skin: \'fullwidth\',
                    navPrevNext: false,
                    navStartStop: false,
                    pauseOnHover: false,
                    thumbnailNavigation: \'hover\'
                });
            ');
            ?>
        </div>
        <div class="ls-items">
            <div class="ls-item">
                <i class="star-icon"></i>
                <h4>+70</h4>
                <span>صفر کیلومتر</span>
            </div>
            <div class="ls-item">
                <i class="edit-icon"></i>
                <h4>+80</h4>
                <span>بررسی خودرو</span>
            </div>
            <div class="ls-item">
                <i class="clock-icon"></i>
                <h4>+260</h4>
                <span>آگهی امروز</span>
            </div>
        </div>
    </div>
<?php endif;?>


<div class="boxes-container">
    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 right-side">
        <!--        <a href="#suggest-way-modal" data-toggle="modal" class="linear-link">روش پیشنهادی</a>-->
        <div class="content">
            <div class="steps">
                <i class="step-1"></i>
                <i class="step-2"></i>
                <i class="step-3"></i>
                <i class="step-4"></i>
            </div>
            <h2>جستجوی وسیله نقلیه به صورت مرحله ای</h2>
            <p>در این روش شما می توانید به صورت مرحله ای و به صورت هوشمند، وسیله نقیله، برند، شاسی، مدل، قیمت را انتخاب نموده و سریعتر و دقیقتر به نتیجه برسید.</p>
        </div>
    </div>
    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 left-side">
        <div class="search-box">
            <h4>جستجوی وسیله نقلیه</h4>
            <?= CHtml::form(['car/search/brand']);?>
            <div class="input-group">
                <?= CHtml::textField('Search[brand]', null, [
                    'class' => 'form-control custom-search auto-complete',
                    'placeholder' => 'مدل وسیله نقلیه را تایپ نمایید...',
                    'data-model' => Models::class,
                    'data-field' => 'title',
                ]);?>
            <span class="input-group-btn">
                <?= CHtml::htmlButton('<i class="search-icon"></i>', ['class' => 'btn', 'type' => 'submit']);?>
            </span>
            </div>
            <?= CHtml::endForm();?>
        </div>
        <div class="desc-box">
            <i class="dollar-car-icon"></i>
            <h4>خودرو خود را برای فروش به ما بسپارید...</h4>
            <p>شما می توانید مشخصات خودرو خود را برای فروش بین تمامی کاربران سایت به اشتراک بگذارید و با استفاده از طرح های ما بسیار سریع به فروش برسانید.</p>
        </div>
    </div>
</div>

<?php
if($topBrands):
$cs->registerCssFile($baseUrl.'/css/owl.carousel.css');
$cs->registerCssFile($baseUrl.'/css/owl.theme.default.min.css');
$cs->registerScriptFile($baseUrl.'/js/owl.carousel.min.js', CClientScript::POS_END);
?>

<div class="top-brands">
    <div class="is-carousel" data-margin="10" data-dots="0" data-nav="1" data-mouse-drag="1" data-responsive='{"1920":{"items":"5"},"1200":{"items":"10"},"992":{"items":"6"},"768":{"items":"5"},"480":{"items":"3"},"0":{"items":"2"}}'>
        <?php
        $logoPath = Yii::getPathOfAlias("webroot").'/uploads/brands/';
        foreach($topBrands as $brand):
            if($brand->logo && file_exists($logoPath.$brand->logo)):
        ?>
            <div class="item">
                <a href="#"><img src="<?= Yii::app()->getBaseUrl(true).'/uploads/brands/'.$brand->logo ?>"><span><?= 0 ?></span></a>
            </div>
        <?php
            endif;
        endforeach;
        ?>
    </div>
</div>

<?php
endif;