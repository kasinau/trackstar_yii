<?php
/* @var $this CarGenerationController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Car Generations',
);

$this->menu=array(
//	array('label'=>'Create CarGeneration', 'url'=>array('create')),
//	array('label'=>'Manage CarGeneration', 'url'=>array('admin')),
);
if(Yii::app()->user->checkAccess('createCarGeneration')) {
    $this->menu[] = array(
        'label'=>'Create Car Generation',
        'url'=>array('create', 'car_model_id' => $carModel->id)
    );
}
if(Yii::app()->user->checkAccess('updateCarGeneration') &&
    Yii::app()->user->checkAccess('deleteCarGeneration')) {
    $this->menu[] = array(
        'label'=>'Manage Car Generations',
        'url'=>array('admin')
    );
}
?>

<h1>Car Generations</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>

<?php
$this->beginWidget('zii.widgets.CPortlet', array('title' => 'Recent Comments',));
$this->widget(
    'RecentComments',
    array(
        'propertyName' => 'carModelId',
        'propertyValue' => $carModel->id,
    )
);
$this->endWidget();
?>
