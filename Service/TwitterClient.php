<?php
/**
 * Created by PhpStorm.
 * User: Stuart Wilson <stuart@stuartwilsondev.com>
 * Date: 26/09/15
 * Time: 15:38
 */

namespace StuartWilsonDev\TwitterConnectorBundle\Service;

class TwitterClient {

    protected $consumerKey;
    protected $consumerSecret;
    protected $accessKey;
    protected $accessSecret;

    function __construct($consumerKey, $consumerSecret, $accessKey, $accessSecret)
    {
        $this->consumerKey = $consumerKey;
        $this->consumerSecret = $consumerSecret;
        $this->accessKey = $accessKey;
        $this->accessSecret = $accessSecret;
    }


}