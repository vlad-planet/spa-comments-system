<?php
/* @var $data  \controllers\CommentsController (actionItems) */
?>

<?php
$commentHTML = '';

$items = $data['items'];

foreach($items as $item){
	$commentHTML .= '
		<div class="panel panel-primary">
		<div class="panel-heading">By <b>'.$item["name"].'</b> on <i>'.$item["date"].'</i> <u>'.$item["email"].'</u></div>
		<div class="panel-body">'.'<h4>'.$item["title"].'</h4>'.$item["text"].'</div>
		</div>';
}

echo $commentHTML;
?>