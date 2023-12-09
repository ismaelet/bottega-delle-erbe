{% block main %}

<div class="content-wrap padv5">

	<h1 class="txt-3rem txt-cen marb5">Lista dei prodotti</h1>

	<div id="list">
	
		<?php
			while ($item = $items->fetch_assoc()) {

				$item = new Item($item['id'], 'name');

				if ($letter != strtoupper(substr($item->name, 0, 1))) {

					$letter = strtoupper(substr($item->name, 0, 1));

					$letterNew = true;

				} else $letterNew = false;

				?>

				<?php if ($letterNew) { ?>

					<h3 class="letter txt-25px txt-bold mart1"><?= $letter ?></h3>

				<?php } ?>

				<p class="marv10px txt-09rem">
					<a href="<?= $item->url ?>" class="txt-c2-h">
						<?= $item->name ?>
					</a>
				</p>
				
		<?php } ?>

	</div>

</div>

{% end main %}