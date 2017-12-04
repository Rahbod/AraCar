<?php
/* @var $this CarManageController */
/* @var $model Cars */

$this->breadcrumbs=array(
	'مدیریت کلاس ها',
);

$this->menu=array(
	array('label'=>'لیست کلاس ها', 'url'=>array('admin')),
);
?>


<div class="box box-primary">
	<div class="box-header with-border">
		<h3 class="box-title">مدیریت آگهی های حذف شده</h3>
        <a href="<?= $this->createUrl('admin') ?>" class="btn btn-primary btn-sm pull-left">
            <span class="hidden-xs">بازگشت</span>
            <i class="fa fa-arrow-left"></i>
        </a>
		<!--        <a href="--><?//= $this->createUrl('create') ?><!--" class="btn btn-default btn-sm">افزودن آگهی جدید</a>-->
	</div>
	<div class="box-body">
		<?php $this->renderPartial("//partial-views/_flashMessage"); ?>
		<div class="table-responsive">
			<?php $this->widget('zii.widgets.grid.CGridView', array(
				'id'=>'cars-grid',
				'dataProvider'=>$model->search(true),
				'filter'=>$model,
				'itemsCssClass'=>'table table-striped table-hover',
				'template' => '{items} {pager}',
				'ajaxUpdate' => true,
				'afterAjaxUpdate' => "function(id, data){
								$('html, body').animate({
								scrollTop: ($('#'+id).offset().top-130)
								},1000,'easeOutCubic');
							}",
				'pager' => array(
					'header' => '',
					'firstPageLabel' => '<<',
					'lastPageLabel' => '>>',
					'prevPageLabel' => '<',
					'nextPageLabel' => '>',
					'cssFile' => false,
					'htmlOptions' => array(
						'class' => 'pagination pagination-sm',
					),
				),
				'pagerCssClass' => 'blank',
				'columns'=>array(
					'title:html',
					array(
						'class'=>'CButtonColumn',
						'template' => '{restore} {delete}',
						'buttons' => array(
							'delete' => array(
								'label' => 'حذف برای همیشه',
								'options' => array('class' => 'btn btn-danger btn-sm','style' => 'margin:10px 0 5px'),
								'imageUrl' => false
							),
							'restore' => array(
								'label' => 'بازگردانی',
								'options' => array('class' => 'btn btn-success btn-sm','style' => 'margin-top:5px'),
								'url' => 'Yii::app()->createUrl("/car/manage/restore",array("id" => $data->id))'
							)
						)
					),
				),
			)); ?>
		</div>
	</div>
</div>
