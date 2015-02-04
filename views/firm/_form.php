<?php
/* @var $this FileController */
/* @var $model File */
/* @var $form CActiveForm */
?>

<div class="wide form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'file-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'firm_name'); ?>
		<?php echo $form->textField($model,'firm_name',array('size'=>30, 'maxlength'=>30));	?>		
		<?php echo $form->error($model,'firm_name'); ?>
	</div>
	
	<div class="row">
		<?php echo $form->labelEx($model,'activity'); ?>
		<?php echo $form->dropDownList($model,'activity',Yii::app()->params['activity']);	?>		
		<?php echo $form->error($model,'activity'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'rating'); ?>
		<?php echo $form->textField($model,'rating',array('size'=>4,'maxlength'=>4)); ?>
		<?php echo $form->error($model,'rating'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'file_name'); ?>
		<?php echo $form->dropDownList($model,'file_name',myFileHelper::getListFiles());?>
		<?php echo $form->error($model,'file_name'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'file_type'); ?>
		<?php echo $form->textField($model,'file_type',array('size'=>10,'maxlength'=>10)); ?>
		<?php echo $form->error($model,'file_type'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'column_ceparator'); ?>
		<?php echo $form->textField($model,'column_ceparator',array('size'=>1,'maxlength'=>1)); ?>
		<?php echo $form->error($model,'column_ceparator'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'text_ceparator'); ?>
		<?php echo $form->textField($model,'text_ceparator',array('size'=>1,'maxlength'=>1)); ?>
		<?php echo $form->error($model,'text_ceparator'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'encoding'); ?>
		<?php echo $form->dropDownList($model,'encoding',Yii::app()->params['encoding']);	?>
		<?php echo $form->error($model,'encoding'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'currency'); ?>
		<?php echo $form->dropDownList($model,'currency',Yii::app()->params['currency']);	?>
		<?php echo $form->error($model,'currency'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'exchange_rate'); ?>
		<?php echo $form->textField($model,'exchange_rate',array('size'=>9,'maxlength'=>9)); ?>
		<?php echo $form->error($model,'exchange_rate'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'delivery_cost_correction'); ?>
		<?php echo $form->textField($model,'delivery_cost_correction',array('size'=>8,'maxlength'=>8)); ?>
		<?php echo $form->error($model,'delivery_cost_correction'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'delivery_time_correction'); ?>
		<?php echo $form->textField($model,'delivery_time_correction'); ?>
		<?php echo $form->error($model,'delivery_time_correction'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->