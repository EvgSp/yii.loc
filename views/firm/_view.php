<?php
/* @var $this FileController */
/* @var $data File */
?>

<div class="view">

	<b class="span-4"><?php echo CHtml::encode($data->getAttributeLabel('id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->id), array('view', 'id'=>$data->id)); ?>
	<br />

	<b class="span-4"><?php echo CHtml::encode($data->getAttributeLabel('firm_name')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->firm_name), array('view', 'id'=>$data->id)); ?>
	<br />
        
        <b class="span-4"><?php echo CHtml::encode($data->getAttributeLabel('activity')); ?>:</b>
	<?php echo CHtml::encode($data->activity); ?>
	<br />

	<b class="span-4"><?php echo CHtml::encode($data->getAttributeLabel('rating')); ?>:</b>
	<?php echo CHtml::encode($data->rating); ?>
	<br />

	<b class="span-4"><?php echo CHtml::encode($data->getAttributeLabel('file_name')); ?>:</b>
	<?php echo CHtml::encode($data->file_name); ?>
	<br />

	<b class="span-4"><?php echo CHtml::encode($data->getAttributeLabel('file_type')); ?>:</b>
	<?php echo CHtml::encode($data->file_type); ?>
	<br />

	<b class="span-4"><?php echo CHtml::encode($data->getAttributeLabel('column_ceparator')); ?>:</b>
	<?php echo CHtml::encode($data->column_ceparator); ?>
	<br />

	<b class="span-4"><?php echo CHtml::encode($data->getAttributeLabel('text_ceparator')); ?>:</b>
	<?php echo CHtml::encode($data->text_ceparator); ?>
	<br />

	<?php /*
	<b class="span-4"><?php echo CHtml::encode($data->getAttributeLabel('encoding')); ?>:</b>
	<?php echo CHtml::encode($data->encoding); ?>
	<br />

	<b class="span-4"><?php echo CHtml::encode($data->getAttributeLabel('currency')); ?>:</b>
	<?php echo CHtml::encode($data->currency); ?>
	<br />

	<b class="span-4"><?php echo CHtml::encode($data->getAttributeLabel('exchange_rate')); ?>:</b>
	<?php echo CHtml::encode($data->exchange_rate); ?>
	<br />

	<b class="span-4"><?php echo CHtml::encode($data->getAttributeLabel('delivery_cost_correction')); ?>:</b>
	<?php echo CHtml::encode($data->delivery_cost_correction); ?>
	<br />

	<b class="span-4"><?php echo CHtml::encode($data->getAttributeLabel('delivery_time_correction')); ?>:</b>
	<?php echo CHtml::encode($data->delivery_time_correction); ?>
	<br />

	*/ ?>

</div>