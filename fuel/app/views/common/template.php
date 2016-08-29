<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title>さいとくろ〜ら〜★</title>
	<?php echo $css ?>
</head>
<body>
	<div id="app" class="clearfix">
		<div id="side" class="left">
			<ul>
				<?php foreach ( $sites as $site ): ?>
				<li><a href="/?<?php echo $site['url']; ?>"><?php echo strtoupper(str_replace(["http://","https://"],"",$site['url'])); ?></a></li>
				<?php endforeach; ?>
			</ul>
		</div>
		<?php echo $content; ?>
	</div>
	<?php echo $js; ?>
</body>
</html>
