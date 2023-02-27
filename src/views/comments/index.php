<h2>SPA веб-сайт с простой системой комментирования.</h2>

<?php
$info  = $data['info'];
?>

<div class="info">
<?php foreach($info as $info) :  ?>
	<h3><?= $info['name']; ?></h3>
	<p><?= $info['description']; ?></p>
<?php endforeach; ?>
</div>

<br>
<form method="POST" id="commentForm">
	<div class="form-group">
		<input type="text" name="name" id="name" class="form-control" placeholder="Your Name" required />
	</div>
	<div class="form-group">
		<input type="text" name="email" id="email" class="form-control" placeholder="Your Email" />
	</div>
	<div class="form-group">
		<input type="text" name="title" id="title" class="form-control" placeholder="Title" required />
	</div>
	<div class="form-group">
		<textarea name="text" id="text" class="form-control" placeholder="Text Comment" rows="5" required></textarea>
	</div>
	
	<span><label id="text-message"></label></span>
	<br>
	
	<div class="form-group">
		<input type="submit" name="submit" id="submit" class="btn btn-primary" value="Post Comment" />
	</div>
</form>

<br>
<div id="showComments">
	<?php include('items.php');  ?>
</div>

<script src="/web/js/comments.js"></script>