<div class="field field-btn">

	<?php foreach ($entry['buttons'] as $button) {

		if ($button['type'] == 'link') { ?>

			<a href="<?= $button['url'] ?>" class="btn <?= $button['color'] ?>"><?= $button['title'] ?></a>

		<?php } else if ($button['type'] == 'button') { ?>

			<button
				type="submit"
				name="<?= $button['name'] ?>"
				class="btn <?= $button['color'] ?>"
				<?php if ($button['warning']) {?>
					onclick="return confirm('<?= $button['warning'] ?>')"
				<?php } ?>
			>

				<?= $button['title'] ?>
				
			</button>

		<?php } ?>

	<?php } ?>
	
</div>