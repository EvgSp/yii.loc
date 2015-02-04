<?php
/* @var $this PriceStructureController */
/* @var $model PriceStructure */

$this->breadcrumbs=array(
	'File Structures'=>array('index'),
	'Manage',
);

$this->menu=array(
	array('label'=>'List PriceStructure', 'url'=>array('index')),
	array('label'=>'Create PriceStructure', 'url'=>array('create')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$('#file-structure-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1>Manage File Structures</h1>

<p>
You may optionally enter a comparison operator (<b>&lt;</b>, <b>&lt;=</b>, <b>&gt;</b>, <b>&gt;=</b>, <b>&lt;&gt;</b>
or <b>=</b>) at the beginning of each of your search values to specify how the comparison should be done.
</p>

<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'file-structure-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		'id',
		'firm',
		'item_id',
		'name',
		'description',
		'availability',
		/*
		'price',
		'bonus',
		'shipping_cost',
		'product_page',
		'sourse_page',
		*/
		array(
			'class'=>'CButtonColumn',
		),
	),
)); ?>
