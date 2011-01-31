<?php
$this->breadcrumbs=array(
	'Settings'=>array('index'),
	$model->key=>array('view','id'=>$model->key),
	'Update',
);

$this->menu=array(
	array('label'=>'List Settings', 'url'=>array('index')),
	array('label'=>'Create Settings', 'url'=>array('create')),
	array('label'=>'View Settings', 'url'=>array('view', 'id'=>$model->key)),
	array('label'=>'Manage Settings', 'url'=>array('admin')),
);
?>

<h1>Update Settings <?php echo $model->key; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>