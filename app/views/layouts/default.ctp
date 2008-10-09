<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<?php echo $html->charset(); ?>
	<title>
		<?php echo $title_for_layout; ?>
		<?php __('BtShow'); ?>
	</title>
	<?php
		echo $html->meta('icon');

		echo $html->css('cake.generic');
		
		echo $html->css('style');

		echo $scripts_for_layout;
	?>
</head>
<body>
	<div id="container">
		<ul id="header">
			<li class="logo">logo</li>
			<li class="ad">ad</li>
		</ul>
		<div id="content">
			<?php
			if ($session->check('Message.flash')) {
				$session->flash();
			}
			?>

			<?php echo $content_for_layout; ?>

		</div>
		<div id="footer">
			Copyright &copy 2008
		</div>
	</div>
	<?php echo $cakeDebug; ?>
</body>
</html>
