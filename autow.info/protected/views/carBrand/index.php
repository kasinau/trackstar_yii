<?php
/* @var $this CarBrandController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Car Brands',
);

$this->menu=array(
//	array('label'=>'Create Car Brand', 'url'=>array('create')),
//	array('label'=>'Manage Car Brand', 'url'=>array('admin')),
);

if(Yii::app()->user->checkAccess('createCarBrand')) {
    $this->menu[] = array(
        'label'=>'Create Car Brand',
        'url'=>array('create')
    );
}
if(Yii::app()->user->checkAccess('updateCarBrand') &&
    Yii::app()->user->checkAccess('deleteCarBrand')) {
    $this->menu[] = array(
        'label'=>'Manage Car Brands',
        'url'=>array('admin')
    );
}
?>

<h1>Car Brands</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>

<?php
$this->beginWidget('zii.widgets.CPortlet', array('title' => 'Recent Comments',));
$this->widget('RecentComments');
$this->endWidget();
?>
