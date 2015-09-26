<?php
/**
 * Created by PhpStorm.
 * User: Stuart Wilson <stuart@stuartwilsondev.com>
 * Date: 26/09/15
 * Time: 16:37
 */

namespace StuartWilsonDev\TwitterConnectorBundle\Service;

use Psr\Log\LoggerAwareTrait;

/**
 * Class TokenFactory
 * @package StuartWilsonDev\TwitterConnectorBundle\Service
 */
class TokenFactory {

    use LoggerAwareTrait;


    /**
     * @param $accessToken
     * @param $accessSecret
     * @return Token
     */
    public static function createToken($accessToken, $accessSecret)
    {
        $token = new Token($accessToken, $accessSecret);

        return $token;
    }
}