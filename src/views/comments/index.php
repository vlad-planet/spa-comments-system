<?php
/* @var $data  \controllers\CommentsController (actionIndex) */
?>

<div id="comments" class="container">
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
	<div id="commentForm">
		<div class="form-group">
			<input type="text" v-model="comments.name"  class="form-control" placeholder="Your Name" required />
		</div>
		<div class="form-group">
			<input type="text" v-model="comments.email"  class="form-control" placeholder="Your Email" />
		</div>
		<div class="form-group">
			<input type="text" v-model="comments.title" class="form-control" placeholder="Title" required />
		</div>
		<div class="form-group">
			<textarea v-model="comments.text" class="form-control" placeholder="Text Comment" rows="5" required></textarea>
		</div>

		<div v-for="(error, index) in errors"><label v-bind:class="status" >{{error.message}} </label></div>
		
		<div class="form-group">
			<input type="submit" v-on:click="sendIdentity()" class="btn btn-primary" value="Post Comment" />
		</div>
	</div>

	<div id="showComments" class="panel panel-primary" v-for="(item, index) in items">
		<div class="panel-heading">By <b>{{ item.name }}</b> on <i>{{ item.date }}</i> <u>{{ item.email }}</u></div>
		<div class="panel-body"><h4>{{ item.title }}</h4>{{ item.text }}</div>
	</div>

</div>

<script src="/web/js/comments.js"></script>