<?php if (!empty($warning)) {?>
	<p id="news" class="<?= $warning_color ?>"><?= $warning ?></p>
<?php }?>

<h1 class="section-title">PAGAMENTO</h1>

<form id="payments" class="marb2" method="POST">

	<?php while ($payment = $payments->fetch_assoc()) {?>

		<label class="payment">

			<!-- Checkox -->
			<div>

				<input type="checkbox" class="cbx-mirror" name="paymentID[]" value="<?= $payment['id'] ?>" <?= $cart->paymentID == $payment['id'] ? 'checked' : '' ?>>

				<div class="cbx-icon big">
					<div class="cbx-icon-dot"></div>
				</div>

			</div>

			<!-- Data -->
			<div class="data">

				<?php if (file_exists(__ROOT__ . $image = '/app/templates/images/cart/payment-'.$payment['tag'].'.png')) { ?>
					<img src="<?= file_url($image) ?>" class="image">
				<?php } ?>

				<h1 class="name"><?= $payment['name'] ?></h1>
				<p class="desc"><?= $payment['text'] ?></p>

			</div>

		</label>

	<?php } ?>

	<button type="submit" name="submit" id="submit" class="hide"></button>
	
</form>

<!-- Recap -->
<?php cart_recap($cart, true) ?>