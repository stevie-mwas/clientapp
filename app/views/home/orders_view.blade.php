@include('plugins.dash_header')

	<div class="container">
		<div class="row wrapper-menu">
			<div class="col-md-10 col-md-offset-1 col-sm-10 col-sm-offset-1 col-xs-10 col-xs-offset-1 row-wrapper">
				<h3 class="dash">Products for:</h3>
			</div>

			<div class="col-md-10 col-md-offset-1 col-sm-10 col-sm-offset-1 col-xs-10 col-xs-offset-1 row-wrapper">
				<p class="dash">
					Order #: {{$order->order_number}}&nbsp;|&nbsp;
					Client: {{$client_name}}&nbsp;|&nbsp;
					Order Date: {{$order->order_date}}
				</p>
			</div>
				
			<div class="col-md-10 col-md-offset-1 col-sm-10 col-sm-offset-1 col-xs-10 col-xs-offset-1 form-wrapper table-responsive">
				<table class="table table-bordered table-hover table-sm">
					<thead>
						<tr>	
							<th>#</th>
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
							$count=1;

							function asMoney($value) {
								return number_format($value, 2);
							}
						?>
						@if(isset($products) && count($products) > 0)
						@foreach($products as $product)
							<?php
								$amount = $product->item_price * $product->item_qty;
								$total += $amount;
							?>
							<tr>
								<td><strong>{{$count}}</strong></td>
								<td>{{$product->item_name}}</td>
								<td>{{$product->item_qty}}</td>
								<td>{{$product->item_price}}</td>
								<td>{{asMoney($amount)}}</td>
								<td><center>
									<a href="{{{ URL::to('user/orders/item/'.$product->item_id) }}}">
										<img src="../../img/edit.png" alt="EDIT">
									</a>&emsp;&emsp;
									<a href="{{{ URL::to('user/orders/item/'.$product->item_id) }}}" onclick="return (confirm('Are you sure you want to delete this product?'))">
										<img src="../../img/delete.png" alt="DELETE">
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
						
				<div class="form-group pull-right">
					<a href="{{ URL::to('/user/orders') }}" class="btn btn-primary btn-sm pull-right">Submit Paymet</a>
					<a href="{{ URL::to('/user/orders') }}" class="btn btn-success btn-sm pull-right" style="margin-right:20px;">Back</a>
				</div>
			</div>
		</div>
	</div>

@include('plugins.footer')