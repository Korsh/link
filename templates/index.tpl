<html>
	<head>
	</head>
	<body>
		<form action="/" method="POST">
			<input type="url" name="url" value="{$origin_url}">
			<input type="hidden" name="short_url_form" value="1">
			<input type="submit" value="Get short url">
		</form>

		<div>
			{if $hash_url}
			{$origin_url}
			<br>
			<a href="/hash/{$hash_url}">{$smarty.server.SERVER_NAME}/hash/{$hash_url}</a>
			{/if}
		</div>
	</body>
</html>
