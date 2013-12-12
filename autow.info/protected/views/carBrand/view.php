<?php
/* @var $this CarBrandController */
/* @var $model CarBrand */

$this->breadcrumbs=array(
	'Car Brands'=>array('index'),
	$model->name,
);

$this->menu=array(
	array('label'=>'List Car Brands', 'url'=>array('index')),
	array('label'=>'List Brand Models', 'url'=>array('carModel/index', 'car_brand_id' => $model->id)),
//	array('label'=>'Create CarBrand', 'url'=>array('create')),
//	array('label'=>'Update CarBrand', 'url'=>array('update', 'id'=>$model->id)),
//	array('label'=>'Delete CarBrand', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
//	array('label'=>'Manage CarBrand', 'url'=>array('admin')),
//    array('label' => 'Create CarModel', 'url' => array('carModel/create', 'car_brand_id' => $model->id)),
);
if(Yii::app()->user->checkAccess('createCarBrand')) {
    $this->menu[] = array(
        'label'=>'Create Car Brand',
        'url'=>array('create')
    );
}
if(Yii::app()->user->checkAccess('updateCarBrand')) {
    $this->menu[] = array(
        'label'=>'Update Car Brand',
        'url'=>array('update', 'id' => $model->id)
    );
}
if(Yii::app()->user->checkAccess('deleteCarBrand')) {
    $this->menu[] = array(
        'label'=>'Delete Car Brand',
        'url'=> '#',
        'linkOptions'=>array(
            'submit'=>array('delete','id'=>$model->id),
            'confirm'=>'Are you sure you want to delete this item?'
        )
    );
}
if(Yii::app()->user->checkAccess('createCarModel')) {
    $this->menu[] = array(
        'label'=>'Create Car Model',
        'url'=>array('carModel/create', 'car_brand_id' => $model->id)
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

<h1>View CarBrand #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'name',
		'logo',
	),
)); ?>

<br>
<h1>Models</h1>
<?php $this->widget('zii.widgets.CListView', array(
    'dataProvider'=>$carModelDataProvider,
    'itemView'=>'/carModel/_view',
)); ?>

<?php
$this->beginWidget('zii.widgets.CPortlet', array('title' => 'Recent Comments',));
$this->widget(
    'RecentComments',
    array(
        'propertyName' => 'carBrandId',
        'propertyValue' => $model->id,
    )
);
$this->endWidget();
?>
