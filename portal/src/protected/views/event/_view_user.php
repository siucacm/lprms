<div class="view">
	<div style="float: left; margin-right: 20px;">
		<?php echo CHtml::link($data->img, array('/people/'.$data->username)); ?>
	</div>
	<div style="height: 100px; margin-left: 10px;">
	<b><?php echo CHtml::link(CHtml::encode($data->gamertag), array('/people/'.$data->username)); ?></b><br />
	<?php if ($data->steam != null) echo CHtml::encode($data->steam->id_username); ?><br />
	<?php if ($data->xfire != null) echo CHtml::encode($data->xfire->username); ?><br />
	Registered for <?php echo count($data->events); ?> event(s)
	</div>

	<?php /*
	<b><?php echo CHtml::encode($data->getAttributeLabel('id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->id), array('view', 'id'=>$data->id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('first_name')); ?>:</b>
	<?php echo CHtml::encode($data->first_name); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('last_name')); ?>:</b>
	<?php echo CHtml::encode($data->last_name); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('email')); ?>:</b>
	<?php echo CHtml::encode($data->email); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('username')); ?>:</b>
	<?php echo CHtml::encode($data->username); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('password')); ?>:</b>
	<?php echo CHtml::encode($data->password); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('phone')); ?>:</b>
	<?php echo CHtml::encode($data->phone); ?>
	<br />


	<b><?php echo CHtml::encode($data->getAttributeLabel('birthday')); ?>:</b>
	<?php echo CHtml::encode($data->birthday); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('gamertag')); ?>:</b>
	<?php echo CHtml::encode($data->gamertag); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('blurb')); ?>:</b>
	<?php echo CHtml::encode($data->blurb); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('id_role')); ?>:</b>
	<?php echo CHtml::encode($data->id_role); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('datetime_join')); ?>:</b>
	<?php echo CHtml::encode($data->datetime_join); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('active')); ?>:</b>
	<?php echo CHtml::encode($data->active); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('hash')); ?>:</b>
	<?php echo CHtml::encode($data->hash); ?>
	<br />

	*/ ?>

</div>