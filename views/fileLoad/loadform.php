<?php
$this->breadcrumbs = array(
    'FileLoad',
);

$form = $this->beginWidget('CActiveForm', array(
    'id' => 'upload-form',
    'enableAjaxValidation' => false,
    'htmlOptions' => array(
        'enctype' => 'multipart/form-data',
    ),
        ));
?>

<?php
$this->widget('CMultiFileUpload', array(
//    'name' => 'prices',
    'model'=>$model,
    'attribute'=>'csvFile',
//@todo remove 'jpg' extension from 'accept' property   
    'accept' => 'jpg|csv',
    'options' => array(
    //'onFileSelect'=>'function(e, v, m){ alert("onFileSelect - "+v) }',
    //'afterFileSelect'=>'function(e, v, m){ alert("afterFileSelect - "+v) }',
    //'onFileAppend'=>'function(e, v, m){ alert("onFileAppend - "+v) }',
    //'afterFileAppend'=>'function(e, v, m){ alert("afterFileAppend - "+v) }',
    //'onFileRemove'=>'function(e, v, m){ alert("onFileRemove - "+v) }',
    //'afterFileRemove'=>'function(e, v, m){ alert("afterFileRemove - "+v) }',
    ),
    'denied' => 'Files of this type are prohibited to download',
    'duplicate' => 'This file has been alredy selected',
    'max' => 10, // max 10 files
));
?>

<?php echo CHtml::submitButton('Submit', array('name' => 'Upload')); ?>

<?php $this->endWidget(); ?>
</br>	
<?php
	if($fileName){
		if($isLoaded){	echo 'Files have been loaded successfully.'; }
		else 
			echo 'File loading error.';	
	}