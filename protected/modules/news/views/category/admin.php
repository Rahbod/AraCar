<?php
/* @var $this NewsManageController */
/* @var $model News */

$this->breadcrumbs=array(
	'لیست دسته بندی اخبار'
);

$this->menu=array(
	array('label'=>'افزودن دسته بندی', 'url'=>array('create')),
	array('label'=>'افزودن خبر', 'url'=>array('manage/create')),
	array('label'=>'مدیریت اخبار', 'url'=>array('/news/manage/admin')),
);
?>

<div class="box box-primary">
	<div class="box-header with-border">
		<h3 class="box-title">مدیریت دسته بندی اخبار</h3>
		<a href="<?= $this->createUrl('create') ?>" class="btn btn-default btn-sm">افزودن دسته بندی خبر</a>
	</div>
	<div class="box-body">
		<?php $this->renderPartial("//partial-views/_flashMessage"); ?>
		<div class="table-responsive">
			<?php $this->widget('ext.yiiSortableModel.widgets.SortableCGridView', array(
				'orderField' => 'order',
				'idField' => 'id',
				'orderUrl' => 'order',
				'id'=>'lists-grid',
				'dataProvider'=>$model->search(),
				'filter'=>$model,
				'itemsCssClass'=>'table table-striped',
				'template' => '{pager} {items} {pager}',
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
					'title',
					array(
						'header' => 'والد',
						'name' => 'parent.fullTitle',
					),
					array(
						'class'=>'CButtonColumn',
						'template' => '{update} {delete}'
					),
				),
			)); ?>
		</div>
	</div>
</div>