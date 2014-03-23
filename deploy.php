<?php
/**
* GIT DEPLOYMENT SCRIPT
*
* Used for automatically deploying websites via github or bitbucket, more deets here:
*
* https://gist.github.com/1809044
*/

// The commands
$commands = array(
				  'echo $PWD',
				  'whoami',
				  'git pull 2>&1',
				  'git status',
				  //'git submodule sync',
				  //'git submodule update',
				  //'git submodule status',
);

// Run the commands for output
$output = '';

/* update the repo */
foreach($commands AS $command){
	// Run it
	$tmp = shell_exec($command);
	// Output
	$output .= '<span style="color: #6BE234;">\$</span> <span style="color: #729FCF;">{' . $command . '}\n</span>';
	$output .= htmlentities(trim($tmp)) . "\n";
}

/* Has a special command been invoked? */

$tmp = shell_exec('git log -1');
if (preg_match("/\>\>([a-zA-Z0-9\-\_\/]+)\<\</", $tmp, $matches) > 0) {
	
	// check the file exists
	if (file_exists($matches[1] . '.asc')) {
		$command = 'asciidoctor -d book ' . $matches[1] . '.asc';

		$tmp = shell_exec($command);
		$output .= '<span style="color: #6BE234;">\$</span> <span style="color: #729FCF;">{' . $command . '}\n</span>';
		$output .= htmlentities(trim($tmp)) . "\n";
	}
	else {
		$output .= '<span style="color: #FF0000;">File not found: ' . $matches[1] . '.asc</span>';
	}
}


// Make it pretty for manual user access (and why not?)
?>
<!DOCTYPE HTML>
<html lang="en-US">
<head>
	<meta charset="UTF-8">
	<title>Nottinghack Deployment Script v1.0</title>
</head>
<body style="background-color: #000000; color: #FFFFFF; font-weight: bold; padding: 0 10px;">
<pre>
Nottinghack Deployment Script v1.0

<?php echo $output; ?>
</pre>
</body>
</html>
