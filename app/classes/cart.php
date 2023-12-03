<?php 

class Cart {

	public $id;
	public $buyerID;

	public $shippingID;
	public $countryID;
	public $paymentID;

	public $quantity;
	public $code;
	public $prices;
	public $tot;

	public $step;
	public $status;
	public $time;

	function __construct($id) {

		//set id
		$this->id = $id;

		//get data
		if ($row = DB::row('* FROM ecommerce_carts WHERE id=?', [$id])) {

			//set basic data
			$this->buyerID = $row['buyerID'];
			$this->shippingID = $row['shippingID'];
			$this->countryID = $row['countryID'];
			$this->paymentID = $row['paymentID'];
			$this->quantity = $row['quantity'];
			$this->code = $row['code'];
			$this->tot = $row['tot'];
			$this->step = $row['step'];
			$this->status = $row['status'];
			$this->time = $row['time'];

		}
	}

	public function prices() {

		if (!isset($this->prices)) {
		
			$prices['items'] = DB::sum('price*quantity FROM ecommerce_orders WHERE cartID=?', [$this->id]);
			$prices['shipping'] = ship_price($this->shippingID, $this->quantity, $this->id);
			$prices['code'] = DB::sum('discount FROM ecommerce_orders WHERE cartID=?', [$this->id]);
			$prices['promo'] = 0;
			$prices['discount'] = $prices['code'] + $prices['promo'];

			$prices['tot'] = round($prices['items'] + $prices['shipping'] - $prices['code'] - $prices['promo'], 2);

			$this->prices = $prices;

		}

		return $this->prices;

	}

	static function add($data) {

		global $user;

		//get data
		$quantity = $data['quantity'] ?? 1;

		//create guest account
		if (guest() && !$user->id) guest_login();
		
		//create cart
		$cartId = DB::find('id FROM ecommerce_carts WHERE buyerID=? AND status=0', [$user->id]);
		
		if ($cartId) DB::update('ecommerce_carts SET quantity=quantity+?, tot=tot+? WHERE id=?', [$quantity, $data['price'] * $quantity, $cartId]);
		else $cartId = DB::add('ecommerce_carts (buyerID, quantity, tot) VALUES (?, ?, ?)', [$user->id, $quantity, $data['price'] * $quantity]);

		//add order
		DB::add(
			'ecommerce_orders (buyerID, cartID, itemID, price, quantity) VALUES (?, ?, ?, ?, ?)',
			[$user->id, $cartId, $data['itemId'], $data['price'], $quantity]
		);
		
		redirect('cart');

	}

}