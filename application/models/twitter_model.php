<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Twitter_model extends CI_Model {
	
	
	function fetch_tweets($options)
	{
		$this->load->helper('arguments');
		
		if ( ! required(array('screen_name', 'data_type', 'total'), $options))
			return FALSE;
		
		$auth = array(
			'consumer_key'    => '',
			'consumer_secret' => '',
			'access_token'    => '',
			'access_secret'   => ''
		);
		
		$this->load->library('Twitteroauth');
		
		$this->twitteroauth->initialize($auth['consumer_key'], $auth['consumer_secret'], $auth['access_token'], $auth['access_secret']);
		
		$tweets = $this->_get_tweets(array(
			'total'       => $options['total'],
			'data_type'   => $options['data_type'],
			'screen_name' => $options['screen_name']
		));
		
		return $tweets;
	}
	
	function _get_tweets($options)
	{
		if ( ! required(array('screen_name', 'data_type', 'total'), $options))
			return FALSE;
		
		$tweets = array();
		$count  = 0;
		$max_id = FALSE;
		
		while ($count < $options['total'] && isset($max_id))
		{
			$response = $this->_get_page_results(array('screen_name' => $options['screen_name'], 'data_type' => $options['data_type'], 'max_id' => $max_id));
			
			foreach ($response['tweets'] as $tweet)
			{
				$screen_name = $options['data_type'] == 'mentions' ? $tweet->user->screen_name : $options['screen_name'];
				
				array_push($tweets, array(
					$screen_name,
					$tweet->id,
					$tweet->text,
					$tweet->retweet_count,
					$tweet->favorite_count,
					date('Y-m-d H:i:s', strtotime($tweet->created_at))
				));
			}
			
			$max_id = $response['max_id'];
			$count  = count($tweets);
		}
		
		if ($count > $options['total'])
		{
			array_splice($tweets, $options['total']);
		}
		
		return $tweets;
	}
	
	function _get_page_results($options)
	{
		if ( ! required(array('screen_name', 'data_type', 'max_id'), $options))
			return FALSE;
		
		$is_mentions = $options['data_type'] == 'mentions';
		
		if ($is_mentions)
		{
			$api_path = 'search/tweets';
			
			$data = array(
				'q'     => '@' . $options['screen_name'],
				'count' => 100
			);
		}
		else
		{
			$api_path = 'statuses/user_timeline';
			
			$data = array(
				'screen_name'     => $options['screen_name'],
				'count'           => 200,
				'exclude_replies' => 'false',
				'include_rts'     => 'true',
				'trim_user'       => 'true'
			);
		}
		
		if ($options['max_id'] !== FALSE)
		{
			$data['max_id'] = $options['max_id'];
		}
		
		$tweets = $this->twitteroauth->get($api_path, $data);
		
		if ($is_mentions)
		{
			$tweets = $tweets->statuses;
		}
		
		$last = end($tweets);
		
		$data = array(
			'tweets' => isset($tweets->errors) ? array() : $tweets,
			'max_id' => (isset($last) && isset($last->id)) ? $last->id - 1 : NULL
		);
		
		return $data;
	}
}

/* End of file twitter_model.php */
/* Location: ./application/models/twitter_model.php */