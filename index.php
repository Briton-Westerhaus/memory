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
		<script type="text/javascript">
			function displayNotification(message) {
				let notification = document.getElementById('Notification');
				notification.innerHTML = message;
				notification.style.top = "-2px";
				window.setTimeout(function() {
					notification.style.transition = "1s linear 3s";
					notification.style.top = "-3.5em";
				}, 100);
			}

			function flip() {
				let flipper = document.getElementById('Flipper');
				if (!!flipper) {
					flipper.style.transform = "rotateY(180deg)";
				}
			}
		</script>
		<?php
			if (isSet($_POST['submitButton']) && $_POST['submitButton'] == 'New Game') {
				unset($_SESSION['height']);
				unset($_SESSION['width']);
			}
			if (isSet($_SESSION['height']) && isSet($_SESSION['width'])) {
				echo '<style type="text/css">';
				echo '  .aspect-ratio-maintainer {';
				echo '    padding-bottom: ' . ($_SESSION['height'] / $_SESSION['width'] * 100) . '%;';
				echo '  }';
				echo '	td {';
				echo '		height: ' . (100 / $_SESSION['height']) . '%;';
				echo '		width: ' . (100 / $_SESSION['width']) . '%;';
				echo '	}';
				echo '</style>';
			}
		?>
	</head>
	<body onload="flip();">
		<div class="content">
			<div id="Notification"></div>
			<h1>Memory</h1>
			<?php
				$isshowing = false;
				if ($_POST['submitButton'] == 'Small') {
					setMatrix(3 ,4);
				} else if ($_POST['submitButton'] == 'Medium') {
					setMatrix(4, 5);
				} else if ($_POST['submitButton'] == 'Large') {
					setMatrix(5, 6);
				} 
				if (!isSet($_SESSION['height']) || !isSet($_SESSION['width']) || !isSet($_SESSION['matrix']) || $_POST['submitButton'] == 'New Game') {
					?>
					<h3>What size board?</h3>
					<form action="index.php" method="post">
						<section>
							<input type="submit" name="submitButton" value="Small" />
							<h5>(3 x 4)</h5>
						</section><!--
						--><section>
							<input type="submit" name="submitButton" value="Medium" />
							<h5>(4 x 5)</h5>
						</section><!--
						--><section>
							<input type="submit" name="submitButton" value="Large" />
							<h5>(5 x 6)</h5>
						</section>
					</form>
					<?php
				} else {
					if ($_SESSION['flipped'] == 0 && !($_POST['submitButton'] == 'Small' || $_POST['submitButton'] == 'Medium' || $_POST['submitButton'] == 'Large')) {
						$temp = explode(":", $_POST['submitButton']);
						$_SESSION['matrix'][$temp[1]][$temp[2]]['temp'] = 1;
						$_SESSION['flipped']++;
					} else {
						if ($_SESSION['flipped'] == 1 && $_POST['submitButton'] != 'Flip back over') {
							// Completed turn
							$_SESSION['turn_count']++;
							$isshowing = true;
							$temp = explode(":", $_POST['submitButton']);
							$_SESSION['matrix'][$temp[1]][$temp[2]]['temp'] = 1;
							$firsti = 5;
							$firstj = 5;
							for ($i = 0; $i < $_SESSION['height']; $i++) {
								for ($j = 0; $j < $_SESSION['width']; $j++) {
									if ($_SESSION['matrix'][$i][$j]['temp'] > 0) {
										if ($firsti == 5) {
											$firsti = $i;
											$firstj = $j;
										} else {
											if ($_SESSION['matrix'][$firsti][$firstj]['card'] == $_SESSION['matrix'][$i][$j]['card']) {
												$_SESSION['matrix'][$firsti][$firstj]['flipped'] = 1;
												$_SESSION['matrix'][$i][$j]['flipped'] = 1;
												$isshowing = false;
												displayBoard($isshowing);
												$skipShow = true;
												flippy();
											}
										}
									}
								}
							}
						}
					}
					if ($_POST['submitButton'] == 'Flip back over')
						flippy();
					if (!$skipShow)
						displayBoard($isshowing);
				}
			?>
		</div>
	</body>
</html>