<?php
/**
 * Created by JetBrains PhpStorm.
 * User: radu
 * Date: 9/7/13
 * Time: 3:09 PM
 */
abstract class AutoWActiveRecord extends CActiveRecord
{
    /**
     * @var CAuthManager
     */
    protected $_authmanager;

    public function  __construct($scenario='insert')
    {
        $this->_authmanager = Yii::app()->authManager;
        parent::__construct($scenario);
    }

    /**
     * Prepares create_time, create_user_id, update_time and update_user_id
     * attributes before performing validation.
     */
    protected function beforeValidate()
    {
        $attributes = $this->getAttributes();
        if ($this->isNewRecord) {
            if (array_key_exists('create_time', $attributes)) {
                $this->create_time = new CDbExpression('NOW()');
            }
            if (array_key_exists('update_time', $attributes)) {
                $this->update_time = new CDbExpression('NOW()');
            }
            if (array_key_exists('create_user_id', $attributes)) {
                $this->create_user_id = $this->update_user_id = Yii::app()->user->id;
            }
            if (array_key_exists('update_user_id', $attributes)) {
                $this->update_user_id = Yii::app()->user->id;
            }
            if (array_key_exists('user_id', $attributes)) {
                $this->user_id = Yii::app()->user->id;
            }
        } else {
            if (array_key_exists('update_time', $attributes)) {
                $this->update_time = new CDbExpression('NOW()');
            }
            if (array_key_exists('update_user_id', $attributes)) {
                $this->update_user_id = Yii::app()->user->id;
            }
        }

        return parent::beforeValidate();
    }
}