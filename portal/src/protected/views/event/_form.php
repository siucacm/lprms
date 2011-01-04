<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'event-form',
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'name'); ?>
		<?php echo $form->textField($model,'name',array('size'=>32,'maxlength'=>32)); ?>
		<?php echo $form->error($model,'name'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'sanitized'); ?>
		<?php echo $form->textField($model,'sanitized',array('size'=>32,'maxlength'=>32)); ?>
		<?php echo $form->error($model,'sanitized'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'datetime_start'); ?>
		<?php echo $form->textField($model,'datetime_start'); ?>
		<?php echo $form->error($model,'datetime_start'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'datetime_end'); ?>
		<?php echo $form->textField($model,'datetime_end'); ?>
		<?php echo $form->error($model,'datetime_end'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'price'); ?>
		<?php echo $form->textField($model,'price',array('size'=>5,'maxlength'=>5)); ?>
		<?php echo $form->error($model,'price'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'id_location'); ?>
		<?php echo $form->textField($model,'id_location',array('size'=>10,'maxlength'=>10)); ?>
		<?php echo $form->error($model,'id_location'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'id_map'); ?>
		<?php echo $form->textField($model,'id_map',array('size'=>10,'maxlength'=>10)); ?>
		<?php echo $form->error($model,'id_map'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'capacity'); ?>
		<?php echo $form->textField($model,'capacity',array('size'=>10,'maxlength'=>10)); ?>
		<?php echo $form->error($model,'capacity'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'information'); ?>
		<?php echo $form->textArea($model,'information',array('rows'=>6, 'cols'=>50)); ?>
		<?php echo $form->error($model,'information'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'reminder'); ?>
		<?php echo $form->textArea($model,'reminder',array('rows'=>6, 'cols'=>50)); ?>
		<?php echo $form->error($model,'reminder'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'agreement'); ?>
		<?php echo $form->textArea($model,'agreement',array('rows'=>6, 'cols'=>50)); ?>
		<?php echo $form->error($model,'agreement'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'min_age'); ?>
		<?php echo $form->textField($model,'min_age'); ?>
		<?php echo $form->error($model,'min_age'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->