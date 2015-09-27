<?php
/**
 * Created by PhpStorm.
 * User: Stuart Wilson <stuart@stuartwilsondev.com>
 * Date: 27/09/15
 * Time: 13:43
 */

namespace StuartWilsonDev\TwitterConnectorBundle\Tests\Services;

use StuartWilsonDev\TwitterConnectorBundle\Service\TwitterClient;
use StuartWilsonDev\TwitterConnectorBundle\Service\Token;
use Mockery as m;


class TwitterClientTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var String
     */
    protected $consumerKey = 'testConsumerKey';
    /**
     * @var String
     */
    protected $consumerSecret = 'testConsumerSecret';
    /**
     * @var String
     */
    protected $accessKey = 'testAccessKey';
    /**
     * @var String
     */
    protected $accessSecret = 'testAccessSecret';

    protected $token;

    protected $client;

    const BODY_TEXT = "dummy body text";

    public function setUp()
    {

        $this->token = m::mock('StuartWilsonDev\TwitterConnectorBundle\Service\Token')
            ->shouldReceive('__toString')
            ->andReturn(
                sprintf(
                    "oauth_token=%s&oauth_token_secret=%s",
                    $this->accessKey,
                    $this->accessSecret
                )
            )
            ->getMock();

        $emitter = m::mock('GuzzleHttp\Event\Emitter')
            ->shouldReceive('attach')
            ->getMock();

        $client = m::mock('GuzzleHttp\Client')
            ->shouldReceive('getEmitter')
            ->andReturn($emitter);

        $response =  m::mock('Symfony\Component\HttpFoundation\Response')
            ->shouldReceive('getBody')
            ->andReturn(self::BODY_TEXT);


        $client->shouldRecieve('post')
            ->andReturn($response);


        $this->client = $client->getMock();

    }

    public function testGetStream()
    {

        $twitterClient = new TwitterClient(
            $this->token,
            $this->consumerKey,
            $this->consumerSecret,
            $this->accessKey,
            $this->accessSecret
        );


        $twitterClient->getStream(
            ['track' => "cheese"],
            function($tweet) {
                assertNotEmpty($tweet);
            }
        );

    }
}