<?php
/* @var $this CarModelController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Car Models',
);

$this->menu=array(
//	array('label'=>'Create CarModel', 'url'=>array('create', 'car_brand_id' => 1)),
//	array('label'=>'Manage CarModel', 'url'=>array('admin')),
);
if(Yii::app()->user->checkAccess('createCarModel')) {
    $this->menu[] = array(
        'label'=>'Create Car Model',
        'url'=>array('create', 'car_brand_id' => $carBrand->id)
    );
}
if(Yii::app()->user->checkAccess('updateCarModel') &&
    Yii::app()->user->checkAccess('deleteCarModel')) {
    $this->menu[] = array(
        'label'=>'Manage Car Models',
        'url'=>array('admin', 'car_brand_id' => $carBrand->id)
    );
}
?>

<h1>Car Models</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>

<?php
$this->beginWidget('zii.widgets.CPortlet', array('title' => 'Recent Comments',));
$this->widget(
    'RecentComments',
    array(
        'propertyName' => 'carBrandId',
        'propertyValue' => $carBrand->id,
    )
);
$this->endWidget();
?>
