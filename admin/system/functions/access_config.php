<?php

function sysData($field) {
	
	global $sysData;

	return $sysData[$field] ?? false;
	
}