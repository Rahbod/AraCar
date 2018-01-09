<?php
/* @var $this CarPublicController */
/* @var $model Users */
/* @var $form CActiveForm */
/* @var $images UploadedFiles|[] */
/* @var $filters array */

$this->breadcrumbs = array(
	'جستجوی نمایشگاه'
);
$provider = $model->searchDealers();
?>
<div class="content-box white-bg">
	<div class="center-box">
		<a href="#" class="filter-btn floating-button left filter-box-trigger" data-title="فیلترها"></a>
		<div class="row">
			<div class="col-lg-3 col-md-3 col-sm-12 col-xs-12 filters-container">
				<div class="close-container col-md-12"><i class="menu-close-icon filter-box-trigger"></i><h4>فیلتر های نمایشگاه</h4></div>
				<?php $this->renderPartial('_dealer_filter_box', array('filters' => $filters));?>
			</div>
			<div class="col-lg-9 col-md-9 col-sm-12 col-xs-12 list-container">
				<?php
				$this->widget('zii.widgets.CListView',array(
					'id'=>'dealers-list',
					'dataProvider'=> $provider,
					'itemView' => 'dealership_item',
					'itemsCssClass' => 'list-unstyled dealer-items',
					'itemsTagName' => 'ul',
					'template' => '{items} {pager}',
					'emptyCssClass' => 'sell-not-allow silver',
					'emptyTagName' => 'div',
					'emptyText' => '<div class="inner-flex"><h3>چیزی پیدا نشد.</h3><p>فیلترها رو تغییر بده! </p></div>',
					'ajaxUpdate' => true,
					'pager' => array(
						'class' => 'ext.infiniteScroll.IasPager',
						'rowSelector'=>'.dealer-item',
						'listViewId' => 'dealers-list',
						'header' => '',
						'loaderText'=>'در حال دریافت ...',
						'options' => array('history' => false, 'triggerPageTreshold' => ((int)$provider->totalItemCount+1), 'trigger'=>'بیشتر'),
					),
					'afterAjaxUpdate'=>"function(id, data) {
                    $.ias({
                        'history': false,
                        'triggerPageTreshold': ".((int)$provider->totalItemCount+1).",
                        'trigger': 'بیشتر',
                        'container': '#dealers-list',
                        'item': '.dealer-item',
                        'pagination': '#dealers-list .pager',
                        'next': '#dealers-list .next:not(.disabled):not(.hidden) a',
                        'loader': 'در حال دریافت ...'
                    });
                }"
				));
				?>
			</div>
		</div>
	</div>
</div>