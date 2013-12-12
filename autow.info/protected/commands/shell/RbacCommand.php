<?php
/**
 * Created by JetBrains PhpStorm.
 * User: radu
 * Date: 9/27/13
 * Time: 11:15 PM
 */
class RbacCommand extends CConsoleCommand
{
    /**
     * @var
     */
    private $_authManager;

    /**
     * @return string
     */
    public function getHelp()
    {
        return <<<EOD
USAGE
rbac
DESCRIPTION
This command generates an initial RBAC authorization hierarchy.
EOD;
    }

    /**
     * Execute the action.
     * @param array command line parameters specific for this command
     */
    public function run($args)
    {
        //ensure that an authManager is defined as this is mandatory for creating an auth heirarchy
        if(($this->_authManager=Yii::app()->authManager)===null)
        {
            echo "Error: an authorization manager, named 'authManager' must be configured to use this command.\n";
            echo "If you already added 'authManager' component in application configuration,\n";
            echo "please quit and re-enter the yiic shell.\n";
            return;
        }

        //provide the oportunity for the use to abort the request
        echo "This command will create 4 roles: Admin, Moderator, Publisher and User and the following premissions:\n";
        echo "create, read, update and delete car brands\n";
        echo "create, read, update and delete car models\n";
        echo "create, read, update and delete car generations\n";
        echo "create, read, update and delete car articles\n";
        echo "create, read, update and delete car photos\n";
        echo "create, read, update and delete comments\n";
        echo "create, read, update and delete users\n";
        echo "Would you like to continue? [Yes|No] ";

        //check the input from the user and continue if they indicated yes to the above question
        if(!strncasecmp(trim(fgets(STDIN)),'y',1))
        {
            //first we need to remove all operations, roles, child relationship and assignments
            $this->_authManager->clearAll();

            //create the lowest level operations for users
            $this->_authManager->createOperation("createUser","create a new user");
            $this->_authManager->createOperation("readUser","read user profile information");
            $this->_authManager->createOperation("updateUser","update a users information");
            $this->_authManager->createOperation("deleteUser","remove a user");

            //create the lowest level operations for car brands
            $this->_authManager->createOperation("createCarBrand","create a new car brand");
            $this->_authManager->createOperation("readCarBrand","read car brand information");
            $this->_authManager->createOperation("updateCarBrand","update a car brand information");
            $this->_authManager->createOperation("deleteCarBrand","remove a car brand");

            //create the lowest level operations for car models
            $this->_authManager->createOperation("createCarModel","create a new car model");
            $this->_authManager->createOperation("readCarModel","read car model information");
            $this->_authManager->createOperation("updateCarModel","update a car model information");
            $this->_authManager->createOperation("deleteCarModel","remove a car model");

            //create the lowest level operations for car generations
            $this->_authManager->createOperation("createCarGeneration","create a new car generation");
            $this->_authManager->createOperation("readCarGeneration","read car generation information");
            $this->_authManager->createOperation("updateCarGeneration","update a car generation information");
            $this->_authManager->createOperation("deleteCarGeneration","remove a car generation");

            //create the lowest level operations for articles
            $this->_authManager->createOperation("createArticle","create a new article");
            $this->_authManager->createOperation("readArticle","read article information");
            $this->_authManager->createOperation("updateArticle","update article information");
            $this->_authManager->createOperation("deleteArticle","remove an article");

            //create the lowest level operations for photos
            $this->_authManager->createOperation("createPhoto","create a new photo");
            $this->_authManager->createOperation("readPhoto","read a photo");
            $this->_authManager->createOperation("updatePhoto","update a photo");
            $this->_authManager->createOperation("deletePhoto","remove a photo");

            //create the lowest level operations for comments
            $this->_authManager->createOperation("createComment","create a new comment");
            $this->_authManager->createOperation("readComment","read comment");
            $this->_authManager->createOperation("updateComment","update comment");
            $this->_authManager->createOperation("deleteComment","delete a comment");

            //create the user role and add the appropriate permissions as children to this role
            $role=$this->_authManager->createRole("user");
            $role->addChild("readUser");
            $role->addChild("readCarBrand");
            $role->addChild("readCarModel");
            $role->addChild("readCarGeneration");
            $role->addChild("readPhoto");
            $role->addChild("readComment");
            $role->addChild("createComment");

            //create the publisher role, and add the appropriate permissions, as well as the user role itself, as children
            $role=$this->_authManager->createRole("publisher");
            $role->addChild("user");
            $role->addChild("createCarBrand");
            $role->addChild("createCarModel");
            $role->addChild("createCarGeneration");
            $role->addChild("createArticle");
            $role->addChild("createPhoto");

            //create the moderator role, and add the appropriate permissions,
            // as well as the user and publisher roles as children
            $role=$this->_authManager->createRole("moderator");
            $role->addChild("user");
            $role->addChild("publisher");
            $role->addChild("createUser");
            $role->addChild("updateCarBrand");
            $role->addChild("updateCarModel");
            $role->addChild("updateCarGeneration");
            $role->addChild("updateArticle");
            $role->addChild("updatePhoto");
            $role->addChild("updateComment");
            $role->addChild("deleteCarBrand");
            $role->addChild("deleteCarModel");
            $role->addChild("deleteCarGeneration");
            $role->addChild("deleteArticle");
            $role->addChild("deletePhoto");
            $role->addChild("deleteComment");

            //create the admin role, and add the appropriate permissions,
            // as well as the user, publisher and moderator roles as children
            $this->_authManager->createTask("adminManagement", "access to the application administration functionality");
            $role=$this->_authManager->createRole("admin");
            $role->addChild("user");
            $role->addChild("publisher");
            $role->addChild("moderator");
            $role->addChild("deleteUser");
            $role->addChild("adminManagement");

            //ensure we have one admin in the system (force it to be user id #1)
            $this->_authManager->assign("admin",1);

            //provide a message indicating success
            echo "Authorization hierarchy successfully generated.";
        }
    }
}
