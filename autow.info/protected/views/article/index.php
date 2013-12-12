<?php
/* @var $this ArticleController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Articles',
);

$this->menu=array(
//	array('label'=>'Create Article', 'url'=>array('create')),
//	array('label'=>'Manage Article', 'url'=>array('admin')),
);
if(Yii::app()->user->checkAccess('createArticle')) {
    $this->menu[] = array(
        'label'=>'Create Article',
        'url'=>array('create', 'car_generation_id' => 1)
    );
}
if(Yii::app()->user->checkAccess('updateArticle') &&
    Yii::app()->user->checkAccess('deleteArticle')) {
    $this->menu[] = array(
        'label'=>'Manage Articles',
        'url'=>array('admin')
    );
}
?>

<h1>Articles</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>

<?php
$this->beginWidget('zii.widgets.CPortlet', array('title' => 'Recent Comments',));
$this->widget(
    'RecentComments',
    array(
        'propertyName' => 'carGenerationId',
        'propertyValue' => $model->carGeneration->id,
    )
);
$this->endWidget();
?>
