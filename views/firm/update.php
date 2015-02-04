<?php
/* @var $this FileController */
/* @var $model File */

$this->breadcrumbs=array(
	'Firm'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List of Firms', 'url'=>array('index')),
	array('label'=>'Create Firm', 'url'=>array('create')),
	array('label'=>'View Firm', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage Firm', 'url'=>array('admin')),
);
?>

<h1>Update File <?php echo $model->file_name; ?></h1>

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
		//	'htmlOptions' => array('class'=>'mynewclass','id'=>'mynewid'),
		//	'columns'=>array(
		//		'id',
		//		'activity',
		//		'rating',
		//	),	
		),
            )
	);

	echo Yii::app()->user->getFlash('successDataSave');
	
	$this->endWidget('zii.widgets.jui.CJuiDialog');
?>

<?php 
	if($dataProvider){
		$this->widget('zii.widgets.grid.CGridView', 
			array(
  				'dataProvider' => $dataProvider,
			)
		);
	}		
?>
