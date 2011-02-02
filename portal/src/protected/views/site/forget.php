<?php
$this->pageTitle=Yii::app()->name . ' - Forgot your password?';
$this->breadcrumbs=array(
	'Forgot your password?',
);
?>

<h1>Forgot your password?</h1>

<p>Enter your username or e-mail address to reset your password</p>

<div class="form">
<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'user-forget-form',
	'enableAjaxValidation'=>true,
)); ?>
	<?php echo $form->errorSummary($model); ?>
	<div class="row">
		<?php echo $form->labelEx($model,'email'); ?>
		<?php echo $form->textField($model,'email'); ?>
		<?php echo $form->error($model,'email'); ?>
	</div>
	<div class="row buttons">
		<?php echo CHtml::submitButton('Submit'); ?>
	</div>

<?php $this->endWidget(); ?>
</div><!-- form -->
<hr />

<div class="form">
<?php $form=$this->beginWidget('CActiveForm', array(
        'id'=>'user-forget-form',
        'enableAjaxValidation'=>false,
)); ?>
        <?php echo $form->errorSummary($model); ?>
        <div class="row">
                <?php echo $form->labelEx($model,'username'); ?>
                <?php echo $form->textField($model,'username'); ?>
                <?php echo $form->error($model,'username'); ?>
        </div>
        <div class="row buttons">
                <?php echo CHtml::submitButton('Submit'); ?>
        </div>

<?php $this->endWidget(); ?>
</div><!-- form -->

