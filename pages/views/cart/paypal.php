{% block main %}

<form id="form" class="hide" action="https://www.paypal.com/cgi-bin/webscr" method="POST">

	<!--PAYPAL DATA-->
	<input type="hidden" name="cmd" value="_cart">
	<input type="hidden" name="business" value="<?= $cart_config['pp_address'] ?>">
	<input type="hidden" name="upload" value="1">
	<input type="hidden" name="lc" value="it_IT">
	<input type="hidden" name="currency_code" value="EUR">

	<?php if ($cart_config['pp_return']) { ?>
		<input type="hidden" name="return" value="<?= $cart_config['pp_return'] . '?id=' . $cart->id ?>">
	<?php } ?>

	<!-- Articles -->
	<?php $i = 0;
	while ($row = $orders->fetch_assoc()) {
		$i++;

		$order = new Order($row['id'], '*');

	?>

		<input type="hidden" name="item_name_<?= $i ?>" value="<?= $order->text[0] ?>">
		<input type="hidden" name="amount_<?= $i ?>" value="<?= $order->price ?>">
		<input type="hidden" name="quantity_<?= $i ?>" value="<?= $order->quantity ?>">
		<input type="hidden" name="item_number_<?= $i ?>" value="<?= $order->item->id ?>">

	<?php } ?>

	<!-- Discount -->
	<?php if ($cart->prices()['discount']) { ?>
		<input type="hidden" name="discount_amount_cart" value="<?= $cart->prices()['discount'] ?>">
	<?php } ?>

	<!-- Shipping data -->
	<input type="hidden" name="shipping_1" value="<?= $cart->prices()['shipping'] ?>">
	<input type="hidden" name="first_name" value="<?= empty($address['firstname']) ? explode(' ', $address['name'])[0] : $address['firstname'] ?>">
	<input type="hidden" name="last_name" value="<?= empty($address['lastname']) ? explode(' ', $address['name'])[1] : $address['lastname'] ?>">
	<input type="hidden" name="address1" value="<?= $address['street'] ?> <?= empty($address['number']) ? '' : ', ' . $address['number'] ?>">
	<input type="hidden" name="city" value="<?= $address['city'] ?>">
	<input type="hidden" name="state" value="<?= $address['region'] ?>">
	<input type="hidden" name="zip" value="<?= $address['zip'] ?>">
	<input type="hidden" name="lc" value="IT">
	<input type="hidden" name="country" value="IT">
	<input type="hidden" name="email" value="<?= $address['mail'] ?>">
	<input type="hidden" name="night_phone_a" value="<?= $address['phone'] ?>">

	<!-- Custom data -->
	<input type="hidden" name="custom" value="<?= $cart->id . '&custom&it' ?>">
</form>

<div class="load-icon cen big"></div>

<script>
	document.getElementById('form').submit();
</script>

{% end main %}