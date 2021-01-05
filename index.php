<?php
	session_start();
	require "memory.php";
?>
<!DOCTYPE html>
<html>
	<head>
		<title>Briton Westerhaus - Memory</title>
		<meta name="description" content="An online version of the memory game." />
		<meta name="keywords" content="media, entertainment, fun, games" />
		<meta name="author" content="Briton Westerhaus" />
		<link rel="stylesheet" type="text/css" href="default.css" />
	</head>
	<body>
		<div class="content">
			<h1>Memory</h1>
			<?php
				$isshowing = 0;
				if (!isSet($_SESSION['matrix'])) {
					setMatrix();
					View(); // What is this?
				} else {
					if ($_SESSION['flipped'] == 0) {
						$temp = explode(":", $_POST['submit']);
						$_SESSION['matrix'][$temp[1]][$temp[2]]['temp'] = 1;
						$_SESSION['flipped']++;
					} else {
						if ($_SESSION['flipped'] == 1 && $_POST['submit'] != 'Flip back over') {
							$isshowing = 1;
							$temp = explode(":", $_POST['submit']);
							$_SESSION['matrix'][$temp[1]][$temp[2]]['temp'] = 1;
							$firsti = 5;
							$firstj = 5;
							for ($i = 0; $i < 4; $i++) {
								for($j = 0; $j < 4; $j++){
									if ($_SESSION['matrix'][$i][$j]['temp'] == 1) {
										if($firsti == 5){
											$firsti = $i;
											$firstj = $j;
										} else {
											if ($_SESSION['matrix'][$firsti][$firstj]['card'] == $_SESSION['matrix'][$i][$j]['card']) {
												$_SESSION['matrix'][$firsti][$firstj]['flipped'] = 1;
												$_SESSION['matrix'][$i][$j]['flipped'] = 1;
												flippy();
												$isshowing = 0;
											}
										}
									}
								}
							}
						}
					}
					if ($_POST['submit'] == 'Reset')
						setMatrix();
					if ($_POST['submit'] == 'Flip back over')
						flippy();
				}
				
				displayBoard($isshowing);
			?>
		</div>
	</body>
</html>