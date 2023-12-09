{% block main %}

<!-- Slider -->
<div id="slider" class="grid">

	<div id="bgr" class="bgr" <?= background_image('bgr.jpg', $view) ?>></div>

		<h1 id="title">Contatti</h1>

	</div>

</div>

<!-- Content -->
<div id="content">

	<div class="content-wrap">

		<div id="grid" class="grid2 grid-pad3 al-top">
			
			<!-- Contacts data -->
			<section id="data" class="grid-cell">

				<h1 class="stitle txt-3rem marb2">La Bottega<br>delle Erbe</h1>

				<p class="txt-1rem txt-c3-h"><a href="<?= sysData('cont-mail-link') ?>"><?= sysData('cont-mail') ?></a></p>

				<div class="socials mart2 flex">
					<a class="social icon-box fill-5 fill-c3-h" href="<?= sysData('cont-tel-link') ?>">
						<?= icon_embed('contacts/call') ?>
					</a>
					<a class="social icon-box fill-5 fill-c3-h" href="<?= sysData('cont-mail-link') ?>">
						<?= icon_embed('contacts/mail') ?>
					</a>
					<a class="social icon-box fill-5 fill-c3-h" href="<?= sysData('cont-fb-link') ?>">
						<?= icon_embed('contacts/facebook') ?>
					</a>
					<a class="social icon-box fill-5 fill-c3-h" href="<?= sysData('cont-inst-link') ?>">
						<?= icon_embed('contacts/instagram') ?>
					</a>
				</div>

				<div class="brt1 br-9 marv2"></div>
				
				<h1 class="txt-2rem marb2">Dove trovarci</h1>
				<p class="data-txt txt-1rem"><?= sysData('cont-address') ?></p>
				
				<iframe id="map" class="mart1" src="https://www.google.com/maps/embed?pb=!1m14!1m8!1m3!1d11023.755404324244!2d11.602886!3d46.3110519!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0%3A0xbf13f6e1de855131!2sLa%20Bottega%20delle%20Erbe%20-%20Toelettatura%20per%20Piccoli%20Amici!5e0!3m2!1sen!2sbr!4v1627507038655!5m2!1sen!2sbr" width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy"></iframe>

			</section>
			
			<!-- Contact form -->
			<section id="form" class="grid-cell">

				<form method="POST" autocomplete="off">
					
					<div id="form-anch" class="anchor"></div>

					<h1 class="stitle txt-3rem txt-cen">Scrivici</h1>

					<?php if ($sent) { ?>
						<p class="inp ok">Messaggio inviato ti risponderemo il prima possibile</p>
					<?php } ?>

					<?php if ($error == 'mail_bad') { ?>
						<p class="inp err">Errore: l'indirizzo email non è stato riconosciuto. Puoi scrivere direttamente a <a href="<?= sysData('cont-mail-link') ?>" class="txt-bold"><?= sysData('cont-mail') ?></a>, invece di usare questo modulo.</p>
					<?php } ?>

					<?php if ($error == 'word_bad') {?>
						<p class="inp err">Errore: il messaggio non ha superato i nostri filtri anti-spam. Puoi scrivere direttamente a <a href="<?= sysData('cont-mail-link') ?>" class="txt-bold"><?= sysData('cont-mail') ?></a>, invece di usare questo modulo.</p>
					<?php }?>

					<div class="form-lbl-box">
						<p class="form-lbl">Nome e cognome</p>
					</div>
					<input type="text" name="name" class="form-inp" onfocus="$(this).prev().addClass('focus')" onblur="if (!$(this).val().length) {$(this).prev().removeClass('focus')}" required>

					<div class="form-lbl-box">
						<p class="form-lbl">Indirizzo e-mail</p>
					</div>
					<input type="email" name="mail" class="form-inp" onfocus="$(this).prev().addClass('focus')" onblur="if (!$(this).val().length) {$(this).prev().removeClass('focus')}" required>

					<div class="form-lbl-box">
						<p class="form-lbl">Messaggio</p>
					</div>
					<textarea name="text" class="form-textarea" maxlength="500" onfocus="$(this).prev().addClass('focus')" onblur="if (!$(this).val().length) {$(this).prev().removeClass('focus')}" required></textarea>
					
					<div class="txt-rig mart2">
						<button type="submit" id="submit" name="submit" class="mbtn mob-full">Invia</button>
					</div>
				</form>
			</section>

		</div>
	</div>
</div>

{% end main %}