<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

function required($required, $data)
{
	foreach ($required as $field)
		if ( ! isset($data[$field]))
			return FALSE;
	
	return TRUE;
}

function defaults($defaults, $options)
{
	return array_merge($defaults, $options);
}

/* End of file arguments_helper.php */
/* Location: ./application/helpers/arguments_helper.php */