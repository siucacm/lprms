<?php
$this->breadcrumbs=array(
	'Maps'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List Map', 'url'=>array('index')),
	array('label'=>'Create Map', 'url'=>array('create')),
	array('label'=>'View Map', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage Map', 'url'=>array('admin')),
);
?>

<h1>Update Map <?php echo $model->id; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>