<?php
/**
 * Created by JetBrains PhpStorm.
 * User: radu
 * Date: 5/1/13
 * Time: 8:20 AM
 */
return array(
    'message1'=>array(
        'message' => 'test message',
        'create_time' => new CDbExpression('NOW()'),
        'create_user_id' => 1,
        'update_time' => new CDbExpression('NOW()'),
        'update_user_id' => 1,
    ),
);
