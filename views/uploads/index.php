<?php
/* @var $this UploadsController */
/* @var $myArray  array with keys and values are names of the firms*/

$this->breadcrumbs = array(
    'Uploads',
);
?>

<h1>Price loading</h1>

<?php
echo "<strong>" . CHtml::label('Chose desired price lists ', false) . "</strong><br>";
?>

<?php
// display checkbox list of firms for processing
echo CHtml::checkBoxList('checkbox_list_name', '', $myArray, array('checkAll' => 'Check all', 'checkAllLast' => true,));
?>

<?php
//widget for progressbar
$this->widget('zii.widgets.jui.CJuiProgressBar', array(
        'value' => 0,
        'htmlOptions' => array(
            'style' => 'height:20px; width:404px; display:block;',
            'id' => 'myProgress',
        ),
    )
);
// add javascript for processing data on client side 
$url=Yii::app()->createUrl('uploads/FileProcesing');
Yii::app()->clientScript->registerScript(
    'baseUrl',
    'baseUrl="'.$url.'";
    ',CClientScript::POS_HEAD
);
Yii::app()->clientScript->registerScriptFile(
    Yii::app()->assetManager->publish(Yii::app()->basePath.'/views/uploads/assets/progressBar.js'), 
    CClientScript::POS_HEAD
);
?>
</br>
<?php
echo CHtml::htmlButton('Start processing', array('id' => 'test_button'));
