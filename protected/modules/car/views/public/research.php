<?php
/* @var $this CarPublicController */
/* @var $brands Brands[] */
/* @var $brand1 Brands */
/* @var $brand2 Brands */
/* @var $model1 Models */
/* @var $model2 Models */
/* @var $year1 ModelDetails */
/* @var $year2 ModelDetails */
/* @var $params string */
// load owl carousel plugin
$cs = Yii::app()->clientScript;
$baseUrl = Yii::app()->theme->baseUrl;
$cs->registerCssFile($baseUrl.'/css/owl.carousel.css');
$cs->registerCssFile($baseUrl.'/css/owl.theme.default.min.css');
$cs->registerScriptFile($baseUrl.'/js/owl.carousel.min.js', CClientScript::POS_END);

$this->breadcrumbs= [
    'بررسی / مقایسه خودرو'
];
$this->leftBox = '<div class="pull-left page-info">بررسی خودرو با امکان مقایسه اطلاعات فنی</div>';

$modelImagePath = Yii::getPathOfAlias('webroot').DIRECTORY_SEPARATOR.$this->modelImagePath.DIRECTORY_SEPARATOR;
$modelImageUrl = Yii::app()->getBaseUrl(true).'/'.$this->modelImagePath.'/';
$brandImagePath = Yii::getPathOfAlias('webroot').DIRECTORY_SEPARATOR.$this->brandImagePath.DIRECTORY_SEPARATOR;
$brandImageUrl = Yii::app()->getBaseUrl(true).'/'.$this->brandImagePath.'/';
?>

