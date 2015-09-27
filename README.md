# Twitter Stream Connector (Symfony2 Bundle)

This bundle makes it easy to access Tweets from the Twitter Streaming API. 

See Twitter [Streaming API docs](https://dev.twitter.com/streaming/reference/post/statuses/filter "Twitter Streaming API")


The main Method (getStream) takes 2 arguments.
- $track. The filter to be applied to the stream (array with comma separated values)
- $callback. A function that will be applied to each Tweet.

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
        new StuartWilsonDev\TestBundle\StuartWilsonDevTestBundle()
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

```php
$client = $this->get('twitter_connector.twitter_client');
$client->getStream(['track' => 'potato,elephant,cheese'], function($tweet) {
    
    //do what you need to do with the Tweet here (applid to each Tweet)
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