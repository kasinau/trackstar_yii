<?php
/* @var $this CarGenerationController */
/* @var $model CarGeneration */

$this->breadcrumbs=array(
	'Car Generations'=>array('index'),
	$model->name=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List CarGeneration', 'url'=>array('index')),
	array('label'=>'Create CarGeneration', 'url'=>array('create')),
	array('label'=>'View CarGeneration', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage CarGeneration', 'url'=>array('admin')),
);
?>

<h1>Update CarGeneration <?php echo $model->id; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>