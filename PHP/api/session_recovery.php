<?php
	if (!session_id()) {
		session_start();
	}

	if (isset($_COOKIE[$session_logged])) {
		$user = unserialize($_COOKIE[$session_logged]);
		unset($_COOKIE[$session_logged]);
		setcookie($session_logged, serialize($user), time() + (86400*365), "/"); // 86400 = 1 day

		if (!isset($_SESSION[$session_logged])) {
			$_SESSION[$session_logged] = $user;
		}
	}

	$user = isset($_SESSION[$session_logged]) ? $_SESSION[$session_logged] : null;
?>