<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Main extends CI_Controller {

	public function index()
	{
		$this->load->library('form_validation');
		
		$this->form_validation->set_rules('username', 'username', 'required|trim|callback__is_twitter_username');
		$this->form_validation->set_rules('total', 'total', 'required|trim|is_natural_no_zero');
		
		if ($this->form_validation->run())
		{
			$this->load->model('twitter_model');
			
			$tweets = $this->twitter_model->fetch_tweets(array('twitter_username' => $this->input->post('username'), 'total' => intval($this->input->post('total'))));
			
			if ( ! empty($tweets))
			{
				$this->output->set_content_type('text/csv; charset=utf-8');
				$this->output->set_header('Content-Disposition: attachment; filename=tweets.csv');
				
				$csv = "\"Tweet ID\",\"Tweet Text\",\"Retweets\",\"Favorites\",\"Date\"\r";
				
				foreach ($tweets as $tweet)
				{
					$tweet = array_map(function ($v) {
						return '"' . str_replace('"', '""', $v) . '"';
					}, $tweet);
					
					$csv .= implode(',', $tweet) . "\r";
				}
				
				$this->output->set_output($csv);
				
				return;
			}
		}
		
		$this->load->view('main');
	}
	
	public function _is_twitter_username($str)
	{
		$username = str_replace('@', '', $str);
		$username = preg_replace('/https?:\/\/(?:www\.)?twitter\.com\/([a-zA-Z0-9_]+)/i', '$1', $username);
		
		if (preg_match('/^[a-zA-Z0-9_]+$/', $username) == FALSE)
		{
			$this->form_validation->set_message('_is_twitter_username', 'Please specify a valid Twitter username.');
			
			return FALSE;
		}
		
		return $username;
	}
}

/* End of file main.php */
/* Location: ./application/controllers/main.php */