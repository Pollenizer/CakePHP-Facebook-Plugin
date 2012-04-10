<?php
/**
 * Facebook Authentication adapter for AuthComponent
 *
 * PHP version 5
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the below copyright notice.
 *
 * @author     Kevin Nguyen <salty@pollenizer.com>
 * @copyright  Copyright 2012, Pollenizer Pty. Ltd. (http://pollenizer.com/)
 * @license    MIT License (http://www.opensource.org/licenses/mit-license.php)
 * @version    1.0
 * @since      File available since Release 2.1.0
 * @link       http://developers.facebook.com/docs/reference/php/
 */

App::uses('BaseAuthenticate', 'Controller/Component/Auth');
App::uses('Facebook', 'Plugin');

class FacebookAuthenticate extends BaseAuthenticate 
{

/**
 * Authenticate a user using Facebook's SDK login functionality
 *
 * @param CakeRequest $request The request to authenticate with.
 * @param CakeResponse $response The response to add headers to.
 * @return mixed Either false on failure, or an array of user data on success.
 */
    public function authenticate(CakeRequest $request, CakeResponse $response) 
    {
        $facebookSession = CakeSession::read();
        if (empty($facebookSession)) {
            return false;
        }

        $userId = 0;
        foreach($facebookSession as $i => $value) {
            if (preg_match('/user_id$/', $i)) {
                $userId = $value;
            }
        }

        if (!empty($userId)) {
            return $this->_findUser($userId);
        }

        return false;
    }

    protected function _findUser($facebookId)
    {
		$userModel = $this->settings['userModel'];
		$user = ClassRegistry::init($userModel)->find('first', array(
			'conditions' => array('facebook_id' => $facebookId),
			'recursive' => -1
		));


        return array_pop($user);
    }


/**
 * Get a user based on information in the request.
 *
 * @param CakeRequest $request Request object.
 * @return mixed Either false or an array of user information
 */
    public function getUser()
    {
        Configure::load('facebook');
        $settings = Configure::load('facebook');
        $this->_facebook = new Facebook($settings['apiKey'], $settings['secret']);
        $user = $this->_facebook->getUser();
        if (!empty($user)) {
            return $this->_findUser($user['id']);
        }

        return false;

    }


}
