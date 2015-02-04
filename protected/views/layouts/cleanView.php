<?php
/* 
Small business administrator
Copyright (C) 2013 JULIO ALEXANDER GUEVARA MARULANDA

This program is free software: you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation, either version 3 of the License, or
(at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program.  If not, see <http://www.gnu.org/licenses/>.
*/
/* @var $this Controller */
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta name="language" content="es" />

	<!-- blueprint CSS framework -->
	<title><?php echo CHtml::encode($this->pageTitle); ?></title>
	<?php Utilities::initMainLayout();?>
	<link rel="stylesheet" type="text/css" href="screen.css" media="screen, projection" />
</head>
<body>
<div id="page">
	<div class="container" style="margin:20px 20px;">
		<div id="header">
			<div id="logo"></div>
		</div><!-- header -->
	<?php echo $content; ?>
	</div><!-- container -->
</div><!-- page -->
</body>
</html>
