<?php
/**
 * Facebook Component Class
 *
 * A CakePHP Component class for interfacing with the Facebook PHP SDK
 *
 * PHP version 5
 *
 * LICENSE: This source file is subject to the MIT License that is available
 * through the world-wide-web at the following URI:
 * http://www.opensource.org/licenses/mit-license.php.
 *
 * @author     Robert Love <robert@pollenizer.com>
 * @copyright  Copyright 2012, Pollenizer Pty. Ltd. (http://pollenizer.com/)
 * @license    MIT License (http://www.opensource.org/licenses/mit-license.php)
 * @version    1.0
 * @since      File available since Release 2.0
 * @link       http://developers.facebook.com/docs/reference/php/
 */

/**
 * Facebook PHP SDK
 *
 * @see https://github.com/facebook/php-sdk
 */
App::uses('Facebook', 'Facebook.Lib');

/**
 * Facebook Component Class
 *
 * A CakePHP Component class for interfacing with the Facebook PHP SDK
 *
 * @author     Robert Love <robert@pollenizer.com>
 * @copyright  Copyright 2012, Pollenizer Pty. Ltd. (http://pollenizer.com/)
 * @license    MIT License (http://www.opensource.org/licenses/mit-license.php)
 * @version    1.0
 * @since      File available since Release 2.0
 * @link       http://developers.facebook.com/docs/reference/php/
 */
class FacebookComponent extends Component
{
    /**
     * Facebook
     *
     * @var object Facebook
     * @access public
     */
    public $Facebook = null;

    /**
     * Settings
     *
     * @var array
     */
    public $settings = array();

    /**
     * Constructor
     *
     * @param ComponentCollection $collection A ComponentCollection this component can use to lazy load its components
     * @param array $settings Array of configuration settings
     * @return void
     * @access public
     */
    public function __construct(ComponentCollection $collection, $settings = array())
    {
        $this->Facebook = new Facebook(array(
            'appId'  => $settings['appId'],
            'secret' => $settings['appSecret'],
        ));
        parent::__construct($collection, $settings);
        unset($settings['appId']);
        unset($settings['appSecret']);
        $this->settings = $settings;
    }

    /**
     * API
     *
     * This method can call a Facebook Graph API method, an FQL query, or a
     * (DEPRECATED) REST API method, depending on the parameters passed in.
     *
     * @access public
     * @link http://developers.facebook.com/docs/reference/php/facebook-api/
     */
    public function api($method = null)
    {
        return $this->Facebook->api($method);
    }

    /**
     * Get Access Token
     *
     * Get the current access token being used by the SDK.
     *
     * @access public
     * @link http://developers.facebook.com/docs/reference/php/facebook-getAccessToken/
     */
    public function getAccessToken()
    {
        return $this->Facebook->getAccessToken();
    }

    /**
     * Get API Secret
     *
     * Get the App secret that the SDK is currently using.
     *
     * @access public
     * @link http://developers.facebook.com/docs/reference/php/facebook-getAppSecret/
     */
    public function getApiSecret()
    {
        return $this->Facebook->getApiSecret();
    }

    /**
     * Get App ID
     *
     * Get the App ID that the SDK is currently using.
     *
     * @access public
     * @link http://developers.facebook.com/docs/reference/php/facebook-getAppId/
     */
    public function getAppId()
    {
        return $this->Facebook->getAppId();
    }

    /**
     * Get Login Status URL
     *
     * Returns a URL based on the userÕs login status on Facebook.
     *
     * @access public
     * @link http://developers.facebook.com/docs/reference/php/facebook-getLoginStatusUrl/
     */
    public function getLoginStatusUrl($params = array())
    {
        $params = array_merge($this->settings, $params);
        return $this->Facebook->getLoginStatusUrl($params);
    }

