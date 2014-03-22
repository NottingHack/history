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

// If this is in the commit message, rebuild the book
$special = '>build book<';

// Run the commands for output
$output = '';

/* update the repo */
foreach($commands AS $command){
	// Run it
	$tmp = shell_exec($command);
	// Output
	$output .= "<span style=\"color: #6BE234;\">\$</span> <span style=\"color: #729FCF;\">{$command}\n</span>";
	$output .= htmlentities(trim($tmp)) . "\n";
}

/* Has the special command been invoked? */

$tmp = shell_exec('git log -1');
if (stripos($tmp, $special) !== false) {
	$ouput .= "Rebuild Book";

	$tmp = shell_exec('asciidoctor -d book book.asc');
	$output .= "<span style=\"color: #6BE234;\">\$</span> <span style=\"color: #729FCF;\">{asciidoctor}\n</span>";
	$output .= htmlentities(trim($tmp)) . "\n";
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
