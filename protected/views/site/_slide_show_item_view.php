<?php
/* @var $data Slideshow*/
$path = Yii::getPathOfAlias('webroot').'/uploads/slideshow/';
?>
<?php
if($data->image && file_exists($path.$data->image)):
        if($data->link != '')
            $tag = '<a href="'.$data->link.'" target="_blank" class="ls-slide" data-ls="slidedelay:4000;transition2d:21,105;timeshift:-1000;" >
                    <img class="ls-bg hidden-sm hidden-xs" src="'. Yii::app()->baseUrl .'/uploads/slideshow/'.$data->image.'" alt="'.$data->title.'" />
                    <img class="ls-bg hidden-lg hidden-md" src="'. Yii::app()->baseUrl .'/uploads/slideshow/'.$data->mobile_image.'" alt="'.$data->title.'" />
            </a>';
        else
            $tag = '<div class="ls-slide" data-ls="slidedelay:4000;transition2d:21,105;timeshift:-1000;">
                    <img class="ls-bg hidden-sm hidden-xs" src="'. Yii::app()->baseUrl .'/uploads/slideshow/'.$data->image.'" alt="'.$data->title.'" />
                    <img class="ls-bg hidden-lg hidden-md" src="'. Yii::app()->baseUrl .'/uploads/slideshow/'.$data->mobile_image.'" alt="'.$data->title.'" />
                </div>';
        echo $tag;
endif;