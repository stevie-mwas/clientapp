@include('plugins.dash_header')

	<div class="container">
		<div class="row wrapper-menu">
			<div class="col-md-10 col-md-offset-1 col-sm-10 col-sm-offset-1 col-xs-10 col-xs-offset-1 row-wrapper">
				<h3 class="dash">Existing Orders</h3>
			</div>
			<div class="col-md-10 col-md-offset-1 col-sm-10 col-sm-offset-1 col-xs-10 col-xs-offset-1 row-wrapper">
				<a href="{{ URL::to('/user/new-order') }}" class="btn btn-primary btn-sm">New Order</a>
			</div>
			
			<div class="col-md-10 col-md-offset-1 col-sm-10 col-sm-offset-1 col-xs-10 col-xs-offset-1 row-wrapper">
				<?php 
					$message = Session::get('success_msg');
					Session::forget('success_msg');
				?>
				@if(isset($message))
					<div class="alert alert-success fade in" style="font-size: 15px;">
					    <a href="#" class="close" data-dismiss="alert">&times;</a>
					    <strong>Success!</strong> {{$message}}
					</div>
				@endif
			</div>

			<!-- ORDERS TABLE -->
			<div class="col-md-10 col-md-offset-1 col-sm-10 col-sm-offset-1 col-xs-10 col-xs-offset-1 form-wrapper table-responsive">
				<table class="table table-bordered table-hover table-sm">
					<thead>
						<tr>
							<th>#</th>
							<th>Order #</th>
							<th>Date</th>
							<th>Status</th>
							<th>Action</th>
						</tr>
					</thead>
					<tbody>
						<?php $count=1?>
						@if(isset($orders_list) && count($orders_list))
						@foreach($orders_list as $order)
							<tr>
								<td><strong>{{$count}}</strong></td>
								<td>{{$order->order_number}}</td>
								<td>{{$order->date}}</td>
								<td>{{$order->status}}</td>
								<td>
									<!--<a href="{{{ URL::to('user/orders/'.$order->id) }}}" class="btn btn-info btn-sm">View</a>-->
									<div class="btn-group">
										<button type="button" class="btn btn-info btn-sm dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
						                    Action <span class="caret"></span>
						                </button>
						                <ul class="dropdown-menu" role="menu">
						                    <li><a href="{{{ URL::to('user/orders/'.$order->id) }}}">View</a></li>
						                    <!--<li><a href="{{{ URL::to('user/orders') }}}">Pay</a></li>-->
						                    <!--<li><a href="{{{ URL::to('user/orders') }}}" onclick="return (confirm('Are you sure you want to cancel this order?'))">Cancel</a></li>-->
						                </ul>
									</div>
								</td>
							</tr>
						<?php $count++ ?>
						@endforeach
						@endif
					</tbody>
				</table>
			</div>
			
		</div>
	</div>

@include('plugins.footer')