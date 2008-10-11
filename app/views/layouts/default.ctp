<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
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
		<?php echo $this->element('header')?>
		<div id="content">
			<?php
			if ($session->check('Message.flash')) {
				$session->flash();
			}
			?>

			<?php echo $content_for_layout; ?>

		</div>
		<?php echo $this->element('footer')?>
	</div>
	<?php echo $cakeDebug; ?>
</body>
</html>
