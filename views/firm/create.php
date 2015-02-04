<?php
/* @var $this FileController */
/* @var $model File */

$this->breadcrumbs=array(
	'Firm'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List of Firms', 'url'=>array('index')),
	array('label'=>'Manage Firm', 'url'=>array('admin')),
);
?>

<h1>Create File</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>