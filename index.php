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
		<?php
			if ($_POST['submit'] == 'Reset') {
				unset($_SESSION['height']);
				unset($_SESSION['width']);
			}
			if (isSet($_SESSION['height']) && isSet($_SESSION['width'])) {
				echo '<style type="text/css">';
				echo '  table {';
				echo '    height: ' . (156 * $_SESSION['height'] + 4) . 'px;';
				echo '    width: ' . (156 * $_SESSION['width'] + 4) . 'px;';
				echo '  }';
				echo '	td {';
				echo '		height: ' . (100 / $_SESSION['height']) . '%;';
				echo '		width: ' . (100 / $_SESSION['width']) . '%;';
				echo '	}';
				echo '</style>';
			}
		?>
	</head>
	<body>
		<div class="content">
			<h1>Memory</h1>
			<?php
				$isshowing = false;
				if (!isSet($_SESSION['height']) || !isSet($_SESSION['width']) || !isSet($_SESSION['matrix']) || $_POST['submit'] == 'Reset') {
					echo '<h3>What size board?</h3>';
					echo '<form action="index.php" method="post">';
					echo '<input type="submit" name="submit" value="3 x 4" />';
					echo '<input type="submit" name="submit" value="4 x 5" />';
					echo '<input type="submit" name="submit" value="5 x 6" />';
					echo '</form>';
					
				} else {
					if ($_POST['submit'] == '3 x 4') {
						echo "Setting 3 x 4";
						setMatrix(3 ,4);
					} else if ($_POST['submit'] == '4 x 5') {
						setMatrix(4, 5);
					} else if ($_POST['submit'] == '5 x 6') {
						setMatrix(5, 6);
					} else {
						if ($_SESSION['flipped'] == 0) {
							$temp = explode(":", $_POST['submit']);
							$_SESSION['matrix'][$temp[1]][$temp[2]]['temp'] = 1;
							$_SESSION['flipped']++;
						} else {
							if ($_SESSION['flipped'] == 1 && $_POST['submit'] != 'Flip back over') {
								// Completed turn
								$_SESSION['turn_count']++;
								$isshowing = true;
								$temp = explode(":", $_POST['submit']);
								$_SESSION['matrix'][$temp[1]][$temp[2]]['temp'] = 1;
								$firsti = 5;
								$firstj = 5;
								for ($i = 0; $i < $_SESSION['height']; $i++) {
									for ($j = 0; $j < $_SESSION['width']; $j++) {
										if ($_SESSION['matrix'][$i][$j]['temp'] == 1) {
											if ($firsti == 5) {
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
					}
					if ($_POST['submit'] == 'Flip back over')
						flippy();
					displayBoard($isshowing);
				}
			?>
		</div>
	</body>
</html>