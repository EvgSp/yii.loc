<?php
/* @var $this PriceStructureController */
/* @var $model PriceStructure */
/* @var $form CActiveForm */
?>

<div class="wide form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'file-structure-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'firm'); ?>
		<?php // echo $form->textField($model,'file_id'); ?>
		<?php echo $form->dropDownList($model,'firm', CHtml::listData(Firm::model()->findAll(), 'firm_name', 'firm_name')); ?>
		<?php echo $form->error($model,'firm'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'item_id'); ?>
		<?php echo $form->textField($model,'item_id'); ?>
		<?php echo $form->error($model,'item_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'name'); ?>
		<?php echo $form->textField($model,'name'); ?>
		<?php echo $form->error($model,'name'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'description'); ?>
		<?php echo $form->textField($model,'description'); ?>
		<?php echo $form->error($model,'description'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'availability'); ?>
		<?php echo $form->textField($model,'availability'); ?>
		<?php echo $form->error($model,'availability'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'price'); ?>
		<?php echo $form->textField($model,'price'); ?>
		<?php echo $form->error($model,'price'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'bonus'); ?>
		<?php echo $form->textField($model,'bonus'); ?>
		<?php echo $form->error($model,'bonus'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'shipping_cost'); ?>
		<?php echo $form->textField($model,'shipping_cost'); ?>
		<?php echo $form->error($model,'shipping_cost'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'product_page'); ?>
		<?php echo $form->textField($model,'product_page'); ?>
		<?php echo $form->error($model,'product_page'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'sourse_page'); ?>
		<?php echo $form->textField($model,'sourse_page'); ?>
		<?php echo $form->error($model,'sourse_page'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->