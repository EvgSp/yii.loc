<?php
/* @var $this FileController */
/* @var $model File */

$this->breadcrumbs = array(
    'Firm' => array('index'),
    $model->id,
);

$this->menu = array(
    array('label' => 'List of Firms', 'url' => array('index')),
    array('label' => 'Create Firm', 'url' => array('create')),
    array('label' => 'Update Firm', 'url' => array('update', 'id' => $model->id)),
    array('label' => 'Delete Firm', 'url' => '#', 'linkOptions' => array('submit' => array('delete', 'id' => $model->id), 'confirm' => 'Are you sure you want to delete this item?')),
    array('label' => 'Manage Firm', 'url' => array('admin')),
);
?>

<h1>View File #<?php echo $model->id; ?></h1>

<?php
$this->widget('zii.widgets.CDetailView', array(
    'data' => $model,
    'attributes' => array(
        'id',
        'firm_name',
        'activity',
        'rating',
        'file_name',
        'file_type',
        'column_ceparator',
        'text_ceparator',
        'encoding',
        'currency',
        'exchange_rate',
        'delivery_cost_correction',
        'delivery_time_correction',
    ),
));
?>


<?php
if ($dataProvider) {  // file exist
    $this->widget('zii.widgets.grid.CGridView', array(
        'dataProvider' => $dataProvider,
    ));
}
?>