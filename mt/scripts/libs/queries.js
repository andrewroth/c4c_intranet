function mt_api_call(api_func, obj, func)
{
	obj['call'] = api_func;

	return $.getJSON("query.php5", obj, func);
}