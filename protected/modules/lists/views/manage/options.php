<?php
/* @var $this ListsManageController */
/* @var $model Lists */
/* @var $list Lists */

$this->breadcrumbs=array(
	'مدیریت لیست ها' => array('admin'),
	'مدیریت گزینه های لیست '.$list->title,
);

?>

<div class="box box-primary">
	<div class="box-header with-border">
		<h3 class="box-title">
            مدیریت گزینه های لیست "<?= $list->title ?>"<br><br>
            <?php if($list->description): ?><small class="description-text"><?= $list->description ?></small><?php endif; ?>
        </h3>
        <a href="<?= $this->createUrl('admin') ?>" class="btn btn-primary btn-sm pull-left">
            <span class="hidden-xs">بازگشت به لیست ها</span>
            <i class="fa fa-arrow-left"></i>
        </a>
	</div>
	<div class="box-body">
		<?php $this->renderPartial("//layouts/_flashMessage"); ?>
		<?php $this->renderPartial("_option_form", array('model' => new Lists(), 'parentID' => $list->id)); ?>

		<div class="table-responsive">
			<?php $this->widget('zii.widgets.grid.CGridView', array(
				'id'=>'list-options-grid',
				'rowHtmlOptionsExpression' => 'array("data-id" => $data->id)',
				'dataProvider'=>$model->search(false, $list->id),
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
					'title',
					array(
						'class'=>'CButtonColumn',
						'template' => '{update} {delete}',
						'buttons' => [
							'update' => array(
                                'options' => [
                                    'class' => 'edit-option' 
                                ],
								'visible' => '$data->editable'
							),
							'delete' => array(
                                'options' => [
                                    'class' => 'delete-option'
                                ]
							)
						]
					),
				),
			)); ?>
		</div>
	</div>
</div>

<?php
Yii::app()->clientScript->registerScript('edit-option','
    $("body").on("click", ".edit-option", function(e){
        e.preventDefault();
        var title = $(this).parents("tr").find("td:first-of-type").text();
        var id = $(this).parents("tr").data("id");
        
        $("#add-form").addClass("hidden");
        
        $("#edit-form #Lists_title").focus();
        $("#edit-form #Lists_title").val(title);
        $("#edit-form #Lists_id").val(id);
        $("#edit-form").removeClass("hidden");
        $("#edit-form #option-title").text(\'"\'+title+\'"\');
        
        $(\'html, body\').animate({
            scrollTop: ($(\'.box-body\').offset().top)
        },1000,\'easeOutCubic\');
    })
    .on("click", ".cancel-edit", function(e){
        e.preventDefault(); 
        $("#edit-form").addClass("hidden");
        $("#add-form").removeClass("hidden");
        $("#add-form #Lists_title").focus();
        
        $("#edit-form #Lists_title").val("");
        $("#edit-form #Lists_id").val("");
        $("#edit-form #option-title").text("");
    }).on("click", ".delete-option", function(e){ 
        $("#edit-form").addClass("hidden");
        $("#add-form").removeClass("hidden");
        
        $("#edit-form #Lists_title").val("");
        $("#edit-form #Lists_id").val("");
        $("#edit-form #option-title").text("");
    });
');