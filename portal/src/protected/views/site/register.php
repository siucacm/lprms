<?php
$this->pageTitle=Yii::app()->name . ' - Register';
$this->breadcrumbs=array(
	'Register',
);
?>

<h1>Register</h1>
<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'user-register-form',
	'enableAjaxValidation'=>true,
)); ?>

	<p class="note">Forgot your password? <?php echo CHtml::link('Click here to reset your password.', '/account/forget'); ?></p>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'username'); ?>
		<?php echo $form->textField($model,'username'); ?>
		<?php echo $form->error($model,'username'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'email'); ?>
		<?php echo $form->textField($model,'email'); ?>
		<?php echo $form->error($model,'email'); ?>
	</div>

	<div class="row" style="height: 60px">
		<div style="width: 200px; float: left;">
			<?php echo $form->labelEx($model,'password1'); ?>
			<?php echo $form->passwordField($model,'password1'); ?>
			<?php echo $form->error($model,'password1'); ?>
		</div>
		
		<div style="margin-left: 300px;">
			<?php echo $form->labelEx($model,'dummylabel'); ?>
			<?php echo $form->passwordField($model,'password2'); ?>
			<?php echo $form->error($model,'password2'); ?>
		</div>
	</div>
	
	<div class="row">
		<?php echo $form->labelEx($model,'first_name'); ?>
		<?php echo $form->textField($model,'first_name'); ?>
		<?php echo $form->error($model,'first_name'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'last_name'); ?>
		<?php echo $form->textField($model,'last_name'); ?>
		<?php echo $form->error($model,'last_name'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'birthday'); ?>
		<?php echo $form->dropDownList($model,'day',User::dayList()); ?>
		<?php echo $form->error($model,'day'); ?>
		<?php echo $form->dropDownList($model,'month',User::monthList()); ?>
		<?php echo $form->error($model,'month'); ?>
		<?php echo $form->dropDownList($model,'year',User::yearList()); ?>
		<?php echo $form->error($model,'year'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'gamertag'); ?>
		<?php echo $form->textField($model,'gamertag'); ?>
		<?php echo $form->error($model,'gamertag'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'phone'); ?>
		<?php echo $form->textField($model,'phone'); ?>
		<?php echo $form->error($model,'phone'); ?>
	</div>

	<h2>Which events do you want to attend?</h2>
	<div class="rowRadio">
		<?php $model->showActiveEvents($form); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton('Register'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->