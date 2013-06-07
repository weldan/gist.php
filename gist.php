#!/usr/bin/env php
<?php
if (!isset($argv[1])) {
	echo "==================================\n";
	echo "Usage: ./gist.php filename\n";
	echo "==================================\n";
}
if (isset($argv[1])) {

	$api = 'https://api.github.com/gists';
	$filename = basename($argv[1]);
	$filecontent = file_get_contents($argv[1]);

	$input_array = array(
		'desc' => 'Created by gist.php',
		'public' => true,
		'files' => array(
			$filename => array(
				'content' => $filecontent
			)
		)
	);
	
	$payload = json_encode($input_array);
	
	$headers = array(
		"Content-Type: application/x-www-form-urlencoded"
	);

	$process = curl_init($api);
	$curl_version = curl_version();
	
	curl_setopt($process, CURLOPT_CUSTOMREQUEST, "POST");
	curl_setopt($process, CURLOPT_POSTFIELDS, $payload);
	curl_setopt($process, CURLOPT_SSL_VERIFYPEER, false);
	curl_setopt($process, CURLOPT_USERAGENT, "curl/".$curl_version['version']);
	curl_setopt($process, CURLOPT_RETURNTRANSFER, true);	
	curl_setopt($process, CURLOPT_HTTPHEADER, $headers);

	$response = curl_exec($process);
	if ($response) {
		$result = json_decode($response);
		echo "===========================================\n";
		echo "Gist URL: ".$result->html_url."\n";
		echo "===========================================\n";
	}
	
}

?>
