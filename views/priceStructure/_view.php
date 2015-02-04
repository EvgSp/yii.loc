<?php
/* @var $this PriceStructureController */
/* @var $data PriceStructure */
?>

<div class="view">

	<b class="span-4"><?php echo CHtml::encode($data->getAttributeLabel('id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->id), array('view', 'id'=>$data->id)); ?>
	<br />

	<b class="span-4"><?php echo CHtml::encode($data->getAttributeLabel('firm')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->firm), array('view', 'id'=>$data->id));?>
	<br /><br />

	<?php if($item_id=CHtml::encode($data->item_id)) { ?>
	<b class="span-4"><?php echo CHtml::encode($data->getAttributeLabel('item_id')); ?>:</b>
	<?php echo $item_id; ?>
	<br />
        <?php } ?>

	<?php if($name=CHtml::encode($data->name)) { ?>
	<b class="span-4"><?php echo CHtml::encode($data->getAttributeLabel('name')); ?>:</b>
	<?php echo $name; ?>
	<br />
        <?php } ?>

	<?php if($description=CHtml::encode($data->description)) { ?>
	<b class="span-4"><?php echo CHtml::encode($data->getAttributeLabel('description')); ?>:</b>
	<?php echo $description; ?>
	<br />
        <?php } ?>

	<?php if($price=CHtml::encode($data->price)) { ?>
	<b class="span-4"><?php echo CHtml::encode($data->getAttributeLabel('price')); ?>:</b>
        <?php echo $price; ?>
	<br />
        <?php } ?>
        
	<?php if($availability=CHtml::encode($data->availability)) { ?>
        <b class="span-4"><?php echo CHtml::encode($data->getAttributeLabel('availability')); ?>:</b>
	<?php echo $availability; ?>
	<br />
        <?php } ?>

	<?php if($bonus=CHtml::encode($data->bonus)) { ?>
	<b class="span-4"><?php echo CHtml::encode($data->getAttributeLabel('bonus')); ?>:</b>
	<?php echo $bonus; ?>
	<br />
        <?php } ?>

	<?php if($shipping_cost=CHtml::encode($data->shipping_cost)) { ?>
	<b class="span-4"><?php echo CHtml::encode($data->getAttributeLabel('shipping_cost')); ?>:</b>
	<?php echo $shipping_cost; ?>
	<br />
        <?php } ?>

	<?php if($product_page=CHtml::encode($data->product_page)) { ?>
	<b class="span-4"><?php echo CHtml::encode($data->getAttributeLabel('product_page')); ?>:</b>
	<?php echo $product_page; ?>
	<br />
        <?php } ?>

	<?php if($sourse_page=CHtml::encode($data->sourse_page)) { ?>
        <b class="span-4"><?php echo CHtml::encode($data->getAttributeLabel('sourse_page')); ?>:</b>
        <?php echo $sourse_page; ?>
	<br />
        <?php } ?>


</div>