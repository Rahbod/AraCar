<?php
/* @var $this NewsCategoryController */
/* @var $model NewsCategories */
/* @var $dataProvider CActiveDataProvider */
?>
<?php
$this->pageTitle = $model->title;
$this->pageHeader = Yii::t('app','News tagged "{tag}"',array('{tag}'=>$model->title));
$this->pageDescription = Yii::t('app','Number of Entries').": ".Controller::parseNumbers(number_format($dataProvider->totalItemCount));
$this->breadcrumbs = array(
	'اخبار' => array('/news'),
	"تگ: ".$model->title
);
?>
<div class="related-news-box">
	<?php $this->widget('zii.widgets.CListView', [
		'id'=>'news-list',
		'dataProvider'=>$dataProvider,
		'itemView'=>'_list_item',
		'itemsCssClass'=>'news items',
		'template' => '{items} {pager}',
		'ajaxUpdate' => true,
		'pager' => array(
			'class' => 'ext.infiniteScroll.IasPager',
			'rowSelector'=>'.item',
			'listViewId' => 'news-list',
			'header' => '',
			'loaderText'=>'در حال دریافت ...',
			'options' => array('history' => false, 'triggerPageTreshold' => ((int)$dataProvider->totalItemCount+1), 'trigger'=>'بیشتر'),
		),
		'afterAjaxUpdate'=>"function(id, data) {
			$.ias({
				'history': false,
				'triggerPageTreshold': ".((int)$dataProvider->totalItemCount+1).",
				'trigger': 'بیشتر',
				'container': '#news-list',
				'item': '.item',
				'pagination': '#news-list .pager',
				'next': '#news-list .next:not(.disabled):not(.hidden) a',
				'loader': 'در حال دریافت ...'
			});
		}",
	]);
	?>
</div>