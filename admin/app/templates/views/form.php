{% extends admin %}

{% block content %}

<section class="form-box grid">

	<form method="POST" action="#form" enctype="multipart/form-data" autocomplete="off" id="form" class="form file-form panel">

		<!-- Head -->
		<section class="head">

			<p class="title bgr-c1 txt-sbold txt-wht"><?= $page['title'] ?></p>

		</section>

		<?php if ($page['free']) { ?>

			{% place form %}
			{% end form %}

		<?php } else { ?>

			<!-- Body -->
			<div class="body">

				<?php if ($inputs) gen_form($inputs, $entry, $error, $done) ?>

			</div>

			<!-- Footer -->
			<div class="footer">

				<button
					type="submit"
					id="submit"
					class="mbtn <?= $page['upload'] ? 'file-submit' : '';?>"
					name="<?= $page['edit'] ? 'edit' : 'add' ?>"
					<?php if ($page['confirmation']) { ?>onclick="return confirm('<?= $page['confirmation'] ?>')"<?php } ?>
				>

					<?= $page['edit'] ? 'Modifica' : 'Aggiungi';?>
					
				</button>

				<?php if ($page['upload']) { ?>
					<div class="file-load"></div>
				<?php } ?>

				<a href="<?= $page['back_url'] ?>" class="sbtn">Indietro</a>

			</div>

		<?php } ?>

	</form>

</section>

{% end content %}