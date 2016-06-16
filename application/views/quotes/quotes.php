<h3>Welcome, <?= $current_user['name'] ?>! (<a href="/users/logout">Logout</a>)</h3> 

<h3>Contribute a Quote</h3>

<?php

	if ($this->session->flashdata('errors')) {
		
		echo $this->session->flashdata('errors');

	}

?>

<form action="/quotes/create" method="post">
	<p>Author: <input type="text" name="author"></p>
	<p>Quote: <input type="text" name="quote"></p>
	<p><input type="submit" value="Post"></p>
</form>

<?php foreach ($quotes as $quote) { ?>
	<p><?= $quote['author'] ?>: "<?= $quote['quote'] ?>" (Posted by <a href="/users/show/<?= $quote['user_id'] ?>"><?= $quote['name'] ?></a>)</p>
	<p><a href="/quotes/add_favorite/<?= $quote['id'] ?>"><button>Add to My List</button></a></p>
<?php } ?>

<h3>Your Favorites</h3>

<?php foreach ($favorites as $favorite) { ?>
	<p><?= $favorite['author'] ?>: "<?= $favorite['quote'] ?>" (Posted by <a href="/users/show/<?= $favorite['user_id'] ?>"><?= $favorite['name'] ?></a>)</p>
	<p><a href="/quotes/remove_favorite/<?= $favorite['id'] ?>"><button>Remove from List</button></a></p>
<?php } ?>
