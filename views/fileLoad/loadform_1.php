<?php 
	echo CHtml::form('','post',array('enctype'=>'multipart/form-data'));
	echo CHtml::activeFileField($model, 'csvFile');
	echo CHtml::submitButton('Submit');
	echo CHtml::endForm();
?>	
</br>	
<?php
	if($fileName){
		if($isLoaded){	echo 'File '.$model->fileName->getName().' has been loaded successfully.'; }
		else 
			echo 'File loading error.';	
	}	
