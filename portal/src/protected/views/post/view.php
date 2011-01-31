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
                <span class="location"><?php if ($model->location != null) echo $model->location->name; ?>
				<?php if ($model->location != null && $model->location->location != '') echo '('.$model->location->location.')'; ?>
				</span>
				<br />
					<?php if ($model->location != null) echo $model->location->address; ?>
                <span class="textheader">When</span>
                <b>Start:</b> <?php echo date('M j, Y @ g:iA', strtotime($model->datetime_start)); ?><br />
                <b>End:</b> <?php echo date('M j, Y @ g:iA', strtotime($model->datetime_end)); ?><br />
                <b>Duration:</b> <?php echo $model->duration; ?>
            </div>
        </div>
        <div class="tabbertab" title="Information">
            <pre><?php echo CHtml::encode($model->information); ?></pre>
        </div>
        <div class="tabbertab" title="Location Map">
            
        </div>
        <div class="tabbertab" title="Seating Map">
        </div>
        <div class="tabbertab" title="Tournaments">
		Coming Soon
        </div>
        <div class="tabbertab" title="Attendees">
		<?php //echo $model->users; 
			$uDataProvider=new CArrayDataProvider($model->users, array(
				'id'=>'user',
				'sort'=>array(
					'attributes'=>array(
						 'id', 'username', 'email',
					),
				),
			));
			$this->widget('zii.widgets.CListView', array(
				'dataProvider'=>$uDataProvider,
				'itemView'=>'_view_user',
			));
		?>
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
