<!-- Table head -->
<div class="head">

	<?php foreach ($fields as $field) {

		$type = $field['type'] ?? 'show';
		$sort = $field['name'] ?? false;

		if (in_array($type, ['show', 'find', 'btn', 'img'])) {

			//get if it's the active field
			$active = $sort && $sort == $query['index'];

			?>

			<form class="field field-<?= $type == 'btn' ? 'btn' : $field['size'] ?> <?= $sort ? 'clickable' : '' ?>" method="GET">

				<?php if ($sort) {?>
					<input type="hidden" name="search" value="<?= $search ?>">
					<input type="hidden" name="order" value="<?= $query['order'] == 'desc' && $active ? 'asc' : 'desc'?>">
					<input type="hidden" name="index" value="<?= $sort ?>">
				<?php }?>

				<p class="list-field-name txt-line">
					<?= $field['title'] ?? '' ?>
					<?php if ($active) echo $query['order'] == 'desc' ? '&#x25BE;' : '&#x25B4;' ?>
				</p>

			</form>

		<?php } ?>

	<?php } ?>

</div>