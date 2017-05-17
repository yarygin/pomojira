<?php

/**
 * Return the default value of the given value.
 *
 * @param  mixed  $value
 * @return mixed
 */
function value($value)
{
	return $value instanceof Closure ? $value() : $value;
}

/**
 * Gets the value of an environment variable.
 *
 * @param  string  $key
 * @param  mixed   $default
 * @return mixed
 */
function env($key, $default = null)
{
	$value = getenv($key);
	if ($value === false) {
		return value($default);
	}
	return $value;
}