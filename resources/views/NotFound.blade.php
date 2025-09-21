@include('include.style')

<div class="ast_error_wrapper ast_toppadder100 ast_bottompadder100">
	<div class="container">
		<div class="row">
			<div class="col-lg-12 col-md-12 col-sm-12 col-12">
				<div class="ast_error_info">
					<img src="..\themeAssets\images\img\error.png" alt=" 404 Error">
					<h1>page not found</h1>
					<p>sorry. we can't seem to find the page you're looking for</p>
					<div class="clearfix"></div>
					<a href="{{ route('homePage') }}" class="ast_btn">back to home</a>
				</div>
			</div>
		</div>
	</div>
</div>
