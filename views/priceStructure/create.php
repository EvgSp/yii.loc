<?php
/* @var $this PriceStructureController */
/* @var $model PriceStructure */

$this->breadcrumbs=array(
	'File Structures'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List PriceStructure', 'url'=>array('index')),
	array('label'=>'Manage PriceStructure', 'url'=>array('admin')),
);
?>

<h1>Create PriceStructure</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>