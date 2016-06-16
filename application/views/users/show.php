<p>Posts by <?= $user['name'] ?> (<a href="/quotes">Dashboard</a>) (<a href="/users/logout">Logout</a>)</p>

<p>Count: <?= count($quotes) ?></p>

<?php foreach ($quotes as $quote) { ?>

	<p><strong><?= $quote['author'] ?>:</strong> "<?= $quote['quote'] ?>"</p>

<?php } ?>