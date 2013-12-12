<?php
/* @var $this CarGenerationController */
/* @var $model CarGeneration */

$this->breadcrumbs=array(
	'Car Generations'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List CarGeneration', 'url'=>array('index')),
	array('label'=>'Manage CarGeneration', 'url'=>array('admin')),
);
?>

<h1>Create CarGeneration</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>