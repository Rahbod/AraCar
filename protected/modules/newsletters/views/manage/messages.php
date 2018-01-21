<?php
/* @var $this NewslettersManageController */
/* @var $model NewsLetters */

$this->breadcrumbs=array(
	'تاریخچه خبرنامه ها',
);

$this->menu=array(
	array('label'=>'ارسال خبرنامه جدید', 'url'=>array('send')),
	array('label'=>'پاک کردن کل تاریخچه', 'url'=>array('clearMessages')),
);
?>

<h1>تاریخچه خبرنامه ها</h1>
<?php $this->renderPartial('//partial-views/_flashMessage') ?>
<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'news-letter-messages-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		'title',
		array(
			'name' => 'body',
			'value' => function($data){
				return $data->body?mb_substr(strip_tags($data->body),0,200,'UTF-8'):'-';
			}
		),
		array(
			'name' => 'create_date',
			'value' => function($data){
				return JalaliDate::date('Y/m/d H:i', $data->create_date);
			}
		),
		array(
			'class'=>'CButtonColumn',
			'template' => '{delete}',
			'buttons' => array(
				'delete' => array(
					'url' => 'Yii::app()->controller->createUrl("manage/deleteMessage/".$data->id)'
				)
			)
		),
	),
)); ?>
