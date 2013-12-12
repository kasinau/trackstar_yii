<?php
/**
 * Created by JetBrains PhpStorm.
 * User: rpavelco
 * Date: 10/28/13
 * Time: 1:57 PM
 */
?>
<?php foreach($comments as $comment): ?>
    <div class="comment">
        <div class="user">
            <?php echo $comment->user->username; ?>
        </div>
        <div class="content">
            <?php echo nl2br(CHtml::encode($comment->comment)); ?>
        </div>
        <hr />
    </div><!-- comment -->
<?php endforeach; ?>