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
 * @package       app.View.Layouts.Email.html
 * @since         CakePHP(tm) v 0.10.0.1076
 * @license       https://opensource.org/licenses/mit-license.php MIT License
 */
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01//EN">
<html>
<head>
	<title><?php echo $this->fetch('title'); ?></title>
</head>
<body>
	<?php echo $this->fetch('content'); ?>
	
	<p>Microblog 2 Account Verification</a></p>
	<p>Hi <?php echo $name.','; ?></p>
	<p>Here is your validation code : <?php echo $token.','; ?></p>
	<p>Click the link below to activate your account:</p>

	<p><a href="<?php echo $link; ?>" style="box-shadow: 0px 1px 0px 0px #f0f7fa;
		background:linear-gradient(to bottom, #33bdef 5%, #019ad2 100%);
		background-color:#33bdef;
		display:inline-block;
		cursor:pointer;
		color:#ffffff;
		font-family:Arial;
		font-size:15px;
		font-weight:bold;
		padding:16px 76px;
		text-decoration:none;
		text-shadow:0px -1px 0px #5b6178;background:linear-gradient(to bottom, #019ad2 5%, #33bdef 100%);
		background-color:#019ad2;">Click here to activate your account now</a>
	</p>
	<p>Regards from Microblog Team</p>
</body>
</html>