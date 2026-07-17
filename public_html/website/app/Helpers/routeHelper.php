<?php

if (!function_exists('prefixActive')) {
	function prefixActive($prefixName)
	{
		return	request()->route()->getPrefix() == $prefixName ? 'active' : '';
	}
}

if (!function_exists('prefixBlock')) {
	function prefixBlock($prefixName)
	{
		return	request()->route()->getPrefix() == $prefixName ? 'menu-open' : '';
	}
}

if (!function_exists('routeActive')) {
	function routeActive($routeName)
	{
		return	request()->routeIs($routeName) ? 'active' : '';
	}
}
