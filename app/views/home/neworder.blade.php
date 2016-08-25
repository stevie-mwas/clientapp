@include('plugins.dash_header')

	<div class="container">
		<div class="row wrapper-menu">
			<div class="col-md-10 col-md-offset-1 col-sm-10 col-sm-offset-1 col-xs-10 col-xs-offset-1 row-wrapper">
				<h3 class="dash">New Order</h3>
				<p class="dash">
					Order #: {{$order_number}}&nbsp;|&nbsp;
					Client: {{$client_name}}&nbsp;|&nbsp;
					Order Date: {{$order_date}}
				</p>
			</div>
			<div class="col-md-10 col-md-offset-1 col-sm-10 col-sm-offset-1 col-xs-10 col-xs-offset-1 form-wrapper">
				<form role="form" method="POST" action="{{{ URL::to('user/new-order') }}}">
					<h3 class="dash">Select Items</h3>
					<div class="form-group">
						<label class="">Item: </label>
						<select name="item" class="form-control" required>
							<option value="">--select an item--</option>
							@foreach($items as $item)
								<option value="{{$item->id}}">{{$item->name}}</option>
							@endforeach
						</select>
					</div>
					<div class="form-group">
						<label class="">Quantity: </label>
						<input class="form-control" type="text" name="qty" placeholder="Quantity" required>
					</div>
					<div class="form-group text-right">
						<input class="btn btn-success btn-sm" type="submit" name="btn-add_item" value="Add Item">
					</div>
				</form>

				<?php 
					$message = Session::get('err_msg');
					Session::forget('err_msg');
				?>
				@if(isset($message))
					<div class="alert alert-danger fade in" style="font-size: 15px;">
					    <a href="#" class="close" data-dismiss="alert">&times;</a>
					    <strong>Warning!</strong> {{$message}}
					</div>
				@endif
				
				<div class="form-group table-responsive">
					<form role="form" method="POST" action="{{{ URL::to('user/new-order/commit') }}}">
						<h3 class="dash">Selected Items</h3>
						<table class="table table-bordered table-hover table-sm">
							<thead>
								<tr>
									<th><strong>#</strong></th>
									<th>Item</th>
									<th>Qty</th>
									<th>Price</th>
									<th>Total</th>
									<th>Action</th>
								</tr>
							</thead>
							<tbody>
								<?php 
									$total=0; 
									$count=0;

									function asMoney($value) {
										return number_format($value, 2);
									}
								?>
								@if(isset($orderitems) && count($orderitems) > 0)
								@foreach($orderitems as $orderitem)
									<?php
										$amount = $orderitem['item_price'] * $orderitem['item_qty'];
										$total += $amount;
									?>
									<tr>
										<td><strong>{{$count}}</strong></td>
										<td>{{$orderitem['item_name']}}</td>
										<td>{{$orderitem['item_qty']}}</td>
										<td>{{$orderitem['item_price']}}</td>
										<td>{{asMoney($amount)}}</td>
										<td><center>
											<a href="{{{ URL::to('user/orders/edit/'.$count) }}}">
												<img src="../../../img/edit.png" alt="EDIT">
											</a>&emsp;&emsp;
											<a href="{{{ URL::to('user/orders/delete/'.$count) }}}">
												<img src="../../../img/delete.png" alt="DELETE">
											</a></center>
										</td>
									</tr>
								<?php $count++?>
								@endforeach
								@endif
								
								<tr>
									<td></td>
									<td></td>
									<td></td>
									<td><strong>Grand Total</strong></td>
									<td><strong>{{asMoney($total)}}</strong></td>
									<td></td>
								</tr>
							</tbody>
						</table>
						<input type="hidden" name="order_number" value="{{$order_number}}">
						<input type="hidden" name="client_id" value="{{$client_id}}">
						<input type="hidden" name="order_date" value="{{$order_date}}">
						<input type="hidden" name="total" value="{{$total}}">
						
						<a href="{{ URL::to('/user/orders') }}" class="btn btn-danger btn-sm">Cancel</a>
						<div class="form-group pull-right">
							<input class="btn btn-primary btn-sm" type="submit" name="btn-commit" value="Place Order">
						</div>
					</form>
				</div>
				
			</div>
		</div>
	</div>

@include('plugins.footer')