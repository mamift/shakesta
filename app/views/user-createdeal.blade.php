@extends('layout')

@section('content')
<h2>Create Your Deal</h2>

<div class="wrapper wrapper-style4">
<article id="contact">
	<div class="5grid">
		<div class="row">
			<div class="12u">
				<form method="post" action="mailto:mesbah.jamali@gmail.com">
					<div class="5grid">
						<div class="row">
							<div class="6u">
								<input type="text" name="name" id="name" placeholder="Retailer Name" />
							</div>
							<div class="6u">
								<input type="text" name="email" id="email" placeholder="Ad title" />
							</div>
							<div class="6u">
								<input type="text" name="email" id="email" placeholder="Saving" />
							</div>
							<div class="6u">
								<input type="text" name="email" id="email" placeholder="Price" />
							</div>
						</div>
						
						<div class="row">
							<div class="12u">
								<textarea name="message" id="message" placeholder="Product Description"></textarea>
							</div>
						</div>
						
						<div class="row">
							<div class="12u">														
								 <input style="margin-top:30px" type="file" class="button" />
							</div>
						</div>	
	
						<br>
						<h2>Category</h2>
							<input type="checkbox" name="fashion" value="fashion" />Fashion<br>
							<input type="checkbox" name="travel" value="travel" />Travel<br>
							<input type="checkbox" name="homeware" value="homeware" />Homeware<br>
							<input type="checkbox" name="cosmetics" value="cosmetics">Cosmetics<br>
							<input type="checkbox" name="kids" value="kids">Kids<br>
						</div>
					
						<br>
						<h3>Preview</h3>
						<img src="../images/example.png" width="242px" height="479px" />
						<div class="row">
							<div class="12u">
								<input type="submit" class="button" value="Submit ad" />
								<input type="reset" class="button button-alt" value="Clear Form" />
							</div>
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>		
@stop