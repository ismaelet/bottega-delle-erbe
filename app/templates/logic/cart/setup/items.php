<?php

function cart_items($cart, $live = false) {

	$orders = cart_orders($cart);

	$buyer = $cart->buyerID;

	?>

	<section id="items" class="section">

		<h1 class="section-title">ARTICOLI</h1>

		<?php while ($order = $orders->fetch_assoc()) {

			$order = new Order($order['id'], '*');

			?>

			<form method="POST">
				<div class="tbl">
					<input name="ordID" type="hidden" value="<?= $order->id;?>">

					<!--Image-->
					<?php if ($order->item->img[1]) { ?>
						<div class="img_cont">
							<div class="item-img" <?= background_image($order->item->img[1]) ?>></div>
						</div>
					<?php } ?>

					<!--Data-->
					<div class="art_data">
						<h1 class="art_name txt-11rem">
							<?php
								if ($order->item->type->category == 'herb') echo $order->quantity == 1 ? $order->quantity.' Etto di ' : $order->quantity.' Etti di ';
								else if ($order->quantity > 1) echo $order->quantity.' x ';
								echo $order->item->name.'<br>';
							?>
						</h1>

						<p class="txt-bold txt-1rem">
							<?= $order->discount ? '<span class="price-old">'.format($order->price * $order->quantity).' €</span>' : format($order->price * $order->quantity).' €';?>								
						</p>

						<?php if ($order->discount) {?>
							<p class="price-promo txt-bold"><?= format(($order->price - $order->discount) * $order->quantity);?> €</p>
						<?php }?>

						<p class="art_spec">
							<?= $order->text[1];?>
						</p>
					</div>

					<?php if ($live) {?>

						<!--Remove-->
						<div class="rem_box">
							<button type="submit" name="remove" class="rem_btn bgr-3" <?= icon_svg('actions/close');?>>
						</div>

					<?php }?>
				</div>
			</form>

		<?php }?>

	</section>
<?php }?>