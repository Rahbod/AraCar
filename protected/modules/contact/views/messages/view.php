<?php
/* @var $this ContactMessagesController */
/* @var $model ContactMessages */
$this->breadcrumbs=array(
    'لیست پیام ها'=>array('admin'),
    $model->subject
);
$this->menu=array(
    array('label'=>'حذف پیام', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
    array('label'=>'نمایش لیست پیام ها', 'url'=>array('admin?ContactMessages[department_id]='.$model->department_id))
);
?>
<h1>نمایش پیام #<?php echo $model->subject; ?></h1>
<?php $this->renderPartial('//partial-views/_flashMessage') ?>

<?php
$this->widget('zii.widgets.CDetailView', array(
    'data'=>$model,
    'attributes'=>array(
        'id',
        array(
            'label' => 'عنوان بخش',
            'value' => $model->department->title
        ),
        array(
            'name' => 'date',
            'value' => JalaliDate::date('Y/m/d - H:i:s',$model->date)
        ),
        'name',
        'email',
        'tel',
        'subject',
        'body',
        array(
            'name' => 'reply',
            'value' => $model->replyLabels[$model->reply]
        )
    )
)); ?>
<hr>
<div class="form row">
    <h3>ارسال پاسخ</h3>
    <?php
    $rpModel = new ContactReplies();
    $rpModel->message_id = $model->id;
    ?>

    <?= $this->renderPartial('contact.views.replies._form',array('model'=>$rpModel)) ?>
</div>
<hr>
<div class="form row">
    <h3>لیست پاسخ های قبلی</h3>
    <?php	$rpModel->setScenario('search');
    $this->widget('zii.widgets.grid.CGridView', array(
        'id'=>'contact-replies-grid',
        'dataProvider'=>$rpModel->search(),
        'selectableRows'=>20,
        'columns'=>array(
            array(
                'name' => 'body',
                'type'=> 'raw'
            ),
            array(
                'name' => 'date',
                'value' => 'JalaliDate::date("Y/m/d - H:i:s",$data->date)',
                ),
            )
        )
    );?>
</div>