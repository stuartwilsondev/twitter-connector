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

    const TWITTER_STREAM_URL = 'https://stream.twitter.com/1.1/';
    const TWITTER_API_URL = 'https://api.twitter.com/1.1/';
    const STATUSES_ENDPOINT = 'statuses/filter.json';
    const USER_TIMELINE_ENDPOINT = 'statuses/user_timeline.json';
    const USER_LOOKUP_ENDPOINT = "users/lookup.json";
    const MAX_RETRIES = 10;

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


    /**
     * Create a client obj
     * @param string $baseUrl
     * @return Client
     */
    private function createClient($baseUrl = self::TWITTER_API_URL)
    {
        $client = new Client([
            'base_url' => $baseUrl,
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
            'max'    => self::MAX_RETRIES,
        ]);
        $client->getEmitter()->attach($retry);
        $client->getEmitter()->attach($oauth);

        return $client;
    }

    /**
     * This method opens a connection to the Twitter streaming API and applies the given callback function to each Tweet
     * @param $track
     * @param $callback
     */
    public function getStream($track, $callback)
    {

        $client = $this->createClient(
            self::TWITTER_STREAM_URL
        );

        $response = $client->post(self::STATUSES_ENDPOINT, [
            'body'   => $track
        ]);


        $body = $response->getBody();

        while (!$body->eof()) {

            //Read a line of the response
            $line = Utils::readLine($body);

            if(!empty($line)) {
                //callback
                call_user_func($callback, $line);
            }

            if( ob_get_level() > 0 ) ob_flush();
            flush();
        }

    }


    /**
     * Get User timeline
     *
     * @param $username
     * @param $noOfTweets
     * @return string
     */
    public function getUserTimeLine($username, $noOfTweets)
    {
        $client = $this->createClient();

        $url = self::USER_TIMELINE_ENDPOINT.'?'.
            http_build_query([
                'screen_name' => $username,
                'count' => $noOfTweets
            ]);

        $response = $client->get($url);

        $body = $response->getBody();

        return $body->getContents();

    }


    /**
     * Get user info
     *
     * @param $userScreenNames (comma separated list)
     * @return string
     */
    public function userLookup($userScreenNames)
    {
        $client = $this->createClient();

        $url = self::USER_LOOKUP_ENDPOINT.'?'.
            http_build_query([
                'screen_name' => $userScreenNames
            ]);
        $response = $client->get($url);

        $body = $response->getBody();

        return $body->getContents();

    }

}
