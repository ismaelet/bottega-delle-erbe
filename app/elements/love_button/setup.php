<?php

function element_love_button($id, $loved) {

	if (logged()) {?>

		<div class="love-btn working <?php if ($loved) echo 'active';?>" data-id="<?= $id;?>" data-loved="<?= $loved;?>">

			<div class="love-icon"></div>

		</div>

	<?php } else {?>

		<a  class="love-btn" href="/login?url=<?= $_SERVER['REQUEST_URI'];?>">

			<div class="love-icon"></div>

		</a>

<?php }}?>