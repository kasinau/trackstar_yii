<?php
/* @var $this ArticleController */
/* @var $model Article */

$this->breadcrumbs=array(
	'Articles'=>array('index'),
	$model->title,
);

$this->menu=array(
	array(
        'label'=>'List Articles',
        'url'=>array('index', 'car_generation_id' => $model->carGeneration->id)
    ),
    array(
        'label'=>'List Comments',
        'url'=>array(
            'comment/index',
            'article_id' => $model->id
        )
    ),
    array(
        'label'=>'List Photos',
        'url'=>array(
            'photo/index',
            'article_id' => $model->id
        )
    ),
);
if(Yii::app()->user->checkAccess('createArticle')) {
    $this->menu[] = array(
        'label'=>'Create Article',
        'url'=>array('create')
    );
}
if(Yii::app()->user->checkAccess('updateArticle')) {
    $this->menu[] = array(
        'label'=>'Update Article',
        'url'=>array('update')
    );
}
if(Yii::app()->user->checkAccess('deleteArticle')) {
    $this->menu[] = array(
        'label'=>'Delete Article',
        'url'=>'#',
        'linkOptions'=>array(
            'submit'=>array('delete','id'=>$model->id),
            'confirm'=>'Are you sure you want to delete this item?'
        )
    );
}
if(Yii::app()->user->checkAccess('createComment')) {
    $this->menu[] = array(
        'label'=>'Create Comment',
        'url'=>array('comment/create', 'article_id' => $model->id)
    );
}
if(Yii::app()->user->checkAccess('createPhoto')) {
    $this->menu[] = array(
        'label'=>'Create Photo',
        'url'=>array('photo/create', 'article_id' => $model->id)
    );
}
if(Yii::app()->user->checkAccess('updateArticle') &&
    Yii::app()->user->checkAccess('deleteArticle')) {
    $this->menu[] = array(
        'label'=>'Manage Articles',
        'url'=>array('admin', 'car_generation_id' => $model->car_generation_id)
    );
}
?>

<h1>View Article #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'car_generation_id',
		array(
            'name' => 'user_id',
            'value' => CHtml::encode($model->user->username),
        ),
		'title',
		'content',
		'create_time',
		'update_time',
	),
)); ?>

<br />
<div id="comments">
    <?php if ($model->commentCount >= 1): ?>
        <h3>
            <?php echo $model->commentCount > 1 ? $model->commentCount . ' comments' : 'One comment'; ?>
        </h3>

        <?php $this->renderPartial('_comments', array('comments' => $model->comments,)) ?>
    <?php endif; ?>

    <h3>Leave a comment</h3>

    <?php if (Yii::app()->user->hasFlash('commentSubmitted')): ?>
        <div class="flash-success">
            <?php echo Yii::app()->user->getFlash('commentSubmitted'); ?>
        </div>
<!--    --><?php //else: ?>
<!--        --><?php //$this->renderPartial('/comment/_form', array('model' => $comment)) ?>
    <?php endif; ?>
    <?php $this->renderPartial('/comment/_form', array('model' => $comment)) ?>
</div>
