<?php
/**
 * Created by JetBrains PhpStorm.
 * User: radu
 * Date: 3/4/13
 * Time: 11:17 PM
 */
class ArtileTest extends CDbTestCase
{
    public $fixtures = array(
        'articles' => 'Article'
    );
    public function testCRUD()
    {
        //Create a new article
        $newArticle = new Article;
        $newArticleTitle = 'Test Article Title 1';
        $newArticle->setAttributes(
            array(
                'car_generation_id' => 1,
                'user_id' => 1,
                'title' => $newArticleTitle,
                'content' => 'Test article number one',
                'create_time' => '2010-01-01 00:00:00',
                'update_time' => '2010-01-01 00:00:00',
            )
        );
        $this->assertTrue($newArticle->save(false));

        //READ back the newly created article
        $retrievedArticle=Article::model()->findByPk($newArticle->id);
        $this->assertTrue($retrievedArticle instanceof Article);
        $this->assertEquals($newArticleTitle,$retrievedArticle->title);

        //UPDATE the newly created article
        $updatedArticleTitle = 'Updated Test Article 1';
        $newArticle->title = $updatedArticleTitle;
        $this->assertTrue($newArticle->save(false));

        //read back the record again to ensure the update worked
        $updatedArticle=Article::model()->findByPk($newArticle->id);
        $this->assertTrue($updatedArticle instanceof Article);
        $this->assertEquals($updatedArticleTitle,$updatedArticle->title);

        //DELETE the article
        $newArticleId = $newArticle->id;
        $this->assertTrue($newArticle->delete());
        $deletedArticle=Article::model()->findByPk($newArticleId);
        $this->assertEquals(NULL,$deletedArticle);
    }
}