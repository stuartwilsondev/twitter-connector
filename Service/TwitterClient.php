<?php
/**
 * Created by PhpStorm.
 * User: Stuart Wilson <stuart@stuartwilsondev.com>
 * Date: 26/09/15
 * Time: 15:38
 */

namespace StuartWilsonDev\TwitterConnectorBundle\Service;

use Psr\Log\LoggerAwareTrait;

/**
 * Class TwitterClient
 * @package StuartWilsonDev\TwitterConnectorBundle\Service
 */
class TwitterClient
{
    use LoggerAwareTrait;

    /**
     * @var Token
     */
    protected $token;
    /**
     * @var String
     */
    protected $consumerKey;
    /**
     * @var String
     */
    protected $consumerSecret;
    /**
     * @var String
     */
    protected $accessKey;
    /**
     * @var String
     */
    protected $accessSecret;

    /**
     * @param Token $token
     * @param $consumerKey
     * @param $consumerSecret
     * @param $accessKey
     * @param $accessSecret
     */
    public function __construct(
        Token $token,
        $consumerKey,
        $consumerSecret,
        $accessKey,
        $accessSecret
    )
    {
        $this->token = $token;
        $this->consumerKey = $consumerKey;
        $this->consumerSecret = $consumerSecret;
        $this->accessKey = $accessKey;
        $this->accessSecret = $accessSecret;
    }

}
