<?php
/* @var $this CarModelController */
/* @var $model CarModel */

$this->breadcrumbs=array(
	'Car Models'=>array('index'),
	$model->name=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List CarModel', 'url'=>array('index')),
	array('label'=>'Create CarModel', 'url'=>array('create')),
	array('label'=>'View CarModel', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage CarModel', 'url'=>array('admin')),
);
?>

<h1>Update CarModel <?php echo $model->id; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>