<?php
/* @var $this CarManageController */
/* @var $model Users */
/* @var $filters [] */
/* @var $form CActiveForm */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs = array(
	'نمایشگاه ها' => array('/dealerships'),
	$model->dealership_name
);
?>

<div class="content-box">
	<div class="center-box">
		<div class="row">
			<div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
				<?php $this->renderPartial('_filter_box', array('filters' => $filters));?>
			</div>
			<div class="col-lg-9 col-md-9 col-sm-9 col-xs-12">
				<?php $this->widget('zii.widgets.CListView', array(
					'id' => 'advertising-list',
					'dataProvider'=>$dataProvider,
					'itemView'=>'_car_item',
					'itemsCssClass' => 'advertising-list',
					'template' => '{items}{pager}',
					'pager' => array(
						'class' => 'ext.infiniteScroll.IasPager',
						'rowSelector'=>'.advertising-item',
						'listViewId' => 'advertising-list',
						'header' => '',
						'loaderText'=>'Loading...',
						'options' => array('history' => false, 'triggerPageTreshold' => 1, 'trigger'=>'Load more'),
					)
				)); ?>
			</div>
		</div>
	</div>
</div>
