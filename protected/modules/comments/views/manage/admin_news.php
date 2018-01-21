<?php
/* @var $model Comment */
$this->breadcrumbs=array(
	Yii::t('commentsModule.msg', 'Comments')=>array('index'),
	Yii::t('commentsModule.msg', 'Manage'),
);
?>

<div class="box box-primary">
	<div class="box-header with-border">
		<h3 class="box-title"><?php echo Yii::t('commentsModule.msg', 'Manage Comments');?></h3>
	</div>
	<div class="box-body">
		<?php $this->renderPartial("//partial-views/_flashMessage"); ?>
		<div class="table-responsive">
			<?php $this->widget('zii.widgets.grid.CGridView', array(
				'id'=>'comment-grid',
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
					array(
						'header'=>Yii::t('commentsModule.msg', 'User Name'),
						'value'=>'$data->userName',
						'htmlOptions'=>array('width'=>80),
					),
					array(
						'header'=>Yii::t('commentsModule.msg', 'Comment Text'),
						'name' => 'comment_text',
					),
                    array(
                        'header'=>'لینک خبر',
                        'value'=>'CHtml::link(CHtml::link("نمایش", $data->pageUrl, array("target"=>"_blank")))',
                        'type'=>'raw',
                        'htmlOptions'=>array('width'=>70),
                    ),
					array(
						'header'=>Yii::t('commentsModule.msg', 'Create Time'),
						'name'=>'create_time',
						'value' => 'JalaliDate::date(\'Y/m/d H:i\', $data->create_time)',
						'htmlOptions'=>array('width'=>120, 'style' => 'font-size:12px', 'class' => 'ltr'),
						'filter'=>false,
					),
					/*'update_time',*/
					array(
						'header'=>Yii::t('commentsModule.msg', 'Status'),
						'name'=>'status',
						'value'=>'$data->textStatus',
						'htmlOptions'=>array('width'=>50, 'style' => 'font-size:11px'),
						'filter'=>Comment::model()->getStatuses(),
					),
					array(
						'class'=>'CButtonColumn',
						'htmlOptions' => array('class' => 'text-nowrap'),
						'deleteButtonImageUrl'=>false,
						'buttons'=>array(
							'approve' => array(
								'label'=>Yii::t('commentsModule.msg', 'Approve'),
								'url'=>'Yii::app()->urlManager->createUrl(CommentsModule::APPROVE_ACTION_ROUTE, array("id"=>$data->comment_id))',
								'options'=>array('class' => 'btn btn-xs btn-success'),
                                'visible' => '$data->status == 0',
								'click'=>'function(){
									if(confirm("'.Yii::t('commentsModule.msg', 'Approve this comment?').'"))
									{
										$.post($(this).attr("href")).success(function(data){
											data = $.parseJSON(data);
											if(data["code"] === "success")
												$.fn.yiiGridView.update("comment-grid");
										});
									}
									return false;
								}',
							),
							'delete' => array(
								'options'=>array('class' => 'btn btn-xs btn-danger'),
							),
						),
						'template'=>'{approve} {delete}',
					),
				),
			)); ?>
		</div>
	</div>
</div>