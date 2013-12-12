<?php
/* @var $this CarModelController */
/* @var $model CarModel */

$this->breadcrumbs=array(
	'Car Models'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List CarModel', 'url'=>array('index')),
	array('label'=>'Manage CarModel', 'url'=>array('admin')),
);
?>

<h1>Create CarModel</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>