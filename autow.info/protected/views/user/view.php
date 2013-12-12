<?php
/* @var $this UserController */
/* @var $model User */

$this->breadcrumbs=array(
	'Users'=>array('index'),
	$model->name,
);

$this->menu=array(
//	array('label'=>'List User', 'url'=>array('index')),
//	array('label'=>'Create User', 'url'=>array('create')),
//	array('label'=>'Update User', 'url'=>array('update', 'id'=>$model->id)),
//	array('label'=>'Delete User', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
//	array('label'=>'Manage User', 'url'=>array('admin')),
);
if(Yii::app()->user->checkAccess('readUser')) {
    $this->menu[] = array(
        'label'=>'List Users',
        'url'=>array('index')
    );
}
if(Yii::app()->user->checkAccess('createUser')) {
    $this->menu[] = array(
        'label'=>'Create User',
        'url'=>array('create')
    );
}
if(Yii::app()->user->checkAccess('updateUser')) {
    $this->menu[] = array(
        'label'=>'Update User',
        'url'=>array('update', 'id'=>$model->id)
    );
}
if(Yii::app()->user->checkAccess('deleteUser')) {
    $this->menu[] = array(
        'label'=>'Delete User',
        'url'=>'#',
        'linkOptions'=> array(
            'submit'=> array('delete','id'=>$model->id),
            'confirm'=>'Are you sure you want to delete this item?'
        ),
    );
}
?>

<h1>View User #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'name',
		'username',
		'email',
		'password',
		'role',
		'create_time',
	),
)); ?>
