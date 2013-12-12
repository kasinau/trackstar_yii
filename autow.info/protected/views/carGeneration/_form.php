<?php
/* @var $this CarGenerationController */
/* @var $model CarGeneration */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'car-generation-form',
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->hiddenField($model,'car_model_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'name'); ?>
		<?php echo $form->textField($model,'name',array('size'=>60,'maxlength'=>128)); ?>
		<?php echo $form->error($model,'name'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'production_period'); ?>
		<?php echo $form->textField($model,'production_period',array('size'=>20,'maxlength'=>20)); ?>
		<?php echo $form->error($model,'production_period'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'production_from'); ?>
		<?php echo $form->textField($model,'production_from',array('size'=>20,'maxlength'=>20)); ?>
		<?php echo $form->error($model,'production_from'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'production_to'); ?>
		<?php echo $form->textField($model,'production_to',array('size'=>20,'maxlength'=>20)); ?>
		<?php echo $form->error($model,'production_to'); ?>
	</div>

    <div class="row">
        <?php echo $form->labelEx($model,'description'); ?>
        <?php echo $form->textArea($model,'description', array('rows' => 10, 'cols' => 60)); ?>
        <?php echo $form->error($model,'description'); ?>
    </div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->