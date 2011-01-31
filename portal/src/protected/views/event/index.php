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
	<table class="table_list">
		<tr>
			<th>Status</th>
			<th>Event</th>
			<th>When</th>
			<th>Duration</th>
			<th>Location</th>
			<th>Price</th>
			<th>Capacity</th>
		</tr>
	<?php $this->widget('zii.widgets.CListView', array(
		'dataProvider'=>$dataProvider1,
		'itemView'=>'_view',
	)); ?>
	</table>
	<br /><br />
		<table class="table_list">
		<tr>
			<th>Status</th>
			<th>Event</th>
			<th>When</th>
			<th>Duration</th>
			<th>Location</th>
			<th>Price</th>
			<th>Capacity</th>
		</tr>
	<?php $this->widget('zii.widgets.CListView', array(
		'dataProvider'=>$dataProvider2,
		'itemView'=>'_view',
	)); ?>
	</table>
