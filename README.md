# Tweets to CSV

“Tweets to CSV” is a PHP web-based utility for creating a CSV file from a Twitter user’s timeline.

Here is what it looks like in a browser:

![Tweets to CSV](screenshot.png?raw=true)

This project uses [CodeIgniter](http://www.codeigniter.com), [SASS](http://sass-lang.com), [Bourbon](http://bourbon.io) & @[abraham](https://github.com/abraham)’s [twitteroauth](https://github.com/abraham/twitteroauth).

For those unfamiliar with [CodeIgniter](http://ellislab.com/codeigniter) you can find the project-specific PHP classes in the [application/models](application/models), [application/views](application/views), and [application/controllers](application/controllers) folders.

## Configuration

In order for “Tweets to CSV” to function, you need to define your own OAuth credentials inside the [twitter_model.php](application/models/twitter_model.php) *(lines 14-17)*:

```php
$auth = array(
	'consumer_key'    => '',
	'consumer_secret' => '',
	'access_token'    => '',
	'access_secret'   => ''
);
```

## License

“Tweets to CSV” can be used freely for any open source or commercial works and is released under a [MIT license](http://en.wikipedia.org/wiki/MIT_License).


## Author

[Aaron Clinger](http://aaronclinger.com)