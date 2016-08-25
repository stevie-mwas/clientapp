<?php

class DashboardController extends BaseController {
	/**
	 * =====================================================================================
	 * 	MANAGING PAGES BEYOND USER URL '/user/*'
	 *  Create orders page
	 **/
	public function showOrders(){
		Session::forget('orderitems');
		$client = DB::table('clients')
		                ->join('users','clients.user_id','=','users.id')
						->select('clients.id as id')
						->where('clients.user_id', Confide::user()->id)
						->first();

		$orders_list = DB::table('erporders')
						->select('*')
						->where('client_id', $client->id)
						->orderBy('erporders.id', 'desc')
						->get();

		return View::make('home.orders', compact('orders_list'));
	}

	// Create products page
	public function showProducts(){
		return View::make('home.products');
	}

	// Create invoices page
	public function showInvoices(){
		return View::make('home.invoices');
	}

	// Create statements page
	public function showStatements(){
		return View::make('home.statements');
	}

	// Create new order page
	public function showNewOrder(){
		$count = DB::table('erporders')->count();
		$order_number = date("Y/m/d/").str_pad($count+1, 4, "0", STR_PAD_LEFT);

		date_default_timezone_set('Africa/Nairobi');
		$order_date = date("Y-m-d");

		$client = DB::table('clients')
						->select('clients.id as id', 'clients.name')
						->where('user_id', Confide::user()->id)
						->first();

		$client_id = $client->id;
		$client_name = $client->name;

		$orderitems = Session::get('orderitems');

		$items = DB::table('items')->select('name', 'id')->get();
		
		if(count($orderitems) < 1){
			return View::make('home.neworder', compact('order_number', 'order_date', 'client_name', 'client_id', 'items'));	
		} else{
			return View::make('home.neworder', compact('order_number', 'order_date', 'client_name', 'client_id', 'items', 'orderitems'));
		}
		
	}

	// Add order to list
	public function setOrder(){
		$data = Input::all();

		//$itemID = array_get($data, 'item');
		$item = Item::findOrFail(array_get($data, 'item'));
		$item_qty = array_get($data, 'qty');
		$item_name = $item->name;
		$item_price = $item->selling_price;
		$item_id = $item->id;
		$order_type = 'purchases';

		Session::push('orderitems', [
				'item_id' => $item_id,
				'item_name' => $item_name,
				'item_price' => $item_price,
				'item_qty' => $item_qty,
				'order_type' => $order_type
			]);

		$orderitems = Session::get('orderitems');

		$count = DB::table('erporders')->count();
		$order_number = date("Y/m/d/").str_pad($count+1, 4, "0", STR_PAD_LEFT);

		date_default_timezone_set('Africa/Nairobi');
		$order_date = date("Y-m-d");

		$client = DB::table('clients')
						->select('clients.id as id', 'clients.name')
						->where('user_id', Confide::user()->id)
						->first();

		$client_id = $client->id;
		$client_name = $client->name;

		$items = DB::table('items')->select('name', 'id')->get();
		//dd($orders);
		return View::make('home.neworder', compact('order_number', 'order_date', 'client_name', 'client_id', 'items', 'orderitems'));
	}


	/**
	 * ==================================================================================
	 * SHOW SELECTED PRODUCTS FOR A PARTICULAR ORDER
	 * get order_id
	 */
	public function viewProducts($id){
		$products = DB::table('erporders')
							->join('erporderitems', 'erporders.id', '=', 'erporderitems.erporder_id')
							->join('items', 'items.id', '=', 'erporderitems.item_id')
							->select('erporderitems.id as item_id', 'name as item_name', 
									'quantity as item_qty', 'price as item_price')
							->where('erporders.id', $id)
							->get();

		$order = DB::table('erporders')
						->select('order_number', 'erporders.date as order_date')
						->where('erporders.id', $id)
						->first();

		$client = DB::table('clients')->select('name')
							->where('clients.user_id', Confide::user()->id)
							->first();

		$client_name = $client->name;
		
		return View::make('home.orders_view', compact('products', 'client_name', 'order'));
	}