    /**
     * Get Login URL
     *
     * Get a URL that the user can click to login, authorize the app, and get redirected back to the app.
     *
     * @access public
     * @link http://developers.facebook.com/docs/reference/php/facebook-getLoginUrl/
     */
    public function getLoginUrl($params = array())
    {
        if (isset($params['redirect_uri'])) {
            $params['redirect_uri'] = $this->Html->url($params['redirect_uri'], true);
        }
        $params = array_merge($this->settings, $params);
        return $this->Facebook->getLoginUrl($params);
    }

    /**
     * Get Logout URL
     *
     * This method returns a URL that, when clicked by the user, will log them out of their Facebook session and then redirect them back to your application.
     *
     * @access public
     * @link http://developers.facebook.com/docs/reference/php/facebook-getLogoutUrl/
     */
    public function getLogoutUrl($params = array())
    {
        if (isset($params['next'])) {
            $params['next'] = $this->Html->url($params['next'], true);
        }
        $params = array_merge($this->settings, $params);
        return $this->Facebook->getLogoutUrl($params);
    }

    /**
     * Get Signed Request
     *
     * Get the current signed request being used by the SDK.
     *
     * @access public
     * @link http://developers.facebook.com/docs/reference/php/facebook-getSignedRequest/
     */
    public function getSignedRequest()
    {
        return $this->Facebook->getSignedRequest();
    }

    /**
     * Get User
     *
     * This method returns the Facebook User ID of the current user, or 0 if there is no logged-in user.
     *
     * @access public
     * @link http://developers.facebook.com/docs/reference/php/facebook-getUser/
     */
    public function getUser()
    {
        return $this->Facebook->getUser();
    }

    /**
     * ID
     *
     * Get the currently logged in users Facebook ID
     *
     * @return mixed Facebook User ID of the current user, or NULL if there is no logged-in user
     */
    public function id()
    {
        $id = $this->Facebook->getUser();
        return ($id > 0) ? $id : null;
    }

    /**
     * Logged In
     *
     * Find out if a user is logged in with Facebook
     *
     * @return boolean TRUE if logged in, FALSE otherwise
     */
    public function loggedIn()
    {
        return ($this->id()) ? true : false;
    }

    /**
     * Set Access Token
     *
     * Set the current access token being used by the SDK.
     *
     * @access public
     * @link http://developers.facebook.com/docs/reference/php/facebook-setAccessToken/
     */
    public function setAccessToken($accessToken)
    {
        return $this->Facebook->setAccessToken($accessToken);
    }

    /**
     * Set Api Secret
     *
     * Set the App secret that the SDK is currently using.
     *
     * @access public
     * @link http://developers.facebook.com/docs/reference/php/facebook-setAppSecret/
     */
    public function setApiSecret($appSecret)
    {
        return $this->Facebook->setApiSecret($appSecret);
    }

    /**
     * Set App ID
     *
     * Set the App ID that the SDK is currently using.
     *
     * @access public
     * @link http://developers.facebook.com/docs/reference/php/facebook-setAppId/
     */
    public function setAppId($appId)
    {
        return $this->Facebook->setAppId($appId);
    }

    /**
     * Set File Upload Support
     *
     * Set file upload support in the SDK.
     *
     * @access public
     * @link http://developers.facebook.com/docs/reference/php/facebook-setFileUploadSupport/
     */
    public function setFileUploadSupport($fileUploadSupport)
    {
        return $this->Facebook->setFileUploadSupport($fileUploadSupport);
    }

    /**
     * Use File Upload Support
     *
     * Get whether file upload support has been enabled in the SDK.
     *
     * @access public
     * @link http://developers.facebook.com/docs/reference/php/facebook-getFileUploadSupport/
     */
    public function useFileUploadSupport()
    {
        return $this->Facebook->useFileUploadSupport();
    }

    /**
     * User
     *
     * Get information about the currently logged in user
     *
     * @param string $key field to retrieve. Leave null to get entire User record
     * @return mixed User record. or null if no user is logged in.
     */
    public function user($key = null)
    {
        if ($user = $this->Facebook->api('/me')) {
            if (!is_null($key)) {
                if (isset($user[$key])) {
                    return $user[$key];
                }
            }
            return $user;
        }
        return null;
    }
}
