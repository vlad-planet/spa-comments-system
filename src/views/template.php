<?php
/* @var $content_view  \app\Controller (generate) */
?>
<!DOCTYPE html>
<html>
	<!-- Подключение параметров заголовка -->
    <?php include('header.php'); ?>

    <body class="">

		<!-- Подключение навигации -->
        <?php include('navigation.php');?>

		<!-- Подключение шаблона -->
        <div class="container">
			<?php include($content_view); ?>
        </div>
		
	<!-- Подключение нижнего блока -->
    <?php include('footer.php');  ?>

    </body>
</html>



