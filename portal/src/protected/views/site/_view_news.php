<div class="view">
	<h2><?php echo CHtml::encode($data->title); ?></h2>
	<small><?php if ($data->author != null) echo 'Posted by '.CHtml::encode($data->author->username);?> | 
	<?php echo CHtml::encode(date('M j, Y @ g:iA', strtotime($data->timestamp))); ?></small>
	<hr />
	<?php echo CHtml::encode($data->abstract); ?>
</div>