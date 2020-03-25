<?php
/**
 * CakePHP(tm) : Rapid Development Framework (https://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 * @link          https://cakephp.org CakePHP(tm) Project
 * @package       app.View.Layouts
 * @since         CakePHP(tm) v 0.10.0.1076
 * @license       https://opensource.org/licenses/mit-license.php MIT License
 */
?>
<!DOCTYPE html>
<html>
	<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<?php
		echo $this->Html->css('bootstrap');
		echo $this->Html->css('custom.min');
	?>
	</head>
	<link rel="stylesheet" type="text/css" href="">
	<title>
	</title>
	</head>
	<body>
		<div class="container">
		<?php echo $this->Flash->render(); ?>
			<?php echo $this->fetch('content'); ?>
		</div>
		<?php
		echo $this->Html->script('jquery.min');
		echo $this->Html->script('popper.min');
		echo $this->Html->script('bootstrap.min');
		echo $this->Html->script('custom');
	?>
	</body>
</html>
