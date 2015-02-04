<?php
/* @var $this PriceStructureController */
/* @var $model PriceStructure */

$this->breadcrumbs=array(
	'File Structures'=>array('index'),
	$model->firm,
);

$this->menu=array(
	array('label'=>'List PriceStructure', 'url'=>array('index')),
	array('label'=>'Create PriceStructure', 'url'=>array('create')),
	array('label'=>'Update PriceStructure', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete PriceStructure', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage PriceStructure', 'url'=>array('admin')),
);
?>

<h1>View structure of <?php echo $model->firm; ?> price.</h1>

<?php 
	$this->widget('zii.widgets.CDetailView', array(
		'data'=>$model,
		'attributes'=>array(
			'id',
			'firm',
			'item_id',
			'name',
			'description',
			'availability',
			'price',
			'bonus',
			'shipping_cost',
			'product_page',
			'sourse_page',
		),
	)); 
?>

<?php 
	if($dataProvider){
		$this->widget('zii.widgets.grid.CGridView', array(
  			'dataProvider' => $dataProvider,
  			'showTableOnEmpty'=>'true',
		));
	}	
?>
