<?php
$this->breadcrumbs=array(
	'Events',
);
$this->pageTitle=Yii::app()->name.' - Events';

$this->admin_menu=array(
	array('label'=>'Create Event', 'url'=>array('create')),
	array('label'=>'Manage Event', 'url'=>array('admin')),
);
?>

<h1>Events</h1>
	<?php 
	$columnsArray = array(
		array(
			'name' => 'status',
			'value' => '$data->status',
			'type' => 'raw',
		),
		array(
			'name' => 'name',
			'header' => 'Event',
			'value' => 'CHtml::link($data->name, $data->url)',
			'type' => 'raw',
		),
		array(
			'name' => 'datetime_start',
			'header' => 'When',
			'value' => 'Event::getDateTime($data->datetime_start)',
		),
		array(
			'name' => 'duration',
			'value' => '$data->duration',
		),
		array(
			'name' => 'location',
			'value' => '($data->location != null)?$data->location->name:""',
		),
		array(
			'name' => 'price',
			'value' => '($data->price <= 0)?"Free!":"$".$data->price',
		),
		array(
			'name' => 'capacity',
			'value' => 'count($data->users)." / ".$data->capacity',
		),
	); ?>
	<?php $this->widget('zii.widgets.grid.CGridView', array(
		'dataProvider'=>$dataProvider1,
		'columns'=> $columnsArray,
		'itemsCssClass' => 'table_list',
		'enablePagination' => false,
		'enableSorting' => false,
	)); ?>
<h2>Previous Events</h2>
	<?php $this->widget('zii.widgets.grid.CGridView', array(
        'dataProvider'=>$dataProvider2,
        'columns'=> $columnsArray,
		'itemsCssClass' => 'table_list',
		'enablePagination' => false,
		'enableSorting' => false,
    )); ?>

