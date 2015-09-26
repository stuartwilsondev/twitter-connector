<?php
/**
 * Created by PhpStorm.
 * User: Stuart Wilson <stuart@stuartwilsondev.com>
 * Date: 26/09/15
 * Time: 16:44
 */

namespace StuartWilsonDev\TwitterConnectorBundle\Service;

/**
 * Class Token
 * @package StuartWilsonDev\TwitterConnectorBundle\Service
 */
class Token
{
    /**
     * @var
     */
    protected $accessToken;
    /**
     * @var
     */
    protected $accessSecret;

    /**
     * @param $accessToken
     * @param $accessSecret
     */
    function __construct($accessToken, $accessSecret)
    {
        $this->accessToken = $accessToken;
        $this->accessSecret = $accessSecret;
    }

    /**
     * @param $string
     * @return mixed
     */
    private function urlencodeRFC3986($string)
    {
        return str_replace('%7E', '~', rawurlencode($string));
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return sprintf(
            "oauth_token=%s&oauth_token_secret=%s",
            $this->urlencodeRFC3986($this->accessToken),
            $this->urlencodeRFC3986($this->accessSecret)
        );
    }



}