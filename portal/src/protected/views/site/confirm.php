<h1>Confirmation Code</h1>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'user-confirm-form',
	'enableAjaxValidation'=>false,
)); ?>

	Thank you for registering! Please check your e-mail for the confirmation code to activate your account.

	<?php echo $form->errorSummary($model); ?>

		<div class="row">
			<?php echo $form->labelEx($model,'confirm'); ?>
			<?php echo $form->textField($model,'confirm'); ?>
			<?php echo $form->error($model,'confirm'); ?>
		</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton('Submit'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->