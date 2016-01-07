<section id="login">
	<div class="container">
		<div class="">
			<form role="form" action="?page=login&action=dologin" method="post">
			  <div class="row">@ERROR@</div>
			  <div class="form-group">
			    <label for="inputName">User Name</label>
			    <input type="text" name="user" class="form-control" id="inputName" placeholder="User Name" value="@USER@">
			  </div>
			  <div class="form-group">
			    <label for="password">Password</label>
			    <input type="password" name="pass" class="form-control" id="password" placeholder="Password" value="">
			  </div>
			  <button type="submit" name="login" class="btn btn-primary">Submit</button>
			</form>
		</div>
	</div>
</section>