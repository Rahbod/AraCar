<?php
/* @var $this NewslettersManageController */
/* @var $model NewsLetters */

$this->breadcrumbs=array(
	'مدیریت',
);
?>

<h1>مدیریت گیرندگان خبرنامه</h1>
<br>
<h4>تعداد گیرندگان: <?= Yii::app()->db->createCommand()->select('COUNT(*)')->from('{{news_letters}}')->queryScalar() ?> نفر</h4>
<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'news-letters-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		'email',
		array(
			'class'=>'CButtonColumn',
			'template' => '{delete}'
		),
	),
)); ?>
