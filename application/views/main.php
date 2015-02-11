<!DOCTYPE html>
<html lang="en">
	<head>
		<meta http-equiv="Content-type" content="text/html; charset=utf-8">
		<title>Tweets to CSV</title>
		<meta name="description" content="An utility for creating a CSV file from a Twitter timeline.">
		<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0, user-scalable=no">
		<meta name="robots" content="noindex">
		<link rel="stylesheet" href="/assets/css/styles.css" type="text/css">
	</head>
	<body>
			<div id="container">
				<h1>Tweets to CSV</h1>
				
				<form action="/" method="post" accept-charset="utf-8">
					<?php
	$form_error = validation_errors();
	
	if ($form_error != ''):
?>
					<ul class="errors">
					<?=$form_error?>
					</ul>
					
<?php endif; ?>
					
					<dl>
						<dt><label for="username">Twitter Username:</label></dt>
							<dd><input type="text" name="username" id="username" value="<?=set_value('username', '@');?>"></dd>
						<dt><label for="total">Total Tweets:</label></dt>
							<dd>
								<select id="total" name="total">
									<option value="1000000" <?=set_select('total', 'All');?>>All</option>
									<option value="1000" <?=set_select('total', '1000');?>>1000</option>
									<option value="500" <?=set_select('total', '500');?>>500</option>
									<option value="400" <?=set_select('total', '400', TRUE);?>>400</option>
									<option value="300" <?=set_select('total', '300');?>>300</option>
									<option value="200" <?=set_select('total', '200');?>>200</option>
									<option value="100" <?=set_select('total', '100');?>>100</option>
								</select>
							</dd>
					</dl>
					
					<button type="submit">Create CSV</button>
				</form>
			</div>
	</body>
</html>