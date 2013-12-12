<?php
/**
 * Created by JetBrains PhpStorm.
 * User: radu
 * Date: 4/11/13
 * Time: 10:20 PM
 */
class IssueTest extends CDbTestCase
{
    /**
     * @var array
     */
    public $fixtures = array(
        'projects' => 'Project',
        'issues' => 'Issue',
    );

    public function testGetTypes()
    {
        $options = Issue::model()->typeOptions;
        $this->assertTrue(is_array($options));
        $this->assertTrue(3 == count($options));
        $this->assertTrue(in_array('Bug', $options));
        $this->assertTrue(in_array('Feature', $options));
        $this->assertTrue(in_array('Task', $options));
    }

    public function testGetStatus()
    {
        $options = Issue::model()->statusOptions;
        $this->assertTrue(is_array($options));
        $this->assertTrue(3 == count($options));
        $this->assertTrue(in_array('Not yet started', $options));
        $this->assertTrue(in_array('Started', $options));
        $this->assertTrue(in_array('Finished', $options));
    }

    public function testGetStatusText()
    {
        $this->assertTrue('Started' == $this->issues('issueBug')->getStatusText());
    }

    public function testGetTypeText()
    {
        $this->assertTrue('Bug' == $this->issues('issueBug')->getTypeText());
    }

    public function testAddComment()
    {
        $comment = new Comment();
        $comment->content = 'this is a test comment';
        $this->assertTrue($this->issues('issueBug')->addComment($comment));
    }
}