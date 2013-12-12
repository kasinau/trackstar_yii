<?php
/* @var $this CarGenerationController */
/* @var $model CarGeneration */

$this->breadcrumbs=array(
	'Car Generations'=>array('index'),
	$model->name,
);

$this->menu=array(
	array(
        'label'=>'List CarGeneration',
        'url'=>array(
            'index',
            'car_model_id' => $model->carModel->id,
        )
    ),
    array(
        'label'=>'List Articles',
        'url'=>array(
            'article/index',
            'car_generation_id' => $model->id
        )
    ),
//	array(
//        'label'=>'Create CarGeneration',
//        'url'=>array(
//            'create',
//            'car_model_id' => $model->carModel->id,
//        )
//    ),
//	array('label'=>'Update CarGeneration', 'url'=>array('update', 'id'=>$model->id)),
//	array('label'=>'Delete CarGeneration', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
//	array(
//        'label'=>'Manage CarGeneration',
//        'url'=>array(
//            'admin',
//            'car_model_id' => $model->carModel->id,
//        )
//    ),
//    array('label' => 'Create Article', 'url' => array('article/create', 'car_generation_id' => $model->id)),
);
if(Yii::app()->user->checkAccess('createCarGeneration')) {
    $this->menu[] = array(
        'label'=>'Create Car Generation',
        'url'=>array('create', 'car_model_id' => $model->carModel->id)
    );
}
if(Yii::app()->user->checkAccess('updateCarGeneration')) {
    $this->menu[] = array(
        'label'=>'Update Car Generation',
        'url'=>array('update')
    );
}
if(Yii::app()->user->checkAccess('deleteCarGeneration')) {
    $this->menu[] = array(
        'label'=>'Delete Car Generation',
        'url'=>array('delete')
    );
}
if(Yii::app()->user->checkAccess('updateCarGeneration') &&
    Yii::app()->user->checkAccess('deleteCarGeneration')) {
    $this->menu[] = array(
        'label'=>'Manage Car Generations',
        'url'=>array('admin', 'car_model_id' => $model->car_model_id)
    );
}
if(Yii::app()->user->checkAccess('createArticle')) {
    $this->menu[] = array(
        'label'=>'Create Article',
        'url'=>array('article/create', 'car_generation_id' => $model->id)
    );
}
?>

<h1>View CarGeneration #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'car_model_id',
		'name',
		'production_period',
	),
)); ?>

<br>
<h1>Articles</h1>
<?php $this->widget('zii.widgets.CListView', array(
    'dataProvider'=>$articleDataProvider,
    'itemView'=>'/article/_view',
)); ?>

<?php
$this->beginWidget('zii.widgets.CPortlet', array('title' => 'Recent Comments',));
$this->widget(
    'RecentComments',
    array(
        'propertyName' => 'carGenerationId',
        'propertyValue' => $model->id,
    )
);
$this->endWidget();
?>
