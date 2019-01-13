<!DOCTYPE html>
<html lang="fa_ir">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="theme-color" content="#158BFF" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="<?= Yii::app()->request->csrfToken ?>" />
    <meta name="keywords" content="<?= $this->keywords ?>">
    <meta name="description" content="<?= $this->description?> ">
    <link rel="shortcut icon" href="<?php echo Yii::app()->getBaseUrl(true).'/themes/frontend/images/favicon.ico';?>">

    <title><?= (!empty($this->pageTitle)?$this->pageTitle.' | ':'').$this->siteName ?></title>

    <link rel="stylesheet" href="<?php echo Yii::app()->theme->baseUrl;?>/css/fontiran.css">
    <?php
    $baseUrl = Yii::app()->theme->baseUrl;
    $cs = Yii::app()->getClientScript();
    Yii::app()->clientScript->registerCoreScript('jquery');
    $cssCoreUrl = $cs->getCoreScriptUrl();

    $cs->registerCssFile($baseUrl.'/css/bootstrap.min.css');
    $cs->registerCssFile($baseUrl.'/css/bootstrap-rtl.min.css');
    $cs->registerCssFile($baseUrl.'/css/fontiran.css');
    $cs->registerCssFile($baseUrl.'/css/font-awesome.css');
    $cs->registerCssFile($baseUrl.'/css/bootstrap-theme.css?4.8');

    $cs->registerScriptFile($baseUrl.'/js/bootstrap.min.js', CClientScript::POS_END);
    $cs->registerScriptFile($baseUrl.'/js/jquery.nicescroll.min.js', CClientScript::POS_END);
    $cs->registerScriptFile($baseUrl.'/js/jquery.script.min.js', CClientScript::POS_END);
    ?>
</head>
<body>
<?php $this->renderPartial('//partial-views/_header');?>
<?php echo $content;?>
<?php $this->renderPartial('//partial-views/_login_popup');?>
<?php $this->renderPartial('//partial-views/_footer');?>
<script>function submitAjaxForm(form,url,loading,callback){loading=void 0!==loading?loading:null,callback=void 0!==callback?callback:null,$.ajax({type:"POST",url:url,data:form.serialize(),dataType:"json",beforeSend:function(){loading&&loading.show()},success:function(html){loading&&loading.hide(),"object"==typeof html&&void 0===html.status?$.each(html,function(l,a){$("#"+l+"_em_").show().html(a.toString()).parent().removeClass("success").addClass("error")}):eval(callback)}})}</script>
</body>
</html>