<?php

function gen_original() {

	$res_item = select('items', 'userID=1', 'sales DESC, ID ASC');?>

	<div class="gallery padb4">
		<?php while ($row_item = $res_item->fetch_assoc()) {
			
			require(__ROOT__.'/system/functions/elements/items_data.php');?>

			<div class="item-box">
				<div>
					<a class="item-img" style="background-image: url(<?= item_url($itemID);?>);" href="shop/item?id=<?= $itemID;?>">
						<p class="des_prc prc_ora"><?= $price;?>€</p>
					</a>
				</div>

				<p class="item-type txt-upp"><?= $type_str;?></p>
				<p class="item-name txt-bold txt-1rem"><?= $name;?></p>
			</div>
		<?php }?>
	</div>
<?php }