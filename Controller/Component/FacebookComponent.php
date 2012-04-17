<?php
/**
 * Facebook Component
 *
 * A CakePHP Component class for interfacing with the Facebook PHP SDK
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
 * @since      File available since Release 2.1.0
 * @link       http://developers.facebook.com/docs/reference/php/
 */

/**
 * Facebook PHP SDK
 *
 * @see https://github.com/facebook/php-sdk
 */
App::uses('Facebook', 'Facebook.Lib');

/**
 * Facebook Component
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
     * @param ComponentCollection $collection A ComponentCollection this component can use to lazy load its components
     * @param array $settings Array of configuration settings
     * @return void
     * @access public
     */
    public function __construct(ComponentCollection $collection, $settings = array())
    {

        if (empty($settings)) {
            Configure::load('facebook');
            $settings = Configure::read('Facebook');
        }

        $this->Facebook = new Facebook(array(
            'appId'  => $settings['appId'],
            'secret' => $settings['appSecret'],
        ));
        parent::__construct($collection, $settings);
        $this->settings = $settings;
    }
}
