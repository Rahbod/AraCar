<?
/* @var $data Slideshow*/
$path = Yii::getPathOfAlias('webroot').'/uploads/slideshow/';
?>
<?php
if($data->image && file_exists($path.$data->image)):
        if($data->link != '')
            $tag = '<a href="'.$data->link.'" target="_blank" class="ls-slide" data-ls="slidedelay:4000;transition2d:21,105;timeshift:-1000;" >
                                <img src="'. Yii::app()->baseUrl .'/uploads/slideshow/'.$data->image.'" class="ls-bg" alt="'.$data->title.'" />
                        </a>';
        else
            $tag = '<div class="ls-slide" data-ls="slidedelay:4000;transition2d:21,105;timeshift:-1000;">
                            <img src="'. Yii::app()->baseUrl .'/uploads/slideshow/'.$data->image.'" class="ls-bg" alt="'.$data->title.'" />
                        </div>';
        echo $tag;
endif;