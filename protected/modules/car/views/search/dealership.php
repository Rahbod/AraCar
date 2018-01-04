<?php
/* @var $this CarManageController */
/* @var $model Users */
/* @var $filters [] */
/* @var $form CActiveForm */
/* @var $dataProvider CActiveDataProvider */
?>

<div class="page-header">
	<div class="top">
		<div class="center-box">
			<div class="row">
				<div class="col-lg-3 col-md-3 col-sm-3 col-xs-12"></div>
				<div class="col-lg-9 col-md-9 col-sm-9 col-xs-12">
					<?php if($this->pageLogo):?><img src="<?= $this->pageLogo ?>" class="brand-logo" alt="<?= strip_tags($this->pageHeader) ?>"><?php endif; ?>
					<h2 class="brand-name<?= $this->layout == '//layouts/panel'?' user-detail':'' ?>"><?php echo $this->pageHeader ?><small><?php echo $this->pageDescription ?></small></h2>
				</div>
			</div>
		</div>
	</div>
	<?php if(count($filters)):?>
		<div class="bottom">
			<div class="center-box">
				<div class="row">
					<div class="col-lg-3 col-md-3 col-sm-3 col-xs-12"></div>
					<div class="col-lg-9 col-md-9 col-sm-9 col-xs-12">
						<span>انتخاب شما</span>
						<div class="filters">
							<?= $this->createFiltersBar($filters);?>
							<a href="<?= $this->createUrl('/'.Yii::app()->request->pathInfo)?>" class="clear-filters-link">پاک کردن همه</a>
						</div>
					</div>
				</div>
			</div>
		</div>
	<?php endif;?>
</div>
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
