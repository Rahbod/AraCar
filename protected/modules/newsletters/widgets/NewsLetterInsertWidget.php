<?php
/**
 * 
 * Example:
 *      $this->widget('newsletters.widgets.NewsLetterInsertWidget',array(
 *          'formOptions' => array('class' => 'form-horizontal col-md-3'),
 *          'fieldOptions' => array('class' => 'form-control'),
 *          'btnOptions' => array('class' => 'btn btn-success'),
 *      ));
 *
 */
Yii::import('newsletters.models.*');
class NewsLetterInsertWidget extends CWidget
{
    public $formOptions = array();
    public $fieldOptions = array();
    public $btnOptions = array();

    public function init()
    {
        parent::init();
        if(!isset($this->formOptions['id']))
            $this->formOptions['id'] = $this->getId();
    }

    public function run()
    {
        $model = new NewsLetters();
        echo CHtml::beginForm(array('/newsletters/manage/insert'), 'post', $this->formOptions);
        echo CHtml::activeEmailField($model, 'email', $this->fieldOptions);
        echo CHtml::submitButton('عضویت در خبرنامه', $this->btnOptions);
        echo CHtml::endForm();

        Yii::app()->clientScript->registerScript($this->getId().'-ajax-submit',"
            $('body').on('submit', '#{$this->formOptions['id']}', function(e){
                e.preventDefault();
                $.ajax({
                    url: $(this).attr('action'),
                    type: 'POST',
                    data: $(this).serialize(),
                    dataType: 'JSON',
                    beforeSend: function(){},
                    success: function(data){ alert(data.msg); },
                    error: function(data){ alert(data); }
                });
            });
        ");
    }
}