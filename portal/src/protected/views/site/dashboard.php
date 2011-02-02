<?php
$this->pageTitle=Yii::app()->name . ' - Dashboard';
$this->breadcrumbs=array(
	'Dashboard',
);
?>
<h1>Dashboard</h1>

<p><?php if (isset($_GET['extra']) && $_GET['extra'] == 'active') echo 'Your account is now activated.'; ?></p>
<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'user-dashboard',
	'enableAjaxValidation'=>true,
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>
	
<div class="box">
    <div class="tabber">
        <div class="tabbertab" title="Summary">
            <div style="float: left; margin-right: 20px;">
				<?php echo CHtml::link($model->pullUser()->img, array('view', 'username'=>$model->pullUser()->username)); ?>
			</div>
			<div style="height: 100px; margin-left: 10px;">
			<b><?php echo CHtml::link(CHtml::encode($model->pullUser()->gamertag), array('view', 'username'=>$model->pullUser()->username)); ?></b><br />
			<?php if ($model->pullUser()->steam != null) echo CHtml::encode($model->pullUser()->steam->id_username); ?><br />
			<?php if ($model->pullUser()->xfire != null) echo CHtml::encode($model->pullUser()->xfire->username); ?><br />
			Registered for <?php echo count($model->pullUser()->events); ?> event(s)
			</div>
        </div>
        <div class="tabbertab" title="Account Information">
            <div class="row">
				<?php echo $form->labelEx($model,'gamertag'); ?>
				<?php echo $form->textField($model,'gamertag',array('size'=>60,'maxlength'=>64)); ?>
				<?php echo $form->error($model,'gamertag'); ?>
			</div>

			<div class="rowRadio">
				<?php echo $form->labelEx($model,'img_type'); ?><br />
				<?php echo $form->radioButtonList($model,'img_type',User::imgTypeList()); ?>
				<?php echo $form->error($model,'img_type'); ?>
			</div>

			<div class="row">
				<?php echo $form->labelEx($model,'email'); ?>
				<?php echo $form->textField($model,'email',array('size'=>60,'maxlength'=>64)); ?>
				<?php echo $form->error($model,'email'); ?>
			</div>

			<div class="row" style="height: 60px">
				<div style="width: 250px; float: left;">
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
			
			<div class="row">
				<?php echo $form->labelEx($model,'blurb'); ?>
				<?php echo $form->textArea($model,'blurb',array('rows'=>6, 'cols'=>50)); ?>
				<?php echo $form->error($model,'blurb'); ?>
			</div>
        </div>
        <div class="tabbertab" title="Personal Details">
            <div class="row">
				<?php echo $form->labelEx($model,'first_name'); ?>
				<?php echo $form->textField($model,'first_name',array('size'=>24,'maxlength'=>24)); ?>
				<?php echo $form->error($model,'first_name'); ?>
			</div>

			<div class="row">
				<?php echo $form->labelEx($model,'last_name'); ?>
				<?php echo $form->textField($model,'last_name',array('size'=>24,'maxlength'=>24)); ?>
				<?php echo $form->error($model,'last_name'); ?>
			</div>

			<div class="row">
				<?php echo $form->labelEx($model,'phone'); ?>
				<?php echo $form->textField($model,'phone',array('size'=>20,'maxlength'=>20)); ?>
				<?php echo $form->error($model,'phone'); ?>
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
        </div>
        <div class="tabbertab" title="Social Networking">
			<div class="row">
				<div style="width: 100px; float: left;">
				<?php echo $form->labelEx($model,'steam_id'); ?>
				<?php echo $form->textField($model,'steam_id'); ?>
				<?php echo $form->error($model,'steam_id'); ?>
				</div>
				
				<div style="margin-left: 300px;">
				<?php echo $form->labelEx($model,'steam_numeric'); ?>
				<?php echo $form->textField($model,'steam_numeric'); ?>
				<?php echo $form->error($model,'steam_numeric'); ?>
				</div>
			</div>

			<div class="row">
				<?php echo $form->labelEx($model,'xfire_id'); ?>
				<?php echo $form->textField($model,'xfire_id'); ?>
				<?php echo $form->error($model,'xfire_id'); ?>
			</div>

			<div class="row">
				<?php echo $form->labelEx($model,'live_id'); ?>
				<?php echo $form->textField($model,'live_id'); ?>
				<?php echo $form->error($model,'live_id'); ?>
			</div>
        </div>
        <div class="tabbertab" title="Events">
        </div>
        <div class="tabbertab" title="Tournaments">
		Coming Soon
        </div>
    </div>
</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton('Save'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->