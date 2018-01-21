<?php
/* @var Controller $this */
/* @var News $data */
?>
<div class="item">
    <a href="<?php echo $data->getViewUrl();?>" class="link"></a>
    <div class="image-container">
        <?php if($data->image && is_file(Yii::getPathOfAlias('webroot').'/uploads/news/150x150/'.$data->image)): ?>
            <img src="<?php echo Yii::app()->baseUrl.'/uploads/news/150x150/'.$data->image;?>">
        <?php else: ?>
            <div class="no-image"></div>
        <?php endif; ?>
    </div>
    <h5 class="title"><?php echo $data->title;?></h5>
    <a href="<?php echo $data->getViewUrl();?>" class="more-link">بیشتر</a>
</div>
