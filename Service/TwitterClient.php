<?php
/**
 * Created by PhpStorm.
 * User: Stuart Wilson <stuart@stuartwilsondev.com>
 * Date: 26/09/15
 * Time: 15:38
 */

namespace StuartWilsonDev\TwitterConnectorBundle\Service;

use GuzzleHttp\Client;
use GuzzleHttp\Stream\Utils;
use GuzzleHttp\Subscriber\Oauth\Oauth1;
use Psr\Log\LoggerAwareTrait;
use GuzzleHttp\Subscriber\Retry\RetrySubscriber;
/**
 * Class TwitterClient
 * @package StuartWilsonDev\TwitterConnectorBundle\Service
 */
class TwitterClient
{
    use LoggerAwareTrait;

    const TWITTER_API_URL = 'https://stream.twitter.com/1.1';
    const STATUSES_ENDPOINT = '/statuses/filter.json';

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
        Token $token,  //Not used yet
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

    public function getStream($track, $callback)
    {

        $client = new Client([
            'base_url' => 'https://stream.twitter.com/1.1/',
            'defaults' => ['auth' => 'oauth', 'stream' => true],
        ]);

        $oauth = new Oauth1(
            [
                'consumer_key'    => $this->consumerKey,
                'consumer_secret' => $this->consumerSecret,
                'token'           => $this->accessKey,
                'token_secret'    => $this->accessSecret
            ]
        );

        $retry = new RetrySubscriber([
            'filter' => RetrySubscriber::createStatusFilter([503]),
            'max'    => 4,
        ]);
        $client->getEmitter()->attach($retry);
        $client->getEmitter()->attach($oauth);


        $response = $client->post('statuses/filter.json', [
            'body'   => $track
        ]);


        $body = $response->getBody();

        while (!$body->eof()) {

            //Read a line of the response
            $line = Utils::readLine($body);

            if(!empty($line)) {

                call_user_func($callback, $line);
            }

            if( ob_get_level() > 0 ) ob_flush();
            flush();
        }

    }

}
