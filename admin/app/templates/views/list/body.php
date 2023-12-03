<?php foreach ($results as $key => $result) { ?>

	<!-- Generate row -->
	<form method="POST" id="row<?= $key ?>" class="row">

		<?php foreach ($result as $entry) { ?>

			<?php if (in_array($entry['type'], ['show', 'find'])) { ?>

				<div class="field">
					<p><?= $entry['value'] ?></p>
				</div>

			<?php } else if ($entry['type'] == 'hidden') { ?>

				<input type="hidden" name="<?= $entry['name'] ?>" value="<?= $entry['value'] ?>">

			<?php } else if ($entry['type'] == 'img') { ?>

				<div class="field">
					<img src="<?= $entry['src'] ?>" alt="" loading="lazy" class="image">
				</div>

			<?php } else if ($entry['type'] == 'btn') include('button.php');

		}?>

	</form>

<?php }