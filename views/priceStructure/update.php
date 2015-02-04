<?php
/* @var $this PriceStructureController */
/* @var $model PriceStructure */

$this->breadcrumbs=array(
	'File Structures'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List PriceStructure', 'url'=>array('index')),
	array('label'=>'Create PriceStructure', 'url'=>array('create')),
	array('label'=>'View PriceStructure', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage PriceStructure', 'url'=>array('admin')),
);
?>

<h1>Update PriceStructure <?php echo $model->id; ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>

<?php
	// display modal window with information about the result of saving
	$this->beginWidget('zii.widgets.jui.CJuiDialog', array(
		'id' => 'mydialog',
		'options' => array(
			'autoOpen' => Yii::app()->user->hasFlash('successDataSave'),
			'resizable' => 'false',
			'modal' => 'true',
			'buttons' => array(array('text'=>'Close', 'click'=>'js:function(){$(this).dialog("close")}')),
			'htmlOptions' => array('class'=>'mynewclass','id'=>'mynewid'),
			'columns'=>array(
				'id',
				'activity',
				'rating',
			),	
			),
		)
	);

	echo Yii::app()->user->getFlash('successDataSave');
	
	$this->endWidget('zii.widgets.jui.CJuiDialog');
?>

<?PHP
	if($dataProvider){
		$this->widget('zii.widgets.grid.CGridView', 
			array(
				'dataProvider' => $dataProvider,
			)
		);
	}	
?>		