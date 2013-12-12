<?php
/**
 * Created by JetBrains PhpStorm.
 * User: radu
 * Date: 10/27/13
 * Time: 12:49 PM
 *
 * RecentComments is a Yii widget used to display a list of recent comments
 */

class RecentComments extends CWidget
{
    /**
     * @var
     */
    private $_comments;

    /**
     * @var int
     */
    public $displayLimit = 5;

    /**
     * @var null
     */
    public $propertyName = null;

    /**
     * @var null
     */
    public $propertyValue = null;

    /**
     *
     */
    public function init()
    {
        $this->_comments = Comment::model()->findRecentComments(
            $this->displayLimit,
            $this->propertyName,
            $this->propertyValue
        );
    }

    /**
     * @return mixed
     */
    public function getRecentComments()
    {
        return $this->_comments;
    }

    /**
     *
     */
    public function run()
    {
        // this method is called by CController::endWidget()
        $this->render('recentComments');
    }

}