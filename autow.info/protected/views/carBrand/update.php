<?php
/* @var $this CarBrandController */
/* @var $model CarBrand */

$this->breadcrumbs=array(
	'Car Brands'=>array('index'),
	$model->name=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List CarBrand', 'url'=>array('index')),
	array('label'=>'Create CarBrand', 'url'=>array('create')),
	array('label'=>'View CarBrand', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage CarBrand', 'url'=>array('admin')),
);
?>

<h1>Update CarBrand <?php echo $model->id; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>