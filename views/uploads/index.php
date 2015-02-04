<?php
/* @var $this UploadsController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs = array(
    'Uploads',
);
?>

<h1>Price loading</h1>

<?php
echo "<strong>" . CHtml::label('Chose desired price lists ', false) . "</strong><br>";

echo CHtml::checkBoxList('checkbox_list_name', '', $myArray, array('checkAll' => 'Check all', 'checkAllLast' => true,));

//file processing
$this->widget('zii.widgets.jui.CJuiProgressBar', array(
        'value' => 0,
        'htmlOptions' => array(
            'style' => 'height:20px; width:404px; display:block;',
            'id' => 'myProgress',
        ),
    )
);

Yii::app()->clientScript->registerScript('progress_auto_update', "
    $(\"#test_button\").click(function(e){
        var arrFirms = [];
        var listFirms = '';
        $(\"input[name='checkbox_list_name\[\]']:checked\").each(function(){
            arrFirms.push($(this).val())}); 
        for (var i = 0; i < arrFirms.length; i++) {
            listFirms += '/f'+i+'/'+arrFirms[i];
        }            
	var pI=window.setInterval(function(){
            $.ajax({
		type: \"GET\",
  		url: '" . Yii::app()->createUrl('uploads/FileProcesing') . "'+listFirms,
	  	success: function (val) {
                    for (var i = 0; i < arrFirms.length; i++) {
                        var localVal=val-i*100;
                        if (val-i*100 <= 100) {
                            break;
                        }    
                    }            
                    
                    if (localVal <= 100){
			$('#myProgress').children('div').text(localVal+'%');
			$('#myProgress').progressbar(\"option\", \"value\", localVal);	
                    }
                    else{
                        $('#myProgress').children('div').text(100+'%');
                        $('#myProgress').progressbar(\"option\", \"value\", 100);
                        window.clearInterval(pI);
                    }
                    listFirms='';
		}			
            })
	}, 1000);	
    });", CClientScript::POS_READY
);
?>
</br>
<?php
echo CHtml::htmlButton('Start processing', array('id' => 'test_button'));
