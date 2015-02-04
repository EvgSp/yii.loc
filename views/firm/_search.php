<?php
/* @var $this FileController */
/* @var $model File */
/* @var $form CActiveForm */
?>

<div class="wide form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>

	<div class="row">
		<?php echo $form->label($model,'id'); ?>
		<?php echo $form->textField($model,'id'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'firm_name'); ?>
		<?php echo $form->textField($model,'firm_name'); ?>
	</div>
	
	<div class="row">
		<?php echo $form->label($model,'activity'); ?>
		<?php echo $form->textField($model,'activity'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'rating'); ?>
		<?php echo $form->textField($model,'rating',array('size'=>4,'maxlength'=>4)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'file_name'); ?>
		<?php echo $form->textField($model,'file_name',array('size'=>50,'maxlength'=>50)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'file_type'); ?>
		<?php echo $form->textField($model,'file_type',array('size'=>10,'maxlength'=>10)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'encoding'); ?>
		<?php echo $form->textField($model,'encoding',array('size'=>20,'maxlength'=>20)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'currency'); ?>
		<?php echo $form->textField($model,'currency',array('size'=>40,'maxlength'=>40)); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton('Search'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- search-form -->