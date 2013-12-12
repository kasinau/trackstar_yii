<?php
/* @var $this IssueController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Issues',
);

$this->menu=array(
//	array('label'=>'Create Issue', 'url'=>array('create')),
//	array('label'=>'Manage Issue', 'url'=>array('admin')),
);
if(Yii::app()->user->checkAccess('createIssue',array('project'=>$project))) {
    $this->menu[] = array(
        'label'=>'Create Issue',
        'url'=>array('create', 'pid' => $project->id)
    );
}
if(Yii::app()->user->checkAccess('deleteIssue',array('project'=>$project)) &&
    Yii::app()->user->checkAccess('updateIssue',array('project'=>$project)) &&
    Yii::app()->user->checkAccess('createIssue',array('project'=>$project))) {
    $this->menu[] = array(
        'label'=>'Manage Issue',
        'url'=>array('admin', 'pid' => $project->id)
    );
}
?>

<h1>Issues</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
