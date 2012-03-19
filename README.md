# CakePHP Facebook Plugin

A CakePHP Plugin used for interfacing with the Facebook PHP SDK.

For a full list of available methods and properties, please refer to the [Facebook PHP SDK Overview](http://developers.facebook.com/docs/reference/php/)

## INSTALLATION

1.   Copy the plugin to ``app/Plugin/Facebook``
1.   Enable the plugin in ``app/Config/bootstrap.php``

## CONFIGURATION

In your controller:

    public $components = array(
        'Facebook.Facebook' => array(
            'appId' => YOUR_FACEBOOK_APP_ID,
            'appSecret' => YOUR_FACEBOOK_APP_SECRET
        )
    );

    public $helpers = array(
        'Facebook.Facebook' => array(
            'appId' => YOUR_FACEBOOK_APP_ID,
            'appSecret' => YOUR_FACEBOOK_APP_SECRET
        )
    );

## USAGE

The following example shows how to use the ``FacebookHelper::getLoginUrl`` method to create a Facebook login link.

    echo $this->Html->link(__('Login with Facebook'), $this->Facebook->getLoginUrl(array(
        'redirect_uri' => $this->Html->url('/', true),
        'scope' => 'email,user_interests,user_location'
    )));

The following example shows how to use the ``FacebookHelper::likeButton`` method to create a Facebook Like Button.

    echo $this->Facebook->likeButton(array(
        'href' => $this->Html->url(array('controller' => 'posts', 'action' => 'view', 123), true),
        'send' => 'false',
        'layout' => 'button_count',
        'width' => '450',
        'show_faces' => 'false',
        'action' => 'recommend'
    ));
