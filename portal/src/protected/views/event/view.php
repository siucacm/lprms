<?php
$this->breadcrumbs=array(
	'Events'=>array('index'),
	$model->name,
);

$this->menu=array(
	array('label'=>'List Event', 'url'=>array('index')),
	array('label'=>'Create Event', 'url'=>array('create')),
	array('label'=>'Update Event', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete Event', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage Event', 'url'=>array('admin')),
);
?>

<h1><?php echo $model->name; ?></h1>

<div class="box">
    <div class="tabber">
        <div class="tabbertab" title="Details">
            <div class="location_map">

            </div>
            <div class="status">
                <span class="textheader">Where</span>
                <span class="location"><?php echo $model->location->name; ?></span><br />

                <span class="textheader">When</span>
                <b>Start:</b> <?php echo date('America/Chicago', strtotime($model->datetime_start)); ?><br />
                <b>End:</b> <?php echo date('America/Chicago', strtotime($model->datetime_end)); ?><br />
                <b>Duration:</b> hours
            </div>
        </div>
        <div class="tabbertab" title="Information">
            <?php echo $model->information; ?>
        </div>
        <div class="tabbertab" title="Location Map">
            
        </div>
        <div class="tabbertab" title="Seating Map">
        </div>
        <div class="tabbertab" title="Tournaments">
        </div>
        <div class="tabbertab" title="Attendees">
        </div>
        <div class="tabbertab" title="Register">
        </div>
    </div>
</div>

<?php /* $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'name',
		'sanitized',
		'datetime_start',
		'datetime_end',
		'price',
		'id_location',
		'id_map',
		'capacity',
		'information',
		'reminder',
		'agreement',
		'min_age',
	),
)); */ ?>
