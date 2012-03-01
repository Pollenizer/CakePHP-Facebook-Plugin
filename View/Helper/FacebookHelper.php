<?php
/**
 * Facebook Helper Class
 *
 * A CakePHP Helper class for interfacing with the Facebook PHP SDK
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
 * Facebook Helper Class
 *
 * A CakePHP Helper class for interfacing with the Facebook PHP SDK
 *
 * @author     Robert Love <robert@pollenizer.com>
 * @copyright  Copyright 2012, Pollenizer Pty. Ltd. (http://pollenizer.com/)
 * @license    MIT License (http://www.opensource.org/licenses/mit-license.php)
 * @version    1.0
 * @since      File available since Release 2.0
 * @link       http://developers.facebook.com/docs/reference/php/
 */
class FacebookHelper extends AppHelper
{
    /**
     * Facebook
     *
     * @var object Facebook
     */
    public $Facebook = null;

    /**
     * Helpers
     *
     * @var array
     */
    public $helpers = array(
        'Html'
    );

    /**
     * Settings
     *
     * @var array
     */
    public $settings = array();

    /**
     * Constructor
     *
     * @param View $View The View this helper is being attached to.
     * @param array $settings Configuration settings for the helper
     * @return void
     */
    public function __construct(View $View, $settings = array())
    {
        $this->Facebook = new Facebook(array(
            'appId'  => $settings['appId'],
            'secret' => $settings['appSecret'],
        ));
        parent::__construct($View, $settings);
        unset($settings['appId']);
        unset($settings['appSecret']);
        $this->settings = $settings;
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
            $params['redirect_uri'] = Router::url($params['redirect_uri'], true);
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
            $params['next'] = Router::url($params['next'], true);
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
     * Login
     *
     * Creates an HTML link to login to Facebook
     *
     * ### Options
     *
     * - `display`      (optional) The display mode in which to render the
     *                  dialog. The default is page, but can be set to other
     *                  values such as popup.
     * - `redirect_uri` (optional) The URL to redirect the user to once the
     *                  login/authorization process is complete. The user will
     *                  be redirected to the URL on both login success and
     *                  failure, so you must check the error parameters in the
     *                  URL as described in the authentication documentation.
     *                  If this property is not specified, the user will be
     *                  redirected to the current URL (i.e. the URL of the page
     *                  where this method was called, typically the current URL
     *                  in the user's browser).
     * - `scope`        (optional) The permissions to request from the user. If this
     *                  property is not specified, basic permissions will be requested
     *                  from the user.
     * - Any other options available to HtmlHelper::link()
     *
     * @param string $title The content to be wrapped by <a> tags
     * @param array $options Array of Options as defined above
     * @param string $confirmMessage JavaScript confirmation message
     * @return mixed An `<a />` element if not already logged into Facebook, null otherwise
     * @link http://book.cakephp.org/2.0/en/core-libraries/helpers/html.html#HtmlHelper::link
     * @link http://developers.facebook.com/docs/reference/php/facebook-getLoginUrl/
     */
    public function login($title, $options = array(), $confirmMessage = false)
    {
        // Define Facebook params
        $params = array();

        // Define Display
        if (isset($options['display'])) {
            $params['display'] = $options['display'];
            unset($options['display']);
        }

        // Define Redirect URI
        if (isset($options['redirect_uri'])) {
            $params['redirect_uri'] = $this->Html->url($options['redirect_uri'], true);
            unset($options['redirect_uri']);
        }

        // Define Scope
        if (isset($options['scope'])) {
            if (is_array($options['scope'])) {
                $params['scope'] = implode(',', $options['scope']);
            } else {
                $params['scope'] = $options['scope'];
            }
            unset($options['scope']);
        }

        // Get Login URL
        $params = array_merge($this->settings, $params);
        $url = $this->Facebook->getLoginUrl($params);

        // Return login link
        return $this->Html->link($title, $url, $options, $confirmMessage);
    }

    /**
     * Logout
     *
     * Creates an HTML link to logout of Facebook
     *
     * ### Options
     *
     * - `next` (optional) Next URL to which to redirect the user after logging
     *          out (should be an absolute URL)
     * - Any other options available to HtmlHelper::link()
     *
     * @param string $title The content to be wrapped by <a> tags
     * @param array $options Array of Options as defined above
     * @param string $confirmMessage JavaScript confirmation message
     * @return mixed An `<a />` element if not already logged into Facebook, null otherwise
     * @link http://book.cakephp.org/2.0/en/core-libraries/helpers/html.html#HtmlHelper::link
     * @link http://developers.facebook.com/docs/reference/php/facebook-getLogoutUrl/
     */
    public function logout($title, $options = array(), $confirmMessage = false)
    {
        // Define Facebook params
        $params = array();

        // Define Next
        if (isset($options['next'])) {
            $params['next'] = $this->Html->url($options['next'], true);
            unset($options['next']);
        }

        // Get Logout URL
        $params = array_merge($this->settings, $params);
        $url = $this->Facebook->getLogoutUrl($params);

        // Return logout link
        return $this->Html->link($title, $url, $options, $confirmMessage);
    }

    /**
     * Picture
     *
     * Creates a formatted IMG element of the Facebook user's picture
     *
     * @param string $id Facebook User ID
     * @param array $options Array of HTML attributes and options available to HtmlHelper::image()
     * @return string completed img tag
     * @link http://book.cakephp.org/2.0/en/core-libraries/helpers/html.html#HtmlHelper::image
     */
    public function picture($id, $options)
    {
        // Define picture type
        $type = 'square';
        if (isset($options['type'])) {
            $type = $options['type'];
            unset($options['type']);
        }

        // Define image path
        $path = 'http://graph.facebook.com/' . $id . '/picture?type=' . $type;

        // Return img element
        return $this->Html->image($path, $options);
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
