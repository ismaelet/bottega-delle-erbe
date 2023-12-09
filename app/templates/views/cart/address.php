<div id="content" class="grid al-top wrap">

	<form id="panel1" class="panel" method="POST">

		<!-- Shipping title -->
		<section class="marb2">

			<h1 class="section-title">SPEDIZIONE</h1>

			<p>
				Le spedizioni sono <strong>gratuite</strong> per ordini superiori a <strong>150,00 €</strong>.<br><br>
				Qui sotto puoi verificare la data di consegna prevista e il tipo di spedizione che verrà usato:
			</p>

		</section>

		<!-- Country -->
		<?php if ($cart_config['ship_abroad']) { ?>

			<section id="countries" class="section">

				<select id="count_sel" name="countID" class="sel" onChange="if ($(this).val() !== '0') { $('#country').click(); }">

					<option value="0" <?= $cart->country ? '' : 'selected' ?>>Seleziona:</option>

					<?php while ($country = $countries->fetch_assoc()) { ?>

						<option value="<?= $country['id'] ?>" <?= $cart->country['id'] == $country['id'] ? 'selected' : '' ?>>
							<?= $country['name_it']?>
						</option>

					<?php }?>

				</select>

				<button type="submit" id="country" name="country" class="hide" formnovalidate></button>

			</section>

		<?php } ?>

		<!-- Shipping method -->
		<section id="methods" class="section">

			<?php foreach ($methods as $key => $method) { ?>

				<label class="row">

					<!-- Checkbox -->
					<div class="ship_chck_box">

						<input type="checkbox" class="inp_cbx ship_cbx" name="method[]" value="<?= $method['id'] ?>" <?= $method['checked'] ? 'checked' : ''?>>

						<div class="cbx-icon big">
							<div class="cbx-icon-dot"></div>
						</div>

					</div>

					<!-- Title and description -->
					<div>

						<!-- Title -->
						<h1 class="txt-11rem txt-bold"><?= $method['name'];?></h1>

						<!-- Delivery date -->
						<p class="txt-09rem"><?= $method['date'][0].' - '. $method['date'][1] ?></p>

						<!-- Description -->
						<p class="mart10px"><?= $method['text'] ?></p>

						<!-- Price -->
						<h1 class="txt-13rem mart1"><?= $method['price'] ?> €</h1>

					</div>
				</label>
			<?php }?>

		</section>

		<!-- Shipping address -->
		<section id="address" class="section">

			<h1 class="section-title">Indirizzo</h1>

			<input type="text" class="inp" name="name" placeholder="Nominativo di spedizione" value="<?= $address['name'] ?? '' ?>" maxlength="50" required>

			<input type="text" id="inp_addr" class="inp" name="street" placeholder="Indirizzo" value="<?= $address['street'] ?? '' ?>" maxlength="30" required autocomplete="address-line1">

			<?php if ($cart_config['addr_num']) { ?>
				<input type="text" id="inp_num" class="inp" name="number" placeholder="Numero civico" value="<?= $address['number'] ?? '' ?>" maxlength="10" required>
			<?php } ?>

			<input type="text" class="inp" name="city" placeholder="Città" value="<?= $address['city'] ?? '' ?>"  maxlength="30" required autocomplete="address-level2">

			<input type="text" class="inp shr" name="zip" placeholder="Codice postale" value="<?= $address['zip'] ?? '' ?>" maxlength="5" required autocomplete="postal-code">

			<input type="text" class="inp shr" name="region" placeholder="Provincia" value="<?= $address['region'] ?? '' ?>" maxlength="2" required autocomplete="address-level1">

			<input type="email" class="inp" name="mail" placeholder="Email" value="<?= $address['mail'] ?? '' ?>"  maxlength="50" required autocomplete="email">

			<input type="text" class="inp" name="phone" placeholder="Numero di telefono" value="<?= $address['phone'] ?? '' ?>" maxlength="30"required autocomplete="tel">

			<button type="submit" id="submit" name="submit" class="hide"></button>

		</section>
	</form>

	<div id="panel2" class="panel">
		
		<!-- Items -->
		<?= cart_items($cart, true) ?>
		
		<!-- Discount code -->
		<?php if ($cart_config['discount_code']) { ?>

			<section id="code" class="wrap marb1">

				<h1 class="section-title">CODICE SCONTO</h1>
				
				<div id="code-anch" class="anchor"></div>

				<form id="code_cont" method="POST" action="#code-anch">

					<?php if (empty($cart->code)) {?>

						<input type="text" id="code-inp" name="code" class="inp wide" placeholder="Codice sconto (opzionale)" onFocus="$('.err').hide()">
						<?php if ($error == 'code_bad') {?><p class="inp err">Il codice inserito non esiste</p><?php }?>
						<?php if ($error == 'code_exp') {?><p class="inp err">Il codice inserito è scaduto</p><?php }?>
						<?php if ($error == 'code_ear') {?><p class="inp err">Il codice inserito non è attivo</p><?php }?>
						<button type="submit" id="add_code" name="add_code" class="mbtn">Aggiungi</button>

					<?php } else {?>

						<p class="code_txt">
							Codice usato: <span class="code txt-c1"><?= $cart->code;?> (-<?= format($cart->tot['code']).'€'; if ($cart->shipID == 1) echo ' e spedizioni gratuite'?>)</span>
						</p>
						<button type="submit" name="del_code" id="code_remove">Rimuovi</button>

					<?php }?>
				</form>
				
			</section>

		<?php } ?>
		
		<!-- Recap -->
		<?= cart_recap($cart, true) ?>
		
	</div>
</div>