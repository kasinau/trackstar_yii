<?php
/* @var $this CarBrandController */
/* @var $model CarBrand */

$this->breadcrumbs=array(
	'Car Brands'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List CarBrand', 'url'=>array('index')),
	array('label'=>'Manage CarBrand', 'url'=>array('admin')),
);
?>

<h1>Create CarBrand</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>