<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
        <head>
                <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
                <meta name="language" content="en" />

                <!-- blueprint CSS framework -->
                <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/screen.css" media="screen, projection" />
                <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/print.css" media="print" />
                <!--[if lt IE 8]>
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/ie.css" media="screen, projection" />
	<![endif]-->

                <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/main.css" />
                <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/form.css" />
                <style type="text/css">
                    label {
                        display: block !important;
                    }
                </style>

                <title><?php echo CHtml::encode($this->pageTitle); ?></title>
        </head>

        <body>

                <div class="container" id="page">

                        <div id="header">
                                <div id="logo"><?php echo CHtml::encode(Yii::app()->name); ?></div>
                            <?php if (Yii::app()->params['server'] == CAlexHelper::PRODUCTION): ?>
                                <div><p>Редактирование отключено</p></div>
                            <?php endif; ?>
                        </div><!-- header -->

                        <div id="mainmenu">
				<?php
					$this->widget('zii.widgets.CMenu', array(
						'items' => array(
							array('label' => 'Категории', 'url' => array('/admin/category/')),
							array('label' => 'Брэнды', 'url' => array('/admin/brand/')),
							array('label' => 'Товары', 'url' => array('/admin/good/')),
							array('label' => 'Группы Характеристик', 'url' => array('/admin/group/')),
							array('label' => 'Характеристики товаров', 'url' => array('/admin/attr/')),
							array('url' => Yii::app()->getModule('user')->loginUrl, 'label' => Yii::app()->getModule('user')->t("Login"), 'visible' => Yii::app()->user->isGuest),
							array('url' => Yii::app()->getModule('user')->registrationUrl, 'label' => Yii::app()->getModule('user')->t("Register"), 'visible' => Yii::app()->user->isGuest),
							array('url' => Yii::app()->getModule('user')->profileUrl, 'label' => Yii::app()->getModule('user')->t("Profile"), 'visible' => !Yii::app()->user->isGuest),
							array('url' => Yii::app()->getModule('user')->logoutUrl, 'label' => Yii::app()->getModule('user')->t("Logout") . ' (' . Yii::app()->user->name . ')', 'visible' => !Yii::app()->user->isGuest),
						),
					));
				?>
	                        </div><!-- mainmenu -->

			<?php
					$this->widget('zii.widgets.CBreadcrumbs', array(
						'links' => $this->breadcrumbs,
					));
			?><!-- breadcrumbs -->

			<?php echo $content; ?>

		                        <div id="footer">
				Copyright &copy; <?php echo date('Y'); ?> by My Company.<br/>
			All Rights Reserved.<br/>
				<?php echo Yii::powered(); ?>
					<div>
					Отработало за <?= sprintf('%0.5f', Yii::getLogger()->getExecutionTime()) ?> с.
				Скушано памяти: <?= round(memory_get_peak_usage() / (1024 * 1024), 2) . "MB" ?>
				</div>
                        </div><!-- footer -->

                </div><!-- page -->

        </body>
</html>