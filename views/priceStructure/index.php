<?php
/* @var $this PriceStructureController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'File Structures',
);

$this->menu=array(
	array('label'=>'Create PriceStructure', 'url'=>array('create')),
	array('label'=>'Manage PriceStructure', 'url'=>array('admin')),
);
?>

<h1>File Structures</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
