<form id="item" method="POST">
		
	<!-- Preview image -->
	<div id="left-block" class="block">

		<div class="img-box">
			<img src="<?= file_url($item->img[0]) ?>" alt="product image" id="image" class="">
		</div>

	</div>

	<!-- Item data -->
	<div id="right-block" class="block grid">

		<!-- Title -->
		<h1 id="title" class="txt-c1 "><?= $item->name ?></h1>
		<h1 id="stitle" class="txt-light txt-a"><?= $item->type->name ?></h1>

		<!-- Price -->
		<div id="price-box" class="mart3 marb3">

			<?php if ($promo) {?>
				
				<h1 id="price-promo"><?= formatc($item->price) ?>€</h1>

			<?php } else {?>

				<h1 id="price" class="txt-c1"><?= formatc($item->price) ?><span style="font-size: .8em">€</span></h1>

			<?php }?>
			
		</div>

		<!-- Quantity -->
		<div id="qty-box" class="field">
			<p class="txt-bold txt-1rem">Quantità:</p>

			<input type="number" id="qty" name="quantity" class="inp txt-bold" value="1" min="1">
		</div>


		<!-- Add to cart -->
		<div class="marb3">
			<button type="submit" id="submit" name="submit" class="mbtn bgr-c4-full">
				<span class="cart-icon btn-icon bgr-f" <?= icon_svg('ecommerce/cart') ?>></span>
				<span class="btn-txt"><strong>Aggiungi al carrello</strong></span>
			</button>
		</div>

		<!-- Infos -->
		<section id="infos" class="marb2">

			<div class="titles flex marb1">

				<?php foreach ($item->infos as $key => $info) { ?>

					<h3 class="title <?= $key ? '' : 'active' ?>" data-id="<?= $key + 1 ?>"><?= $info[0] ?></h3>

				<?php } ?>

			</div>

			<div class="texts">

				<?php foreach ($item->infos as $key => $info) { ?>

					<p class="<?= $key ? '' : 'active' ?>" data-id="<?= $key + 1 ?>"><?= $info[1] ?></p>

				<?php } ?>

			</div>

		</section>

		<p class="txt-09rem mart10px marb1 bgr-f3 pad1"><?= $item->tech ?></p>

	</div>

</form>