<?php
$this->breadcrumbs=array(
	'Settings'=>array('index'),
	$model->key,
);

$this->menu=array(
	array('label'=>'List Settings', 'url'=>array('index')),
	array('label'=>'Create Settings', 'url'=>array('create')),
	array('label'=>'Update Settings', 'url'=>array('update', 'id'=>$model->key)),
	array('label'=>'Delete Settings', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->key),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage Settings', 'url'=>array('admin')),
);
?>

<h1>View Settings #<?php echo $model->key; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'key',
		'value',
	),
)); ?>
