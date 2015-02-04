<?php
/* @var $this FileController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Firm',
);

$this->menu=array(
	array('label'=>'Create File', 'url'=>array('create')),
	array('label'=>'Manage File', 'url'=>array('admin')),
);
?>

<h1>Firm</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