<div class="content-box white-bg">
    <div class="center-box compare-box">
        <div class="row">
            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
                <div class="panel panel-default compare-panel">
                    <div class="panel-heading">
                        <div class="row">
                            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                <h3 class="panel-title">بررسی خودرو</h3>
                            </div>
                            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                <?php if($brand1 && $model1 && $year1):?>
                                    <a href="<?php
                                    $uri = '/research/';
                                    $uri .= $vs !== false && $b2?'vs/'.$b2.($m2?'/'.$m2.($y2?'/'.$y2:''):''):'';
                                    echo $this->createUrl($uri);
                                    ?>" class="btn btn-gray btn-sm pull-left">بازگشت به لیست برندها</a>
                                <?php else:?>
                                    <input type="text" class="form-control brand-search-trigger" placeholder="جستجوی برند ...">
                                <?php endif;?>
                            </div>
                        </div>
                    </div>
                    <div class="panel-body">
                        <?php if($brand1 && $model1 && $year1):?>
                        <div class="show-details">
                            <div class="car-image is-carousel" data-margin="0" data-dots="0" data-nav="1" data-mouse-drag="1" data-items="1">
                                <?php
                                $i = 0;
                                if($year1->images):
                                    foreach($year1->images as $image):
                                        if($image && file_exists($modelImagePath.$image)):
                                            $i++;
                                            ?>
                                            <div class="car-image-item"><img src="<?= $modelImageUrl.$image ?>" alt="<?= $brand1->title.'-'.$model1->title.'-'.$year1->product_year ?>"></div>
                                            <?php
                                        endif;
                                    endforeach;
                                endif;
                                if(!$i):
                                    ?>
                                    <div class="no-image"></div>
                                    <?php
                                endif;
                                ?>
                            </div>
                            <div class="car-header">
                                <div class="col-lg-9 col-md-9 col-sm-9 col-xs-12 pull-left">
                                    <div class="row">
                                        <div class="logo pull-left">
                                            <img class="grayscale-static" src="<?= $brandImageUrl.$brand1->logo ?>">
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="car-title pull-left"><?= $brand1->title ?> | <?= $model1->title ?></div>
                                    </div>
                                </div>
                                <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12 pull-right">
                                    <div class="row">
                                        <?php
                                        $preUri = '/research/'.$brand1->slug.'/'.$model1->slug.'/';
                                        $postUri = $vs !== false && $b2?'/vs/'.$b2.($m2?'/'.$m2.($y2?'/'.$y2:''):''):'';
                                        echo CHtml::dropDownList('year',$year1->product_year,
                                            CHtml::listData($model1->years(array('order' => 'years.product_year DESC')),'product_year','product_year'),
                                            array(
                                                'data-url' => $this->createAbsoluteUrl($preUri).'/',
                                                'data-post' => $postUri,
                                                'class' => 'form-control select-picker change-year'
                                            ))
                                        ?>
                                    </div>
                                </div>
                            </div>
                            <div class="car-details">
                                <?php
                                foreach(ModelDetails::$detailFields as $group => $items):
                                    ?>
                                    <div class="row">
                                        <div class="svg svg-<?= $group ?>"></div>
                                        <div class="cell-content">
                                            <?php
                                            foreach($items as $item):
                                                ?>
                                                <div>
                                                    <span class="row-title"><?= $item['title'] ?></span>
                                                    <span class="row-content" dir="auto"><?= $year1->getDetail($group,$item['name'])?:'---' ?></span>
                                                </div>
                                                <?php
                                            endforeach;
                                            ?>
                                        </div>
                                    </div>
                                    <?php
                                endforeach;
                                ?>
                            </div>
                        </div>
                        <?php else: ?>
                        <div class="car-list accordion" id="car-list-1">
                            <?php
                            foreach($brands as $brand):
                            ?>
                            <div class="brand-list accordion-group">
                                <div class="accordion-heading">
                                    <a href="#car-model-list-1-<?= $brand->id ?>" data-toggle="collapse" data-parent="#car-list-1" class="accordion-toggle">
                                        <div class="logo hidden-xs">
                                            <img src="<?= $brandImageUrl.$brand->logo ?>" class="grayscale-static">
                                        </div>
                                        <div class="list-title"><?= $brand->title ?></div>
                                        <div class="list-model-count"><?= Controller::parseNumbers(number_format($brand->modelCount)) ?> مدل</div>
                                    </a>
                                </div>
                                <div id="car-model-list-1-<?= $brand->id ?>" class="accordion-body collapse">
                                    <div class="models-box accordion-inner">
                                        <?php
                                        foreach($brand->models as $model):
                                        $uri = '/research/'.$brand->slug.'/'.$model->slug.'/'.$model->lastYear->product_year.'/';
                                        $uri .= $vs !== false && $b2?'vs/'.$b2.($m2?'/'.$m2.($y2?'/'.$y2:''):''):'';
                                        ?>
                                        <div class="model-row">
                                            <a href="<?= $this->createUrl($uri) ?>">
                                                <div class="model-title"><?= $brand->title ?>، <?= $model->title ?></div>
                                                <div class="model-count"><?= $model->lastYear->product_year ?></div>
                                            </a>
                                        </div>
                                        <?php
                                        endforeach;
                                        ?>
                                    </div>
                                </div>
                            </div>
                            <?php
                            endforeach;
                            ?>
                            <div class="not-found text-center" style="display:none;">
                                <h5>برند موردنظر یافت نشد.</h5>
                            </div>
                        </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
                <div class="panel panel-default compare-panel">
                    <div class="panel-heading">
                        <div class="row">
                            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                <h3 class="panel-title">مقایسه خودرو با</h3>
                            </div>
                            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                <?php if($brand2 && $model2 && $year2):?>
                                <a href="<?php
                                $uri = '/research/';
                                $uri .= $b1?$b1.'/'.($m1?$m1.'/'.($y1?$y1.'/':''):''):'';
                                echo $this->createUrl($uri);
                                ?>" class="btn btn-gray btn-sm pull-left">بازگشت به لیست برندها</a>
                                <?php else:?>
                                    <input type="text" class="form-control brand-search-trigger" placeholder="جستجوی برند ...">
                                <?php endif;?>
                            </div>
                        </div>
                    </div>
                    <div class="panel-body">
                        <?php if($brand2 && $model2 && $year2):?>
                        <div class="show-details">
                            <div class="car-image is-carousel" data-margin="0" data-dots="0" data-nav="1" data-mouse-drag="1" data-items="1">
                                <?php
                                $i = 0;
                                if($year2->images):
                                    foreach($year2->images as $image):
                                        if($image && file_exists($modelImagePath.$image)):
                                            $i++;
                                            ?>
                                            <div class="car-image-item"><img src="<?= $modelImageUrl.$image ?>" alt="<?= $brand2->title.'-'.$model2->title.'-'.$year2->product_year ?>"></div>
                                            <?php
                                        endif;
                                    endforeach;
                                endif;
                                if(!$i):
                                    ?>
                                    <div class="no-image"></div>
                                    <?php
                                endif;
                                ?>
                            </div>
                            <div class="car-header">
                                <div class="col-lg-9 col-md-9 col-sm-9 col-xs-12 pull-left">
                                    <div class="row">
                                        <div class="logo pull-left">
                                            <img class="grayscale-static" src="<?= $brandImageUrl.$brand2->logo ?>">
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="car-title pull-left"><?= $brand2->title ?> | <?= $model2->title ?></div>
                                    </div>
                                </div>
                                <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12 pull-right">
                                    <div class="row">
                                        <?php
                                        $uri = '/research/';
                                        $uri .= $b1?$b1.'/'.($m1?$m1.'/'.($y1?$y1.'/':''):''):'';
                                        $uri .= 'vs/'.$brand2->slug.'/'.$model2->slug.'/';
                                        echo CHtml::dropDownList('year',$year2->product_year,
                                            CHtml::listData($model2->years(array('order' => 'years.product_year DESC')),'product_year','product_year'),
                                            array(
                                                'data-url' => $this->createAbsoluteUrl($uri).'/',
                                                'class' => 'form-control select-picker change-year y2'
                                            ))
                                        ?>
                                    </div>
                                </div>
                            </div>
                            <div class="car-details">
                                <?php
                                foreach(ModelDetails::$detailFields as $group => $items):
                                ?>
                                <div class="row">
                                    <div class="svg svg-<?= $group ?> hidden-xs"></div>
                                    <div class="cell-content">
                                        <?php
                                        foreach($items as $item):
                                        ?>
                                        <div>
                                            <span class="row-title"><?= $item['title'] ?></span>
                                            <span class="row-content" dir="auto"><?= $year2->getDetail($group,$item['name'])?:'---' ?></span>
                                        </div>
                                        <?php
                                        endforeach;
                                        ?>
                                    </div>
                                </div>
                                <?php
                                endforeach;
                                ?>
                            </div>
                        </div>
                        <?php else: ?>
                        <div class="car-list accordion" id="car-list-2">
                            <?php
                            foreach($brands as $brand):
                            ?>
                            <div class="brand-list accordion-group">
                                <div class="accordion-heading">
                                    <a href="#car-model-list-2-<?= $brand->id ?>" data-toggle="collapse" data-parent="#car-list-2" class="accordion-toggle">
                                        <div class="logo hidden-xs">
                                            <img src="<?= $brandImageUrl.$brand->logo ?>" class="grayscale-static">
                                        </div>
                                        <div class="list-title"><?= $brand->title ?></div>
                                        <div class="list-model-count"><?= Controller::parseNumbers(number_format($brand->modelCount)) ?> مدل</div>
                                    </a>
                                </div>
                                <div id="car-model-list-2-<?= $brand->id ?>" class="accordion-body collapse">
                                    <div class="models-box accordion-inner">
                                        <?php
                                        foreach($brand->models as $model):
                                        $uri = '/research/';
                                        $uri .= $b1?$b1.'/'.($m1?$m1.'/'.($y1?$y1.'/':''):''):'';
                                        $uri .= 'vs/'.$brand->slug.'/'.$model->slug.'/'.$model->lastYear->product_year;
                                        ?>
                                        <div class="model-row">
                                            <a href="<?= $this->createUrl($uri) ?>">
                                                <div class="model-title"><?= $brand->title ?>، <?= $model->title ?></div>
                                                <div class="model-count"><?= $model->lastYear->product_year ?></div>
                                            </a>
                                        </div>
                                        <?php
                                        endforeach;
                                        ?>
                                    </div>
                                </div>
                            </div>
                            <?php
                            endforeach;
                            ?>
                            <div class="not-found text-center" style="display:none;">
                                <h5>برند موردنظر یافت نشد.</h5>
                            </div>
                        </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php
Yii::app()->clientScript->registerScript('change-year','
    $("body").on("change","select.change-year", function(){
        var url = $(this).data("url");
        if($(this).hasClass("y2"))
            window.location = url+$(this).val();
        else{
            window.location = url+$(this).val()+$(this).data("post");
        }
    });
');