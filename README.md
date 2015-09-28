# Twitter Stream Connector (Symfony2 Bundle)

This bundle makes it easy to access Tweets from the Twitter API. 

#### Installation
Add repo to "repositories" in composer.json
```json
"repositories": [
    {
      "type": "git",
      "url": "https://github.com/stuartwilsondev/twitter-connector.git"
    }
  ],
```

Then add dependency (currently dev-develop, dev-master)
```json
"stuartwilsondev/twitter-connector": "dev-develop",
```

Register bundle in AppKernel
```php
    $bundles = array(
    ...
        new StuartWilsonDev\TwitterConnectorBundle\TwitterConnectorBundle(),
    ...
    )

```

Run
```sh
composer update
```

Include in parameters.yml
```yaml
twitter_consumer_key: {your key} 
twitter_consumer_secret: {your secret} 
twitter_access_token: {your token} 
twitter_access_secret: {your secret}
```

Include in config.yml (I need to fix this duplicate config)
```yaml
twitter_connector: 
  twitter_consumer_key: %twitter_consumer_key% 
  twitter_consumer_secret: "%twitter_consumer_secret%" 
  twitter_access_token: "%twitter_access_token%" 
  twitter_access_secret: "%twitter_access_secret%"
```


#### Usage

##### Streaming endpoint


See Twitter [Streaming API docs](https://dev.twitter.com/streaming/reference/post/statuses/filter "Twitter Streaming API")


The getStream Method takes 2 arguments.
- $track. The filter to be applied to the stream (array with comma separated values)
- $callback (optional). A function that will be applied to each Tweet.


```php
$client = $this->get('twitter_connector.twitter_client');
$client->getStream(['track' => 'potato,elephant,cheese'], function($tweet) {
    
    //do what you need to do with the Tweet here (applied to each Tweet)
    //In this example I just decode the json and print the 'created_at' and 'text'
    //e.g.
    $tweetData = json_decode($tweet);
    
    $out = [
        'created_at' => $tweetData->created_at,
        'text' => $tweetData->text
    ];
            
    print_r($out);

});
```

##### User timeline


See Twitter [User Timeline docs](https://dev.twitter.com/rest/reference/get/statuses/user_timeline "Twitter User timeline API")


The getUserTimeLine Method takes 2 arguments.
- $username. The user whose timeline we wish to get
- $noOfTweets (default 10). The number of tweets to retrieve 


```php
$client = $this->get('twitter_connector.twitter_client');
$tweets = $client->getUserTimeLine('stuartwilsondev',10);

    $tweetsData = json_decode($tweets);

    print_r($tweetsData);

```