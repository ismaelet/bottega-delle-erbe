<?php

function cart_recap($cart, $active = true) {

	$credit_used = 0 ?>

	<section id="recap">

		<h1 class="section-title">RIEPILOGO</h1>

		<div id="chck_box">
			<div class="chck_item">
				<p class="chck_name">Articoli</p>
				<h1 class="chck_pric"><?= format($cart->prices()['items']) ?>€</h1>
			</div>

			<div class="chck_item">
				<p class="chck_name">Spedizione</p>
				<h1 id="chck_totShip" class="chck_pric"><?= format($cart->prices()['shipping']) ?>€</h1>
			</div>

			<?php if ($cart->prices()['code'] + $cart->prices()['promo']) {?>
				<div class="chck_item">
					<p class="chck_name">Sconto</p>
					<h1 id="chck_totShip" class="chck_pric"><?= format(-($cart->prices()['code'] + $cart->prices()['promo'])) ?>€</h1>
				</div>
			<?php }?>

			<?php if ($credit_used) {?>
				<div class="chck_item">
					<p class="chck_name" style="color: #ff0000;">Credito</p>
					<h1 id="chck_totShip" class="chck_pric" style="color: #ff0000;"><?= format(-$credit_used) ?>€</h1>
				</div>
			<?php }?>

			<div id="total" class="chck_item">
				<p class="chck_name">Totale</p>
				<h1 class="chck_pric"><?= format($cart->prices()['tot']) ?>€</h1>
			</div>

			<?php if ($active) {?>
				<div id="chck_btn_box">

					<button type="button" id="checkout" class="mbtn wid100" onClick="$('#submit').click();">Prosegui</button>

					<a href="<?= html_link('shop') ?>"><button type="button" class="sbtn txt-def wid100">Continua con gli acquisti</button></a>
					
				</div>
			<?php }?>
		</div>

	</section>

<?php }