<?php
$this->breadcrumbs=array(
	'Maps'=>array('index'),
	$model->id,
);

$this->menu=array(
	array('label'=>'List Map', 'url'=>array('index')),
	array('label'=>'Create Map', 'url'=>array('create')),
	array('label'=>'Update Map', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete Map', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage Map', 'url'=>array('admin')),
);
?>

<h1>View Map #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'xml',
		'type',
	),
)); ?>
