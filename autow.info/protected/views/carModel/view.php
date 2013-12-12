<?php
/* @var $this CarModelController */
/* @var $model CarModel */

$this->breadcrumbs=array(
	'Car Models'=>array('index'),
	$model->name,
);

$this->menu=array(
	array(
        'label'=>'List CarModel',
        'url'=>array(
            'index',
            'car_brand_id' => $model->carBrand->id,
        )
    ),
    array(
        'label'=>'List Model Generations',
        'url'=>array(
            'carGeneration/index',
            'car_model_id' => $model->id
        )
    ),
);
if(Yii::app()->user->checkAccess('createCarModel')) {
    $this->menu[] = array(
        'label'=>'Create Car Model',
        'url'=>array('create', 'car_brand_id' => $model->car_brand_id)
    );
}
if(Yii::app()->user->checkAccess('updateCarModel')) {
    $this->menu[] = array(
        'label'=>'Update Car Model',
        'url'=>array('update', 'id' => $model->id)
    );
}
if(Yii::app()->user->checkAccess('deleteCarModel')) {
    $this->menu[] = array(
        'label'=>'Delete Car Model',
        'url'=>'#',
        'linkOptions'=>array(
            'submit'=>array('delete','id'=>$model->id),
            'confirm'=>'Are you sure you want to delete this item?'
        )
    );
}
if(Yii::app()->user->checkAccess('updateCarModel') &&
    Yii::app()->user->checkAccess('deleteCarModel')) {
    $this->menu[] = array(
        'label'=>'Manage Car Models',
        'url'=>array('admin', 'car_brand_id' => $model->car_brand_id)
    );
}
if(Yii::app()->user->checkAccess('createCarGeneration')) {
    $this->menu[] = array(
        'label'=>'Create CarGeneration',
        'url'=>array('carGeneration/create', 'car_model_id' => $model->id)
    );
}
?>

<h1>View CarModel #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'car_brand_id',
		'name',
	),
)); ?>

<br>
<h1>Generations</h1>
<?php $this->widget('zii.widgets.CListView', array(
    'dataProvider'=>$carGenerationDataProvider,
    'itemView'=>'/carGeneration/_view',
)); ?>

<?php
$this->beginWidget('zii.widgets.CPortlet', array('title' => 'Recent Comments',));
$this->widget(
    'RecentComments',
    array(
        'propertyName' => 'carModelId',
        'propertyValue' => $model->id,
    )
);
$this->endWidget();
?>
