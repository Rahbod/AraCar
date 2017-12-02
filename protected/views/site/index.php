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
    <div class="slider" id="slider">
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
<?php endif;?>

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