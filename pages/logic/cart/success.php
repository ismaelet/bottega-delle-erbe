<?php

//get id
$id = $_GET['id'] ?? false;

//fetch cart data
$cart = DB::row('carts WHERE id=?', [$id]);

//redirect if the cart doesn't exist
if (!$cart) redirect('shop');

//redirect if the payment has been processed
if ($cart['status']) redirect('order?id='.$id);