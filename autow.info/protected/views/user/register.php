<?php
/* @var $this UserController */
/* @var $model User */

$this->breadcrumbs=array(
	'Users'=>array('index'),
	'Register',
);

//$this->menu=array(
//	array('label'=>'List User', 'url'=>array('index')),
//	array('label'=>'Manage User', 'url'=>array('admin')),
//);
?>

<h1>Register as a new user</h1>

<?php echo $this->renderPartial('_register_form', array('model'=>$model)); ?>