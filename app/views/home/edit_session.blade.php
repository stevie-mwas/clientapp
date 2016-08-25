@include('plugins.dash_header')

	<div class="container">
		<div class="row wrapper-menu">
			<div class="col-md-10 col-md-offset-1 col-sm-10 col-sm-offset-1 col-xs-10 col-xs-offset-1 row-wrapper">
				<p class="dash">
					Edit item Quantity for:<br>
					Item Name: {{$editItem['item_name']}}
				</p>
			</div>
			<div class="col-md-10 col-md-offset-1 col-sm-10 col-sm-offset-1 col-xs-10 col-xs-offset-1 row-wrapper">
				<form role="form" action="" method="POST" class="col-md-6 col-md-offset-3">
					<div class="form-group">
						<label>Item Quantity</label>
						<input class="form-control" type="text" name="qty" value="{{$editItem['item_qty']}}" placeholder="">
					</div>
					<div class="form-group text-right">
						<input class="btn btn-primary btn-sm" type="submit" name="editBtn" value="Save">
					</div>
				</form>
			</div>
		</div>
	</div>

@include('plugins.footer')