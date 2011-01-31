<?php
$this->breadcrumbs=array(
	'News',
);
$this->pageTitle=Yii::app()->name.' - News';

$this->admin_menu=array(
	array('label'=>'Create Post', 'url'=>array('create')),
	array('label'=>'Manage Post', 'url'=>array('admin')),
);
?>

<h1>Recent posts</h1>
	<?php $this->widget('zii.widgets.CListView', array(
		'dataProvider'=>$dataProvider,
		'itemView'=>'_view',
	)); ?>