	/**
	 * =================================================================================
	 * SAVE ORDERS TO DB
	 */
	public function saveOrder(){
		$erporders = Session::get('orderitems');
		$data = Input::all();

		if(!is_null($erporders)){
			foreach($erporders as $orders){
				$order_type = $orders['order_type'];
			}
			
			//dd($erporders);
			$order_number = array_get($data, 'order_number');
			$client_id = array_get($data, 'client_id');
			$order_date = array_get($data, 'order_date');
			$total = array_get($data, 'total');

			$lastID = DB::table('erporders')->insertGetId(array(
							'client_id'=>$client_id,
							'date'=>$order_date,
							'type'=>$order_type,
							'order_number'=>$order_number
						));

			
			foreach ($erporders as $orders) {
				$item_id = $orders['item_id'];
				$item_qty = $orders['item_qty'];
				$item_price = $orders['item_price'];

				DB::table('erporderitems')->insert(array(
					'item_id'=>$item_id,
					'quantity'=>$item_qty,
					'erporder_id'=>$lastID,
					'price'=>$item_price
				));
			}
			

			Session::forget('orderitems');
			/*$client = DB::table('clients')
			                ->join('users','clients.user_id','=','users.id')
							->select('clients.id as id')
							->where('clients.user_id', Confide::user()->id)
							->first();

			$orders_list = DB::table('erporders')
							->select('*')
							->where('client_id', $client->id)
							->get();

			Session::forget('erporders');*/

			return Redirect::action('DashboardController@viewProducts', array($lastID));
			//return Redirect::to('user/orders')->with('success_msg', 'Order successfully processed.');
			//return View::make('home.orders', compact('orders_list'));	

		} else{
			return Redirect::back()->with('err_msg','Please select items!');
		}
		
	}


	/**
	 * =================================================================================
	 * ORDER ITEMS EDITING AND DELETING, BEFORE & AFTER PLACING AN ORDER
	 * BEFORE PLACING AN ORDER
	 */
	public function editSessionItem($count){
		$editItem = Session::get('orderitems')[$count];
		return View::make('home.edit_session', compact('editItem'));
	}

	public function saveEdit($sesItemID){
		$quantity = Input::get('qty');
		//$price = (float) Input::get('price');
		//return $data['qty'].' - '.$data['price'];

		$ses = Session::get('orderitems');
		//unset($ses);
		$ses[$sesItemID]['item_qty']=$quantity;
		//$ses[$sesItemID]['item_price']=$price;
		Session::put('orderitems', $ses);

		$orderitems = Session::get('orderitems');
		$count = DB::table('erporders')->count();
		$order_number = date("Y/m/d/").str_pad($count+1, 4, "0", STR_PAD_LEFT);

		date_default_timezone_set('Africa/Nairobi');
		$order_date = date("Y-m-d");

		$client = DB::table('clients')
						->select('clients.id as id', 'clients.name')
						->where('user_id', Confide::user()->id)
						->first();

		$client_id = $client->id;
		$client_name = $client->name;

		$items = DB::table('items')->select('name', 'id')->get();
		
		return Redirect::action('DashboardController@showNewOrder');
		//return View::make('home.neworder', compact('order_number', 'order_date', 'client_name', 'client_id', 'items', 'orderitems'));
	}


	/**
	 * --------------------------------------
	 * DELETE ITEM BEFORE PROCESSING
	 */
	public function deleteSessionItem($count){
		$items = Session::get('orderitems');
		unset($items[$count]);
		$newItems = array_values($items);
		Session::put('orderitems', $newItems);

		$orderitems = Session::get('orderitems');

		$count = DB::table('erporders')->count();
		$order_number = date("Y/m/d/").str_pad($count+1, 4, "0", STR_PAD_LEFT);

		date_default_timezone_set('Africa/Nairobi');
		$order_date = date("Y-m-d");

		$client = DB::table('clients')
						->select('clients.id as id', 'clients.name')
						->where('user_id', Confide::user()->id)
						->first();

		$client_id = $client->id;
		$client_name = $client->name;

		$items = DB::table('items')->select('name', 'id')->get();
		//dd($orders);
		return Redirect::action('DashboardController@showNewOrder');
		//return View::make('home.neworder', compact('order_number', 'order_date', 'client_name', 'client_id', 'items', 'orderitems'));
	}
}
