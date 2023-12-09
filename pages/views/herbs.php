{% block main %}

<!-- Slider -->
<div id="slider" class="grid">

	<div id="bgr" class="bgr" <?= background_image('bgr.jpg', $view) ?>></div>

		<h1 id="title">Erbe &<br>Tisane</h1>

	</div>

</div>

<div id="content">

	<div class="content-wrap padt4 padb5">

		<?php while ($category = $categories->fetch_assoc()) { ?>

			<section id="<?= $category['tag'] ?>" class="category">

				<div class="title-box txt-cen">
					<div class="icon inlb bgr-c3" <?= icon_svg($category['tag'], $view) ?>></div>
					<h1 class="title txt-c1 txt-3rem txt-sbold"><?= $category['names'] ?></h1>
				</div>

				<div class="list mart2">

					<?php

						$items =  DB::select('* FROM items WHERE type=?', [$category['tag']]);

						while ($row = $items->fetch_assoc()) { ?>

							<form method="POST" class="line grid">

								<input type="hidden" name="id" value="<?= $row['id'] ?>">

								<div class="name-box">

									<p class="name"><?= $row['name'] ?></p>

									<?php if (!empty($row['tech'])) { ?>
										<p class="txt-c1"><?= $row['tech'] ?></p>
									<?php } ?>
									
									<p class="txt-ita"><?= $row['info'] ?></p>
									
									<?php if (!empty($row['ingredients'])) { ?>
										<p class="txt-sbold mart10px">Ingredienti: <?= $row['ingredients'] ?>.</p>
									<?php } ?>

								</div>

								<div class="qty-box grid2">
									<p>Quantità <span class="inlb">(in etti):</span></p>
									<input type="number" name="quantity" value="1" class="inp qty" min="1" max="100" data-price="<?= $row['price'] ?>">
								</div>

								<div class="price-box">
									<h1><span class="price"><?= formatc($row['price']) ?></span> €</h1>
								</div>

								<button type="submit" name="add" class="mbtn">
									<span class="btn-icon bgr-wht" <?= icon_svg('ecommerce/cart') ?>></span>
								</button>

							</form>

					<?php } ?>

					<div class="overlay bgr"></div>

					<p class="show-more">Mostra tutte</p>

				</div>

			</section>

		<?php } ?>

	</div>
		
	<a href="#slider" class="scroll-top">
		<div class="icon-box pad1">
			<?= icon_embed('navigation/arrow1-top') ?>
		</div>
	</a>

</div>

{% end main %}