<!DOCTYPE HTML PUBLIC "-//IETF//DTD HTML//EN">
<html>
<head>
<meta name="GENERATOR" content="yiidoc http://www.yiiwiki.com">
</head>
<body>
<object type="text/site properties">
<param name="Window Styles" value="0x800025">
<param name="FrameName" value="right">
<param name="ImageType" value="Folder">
<param name="comment" value="title:Online Help">
<param name="comment" value="base:index.html">
</object>

<ul>
	<li><object type="text/sitemap">
		<param name="Name" value="所有包">
		<param name="Local" value="index.html">
		</object>
<?php foreach($this->categories as $name=>$category): ?>
	<li><object type="text/sitemap">
		<param name="Name" value="<?php echo $category['name']; ?>">
		</object>
	<ul>
	<?php foreach($category['articles'] as $article): ?>
		<li><object type="text/sitemap">
			<param name="Name" value="<?php echo $article->title; ?>">
			<param name="Local" value="<?php echo $article->id; ?>.html">
			</object>
	<?php endforeach; ?>
	</ul>
<?php endforeach; ?>
</ul>
</body>
</html>