<?php

function input_search($config) {?>

	<div class="ajax-search" data-url="<?= $config['url'];?>" data-filter="<?= $config['filter'] ?? '';?>" data-root="<?= __HROOT__ ?>">
						
		<input type="hidden" class="ajax-search-id" name="<?= $config['name'] ?>" value="<?= $config['value_id'] ?>" <?php if (isset($config['required'])) echo 'required';?>>

		<input type="text" class="inp ajax-search-txt" name="<?= $config['name_show'] ?>" value="<?= $config['value_show'] ?>" placeholder="<?= $config['pholder'] ?>" <?php if (isset($config['required_show'])) echo 'required' ?> autocomplete="off">

		<div class="ajax-search-ddown">
			<div class="ajax-search-box"></div>
		</div>
	</div>

<?php }