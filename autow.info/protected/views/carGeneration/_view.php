<?php
/* @var $this CarGenerationController */
/* @var $data CarGeneration */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('name')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->name), array('carGeneration/view', 'id'=>$data->id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('car_model_id')); ?>:</b>
	<?php echo CHtml::encode($data->car_model_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('name')); ?>:</b>
	<?php echo CHtml::encode($data->name); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('production_period')); ?>:</b>
	<?php echo CHtml::encode($data->production_period); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('production_from')); ?>:</b>
	<?php echo CHtml::encode($data->production_from); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('production_to')); ?>:</b>
	<?php echo CHtml::encode($data->production_to); ?>
	<br />


</div>