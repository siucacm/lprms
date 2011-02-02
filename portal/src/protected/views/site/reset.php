<h1>Reset Code</h1>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'user-reset-form',
	'enableAjaxValidation'=>true,
)); ?>
	<?php if ($model->reset == NULL) { ?>
	Please enter your reset code, and the new password for your account.
	<?php } else { ?>
	Please enter a new password for your account.
	<?php } ?>

	<?php echo $form->errorSummary($model); ?>

		<?php if ($model->reset == NULL) { ?>
		<div class="row">
			<?php echo $form->labelEx($model,'reset'); ?>
			<?php echo $form->textField($model,'reset'); ?>
			<?php echo $form->error($model,'reset'); ?>
		</div>
		<?php } else {
			echo $form->hiddenField($model,'reset');
		} ?>
		<div class="row">
			<div style="width: 100px; float: left;">
				<?php echo $form->labelEx($model,'password1'); ?>
				<?php echo $form->passwordField($model,'password1'); ?>
				<?php echo $form->error($model,'password1'); ?>
			</div>
			
			<div style="margin-left: 300px;">
				<?php echo $form->labelEx($model,'password2'); ?>
				<?php echo $form->passwordField($model,'password2'); ?>
				<?php echo $form->error($model,'password2'); ?>
			</div>
		</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton('Submit'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->