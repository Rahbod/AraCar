<?php
/* @var NewsManageController $this */
/* @var CActiveDataProvider $dataProvider */
/* @var string $listTitle */
$this->pageHeader = $listTitle;
$this->pageTitle = $listTitle;
$this->breadcrumbs = array(
    $listTitle
);
?>
<div class="related-news-box">
    <!--Render Advertise-->
    <?php $this->renderPartial('advertises.views.manage._advertise_item', [
        'dismissible' => true,
        'placement' => Advertises::PLACE_NEWS_TOP,
        'cssClass' => 'advertise-news-top advertise-hover-shadow hidden-xs'
    ]) ?>
    <div class="clearfix"></div>
    <?php $this->widget('zii.widgets.CListView', [
        'id'=>'news-list',
        'dataProvider'=>$dataProvider,
        'itemView'=>'_list_item',
        'itemsCssClass'=>'news items',
        'template' => '{items} {pager}',

        'ajaxUpdate' => true,
        'afterAjaxUpdate' => "function(id, data){
            $('html, body').animate({
                scrollTop: ($('#'+id).offset().top-130)
            },1000);
//            window.history.pushState('','','#'+);
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
        'pagerCssClass' => 'blank text-center',
//        'pager' => array(
//            'class' => 'ext.infiniteScroll.IasPager',
//            'rowSelector'=>'.item',
//            'listViewId' => 'news-list',
//            'header' => '',
//            'loaderText'=>'در حال دریافت ...',
//            'options' => array('history' => false, 'triggerPageTreshold' => ((int)$dataProvider->totalItemCount+1), 'trigger'=>'بیشتر'),
//        ),
//        'afterAjaxUpdate'=>"function(id, data) {
//			$.ias({
//				'history': false,
//				'triggerPageTreshold': ".((int)$dataProvider->totalItemCount+1).",
//				'trigger': 'بیشتر',
//				'container': '#news-list',
//				'item': '.item',
//				'pagination': '#news-list .pager',
//				'next': '#news-list .next:not(.disabled):not(.hidden) a',
//				'loader': 'در حال دریافت ...'
//			});
//		}",
    ]);
    ?>
</div>