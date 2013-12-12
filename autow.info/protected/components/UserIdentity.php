<?php

/**
 * UserIdentity represents the data needed to identity a user.
 * It contains the authentication method that checks if the provided
 * data can identity the user.
 */
class UserIdentity extends CUserIdentity
{
    /**
     * @var
     */
    private $_id;

    /**
     * Authenticate a user using the User data model.
     * @return boolean whether authentication succeeds.
     */
    public function authenticate()
    {
        $user = User::model()->findByAttributes(
            array(
                'username' => $this->username,
            )
        );

        if ($user === null) {
            $this->errorCode = self::ERROR_USERNAME_INVALID;
        } else {
            if ($user->password !== $user->encrypt($this->password)) {
                $this->errorCode = self::ERROR_PASSWORD_INVALID;
            } else {
                $this->_id = $user->id;
                $this->errorCode = self::ERROR_NONE;
            }
        }
        return !$this->errorCode;
    }

    /**
     * @return string
     */
    public function getId()
    {
        return $this->_id;
    }
}