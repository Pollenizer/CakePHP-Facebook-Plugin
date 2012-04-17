<?php
/**
 * Facebook Helper
 *
 * A CakePHP Helper class for interfacing with the Facebook PHP SDK
 *
 * PHP version 5
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the below copyright notice.
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
 * Facebook Helper
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
     * Call
     *
     * @param string $name The name of the method being called
     * @param array $arguments The arguments being passed to the method
     * @return mixed
     */
    public function __call($name, $arguments = array())
    {
        $count = count($arguments);
        if ($count == 0) {
            return $this->Facebook->$name();
        }
        if ($count == 1) {
            return $this->Facebook->$name($arguments[0]);
        }
        return $this->Facebook->$name(implode(', ', $arguments));
    }

    /**
     * Constructor
     *
     * @param View $View The View this helper is being attached to
     * @param array $settings Configuration settings for the helper
     * @return void
     */
    public function __construct(View $View, $settings = array())
    {
        if (empty($settings)) {
            Configure::load('facebook');
            $settings = Configure::read('Facebook');
        }

        $this->Facebook = new Facebook(array(
            'appId'  => $settings['appId'],
            'secret' => $settings['appSecret'],
        ));
        parent::__construct($View, $settings);
        $this->settings = $settings;
    }

    /**
     * Like Button
     *
     * The Like button lets a user share your content with friends on Facebook.
     *
     * @param array $attributes Array of Attributes as defined in http://developers.facebook.com/docs/reference/plugins/like/
     * @return string Facebook Like Button
     * @see http://developers.facebook.com/docs/reference/plugins/like/
     */
    public function likeButton($attributes = array())
    {
        $output = '<div id="fb-root"></div>';
        $output .= "<script>(function(d,s,id){var js, fjs=d.getElementsByTagName(s)[0];if(d.getElementById(id)) return;js=d.createElement(s);js.id=id;js.src='//connect.facebook.net/en_US/all.js#xfbml=1&appId=" . $this->settings['appId'] . "';fjs.parentNode.insertBefore(js,fjs);}(document,'script','facebook-jssdk'));</script>";
        if (!empty($attributes)) {
            foreach ($attributes as $key => $value) {
                $attributes['data-' . str_replace('_', '-', $key)] = $value;
                unset($attributes[$key]);
            }
        }
        $output .= $this->Html->div('fb-like', null, $attributes);
        return $output;
    }
}
