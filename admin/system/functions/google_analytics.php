<?php

//setup Google Analytics
function google_analytics($user) {

	if (sysData('google_analytics') && !$user->admin)
		return file_get_contents(__ROOT__.'/vendor/google_analytics/analytics.php');
}