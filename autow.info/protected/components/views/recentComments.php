<?php
/**
 * Created by JetBrains PhpStorm.
 * User: radu
 * Date: 10/27/13
 * Time: 12:57 PM
 */
?>
<ul>
    <?php foreach ($this->getRecentComments() as $comment): ?>
        <div class="author">
            <?php echo $comment->user->username; ?> added a comment.
        </div>
        <div class="article">
            <?php echo CHtml::link(CHtml::encode($comment->article->title), array('article/view', 'id' => $comment->article->id)); ?>
        </div>
        <br />
        <hr />
        <br />
    <?php endforeach; ?>
</ul>