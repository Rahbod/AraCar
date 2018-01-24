<?php
/* @var $this NewsManageController */
/* @var $model News */
/* @var $similarNewsProvider CActiveDataProvider */
$this->pageTitle = $model->title;
$this->pageHeader = $model->title;
//$this->pageDescription = $model->summary;
$this->breadcrumbs = array(
    'اخبار' => array('/news'),
    $model->title
);
?>
<div class="news-view-box">
    <div class="head">
        <h2><?php echo $model->title;?></h2>
    </div>
    <div class="info">
        <span><b>دسته بندی </b>&nbsp;&nbsp;&nbsp;</span>
        <span><?php echo $model->category->title;?></span>
        <span class="date"><?php echo $model->publish_date?JalaliDate::date('d F Y - H:i', $model->publish_date):'---';?></span>
        <!--                        <a href="#" class="print"></a>-->
    </div>
    <div class="text-container">
        <div class="image-container text-center">
            <img src="<?php echo Yii::app()->baseUrl.'/uploads/news/'.$model->image; ?>" alt="<?= $model->title ?>">
        </div>
        <div class="text">
            <?php if(!empty($model->summary)):?><div class="well"><?= CHtml::encode(nl2br($model->summary)) ?></div><?php endif;?>
            <?php
            $purifier=new CHtmlPurifier();
            echo $purifier->purify($model->body);
            ?>
        </div>
        <div class="sharing">
            <span>اشتراک گذاری</span>
            <a href="https://www.facebook.com/sharer/sharer.php?u=<?php echo Yii::app()->getBaseUrl(true).'/news/'.$model->id;?>" class="facebook-icon"></a>
            <a href="https://twitter.com/home?status=<?php echo Yii::app()->getBaseUrl(true).'/news/'.$model->id;?>" class="twitter-icon"></a>
            <a href="https://telegram.me/share/url?url=<?php echo Yii::app()->getBaseUrl(true).'/news/'.$model->id;?>" class="telegram-icon"></a>
        </div>
    </div>
</div>
<?php
if($model->tags):
    ?>
    <!-- NEWS META DATA : TAGS -->
    <div class="news-tags">
        <div class="head">برچسب ها</div>
        <?php
        foreach ($model->tags as $tag)
            if($tag->title && !empty($tag->title))
                echo CHtml::link($tag->title,array('/news/tag/'.$tag->id.'/'.urlencode($tag->title)),array('class'=>'label label-blue'));
        ?>
    </div>
    <?php
endif;
?>
<?php if($similarNewsProvider->totalItemCount != 0):?>
    <div class="related-news-box">
        <div class="head">اخبار مرتبط</div>
        <?php $this->widget('zii.widgets.CListView', array(
            'id'=>'similar-list',
            'dataProvider'=>$similarNewsProvider,
            'itemView'=>'_list_item',
            'template'=>'{items}',
            'itemsCssClass'=>'news items'
        ));?>
    </div>
<?php endif;?>
<div class="comments-box">
    <div class="head">نظرات</div>
    <div class="content">
        <p class="desc">
            دیدگاه‌های شما پس از تایید ناظر منتشر می‌شود.<br>
            متون غیرفارسی و پیام‌های حاوی توهین، تهمت یا افترا تایید نخواهد شد.
        </p>
        <?php $this->widget('comments.widgets.ECommentsListWidget', array(
            'model' => $model,
        )); ?>
    </div>
</div>