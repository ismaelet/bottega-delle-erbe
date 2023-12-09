<?php

//generate item grid function
function item_grid($res) {
	
	global $user;

	?>

		<form method="POST" id="add-to-cart-form" class="hide">

			<input type="hidden" name="itemID" value="">

			<button type="submit" name="add-to-cart" class="hide"></button>
			
		</form>

	<?php

	while ($row = $res->fetch_assoc()) {

		$item = new Item($row['ID'], ['name', 'img', 'price', 'loved']);

		?>
		
		<div class="item-box al-top">
			<div>
				<a class="item-img img cont" <?= background_image($item->img[1]) ?> href="<?= $item->url ?>">
					
					<?php /* <p class="des_prc prc_blu"><?= formatc($item->price) ?>€</p> */?>
				</a>

				<?php //element_love_button($item->design->id, $item->design->loved) ?>
			</div>


			<p class="item-type txt-upp"><?= $item->type->name ?></p>
			<p class="item-name"><?= $item->name ?></p>

			<div class="item-cart-box">

				<p class="item-price"><?= formatc($item->price) ?> €</p>

				<div class="item-cart fill-c1 fill-wht-h" data-id="<?= $item->id ?>">
					<div class="icon-box cen">
						 <?= icon_embed('ecommerce/add-to-cart') ?>
					</div>
				</div>

			</div>
		</div>
		
<?php }}