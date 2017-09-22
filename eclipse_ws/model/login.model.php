<?php

class login_model extends model
{

protected function init($params)
	{
// 		$this->setTitle($this->dict_single->dict('login'));

		if($_POST && isset($_POST['dc_nr'])	&& isset($_POST['password']))
		{
			// pw reset?

			if(!$_POST['dc_nr'] || $_POST['password']){

				$user_obj = new damage_case(0);
				$status = $user_obj->login($_POST['dc_nr'], $_POST['password']);

				if($status == 1){
					die('<script type="text/javascript">window.location = "dashboard";</script>');
				}
			}

			die('Ihre Eingaben waren fehlerhaft. Bitte versuchen Sie es erneut.');
		}
	}

	protected function createContent()
	{
		?>
		<!--<div class="card-group mb-0">
			<div class="card p-4">
				<div class="card-block">
					<form id='login_form' action='dashboard' method='post' onsubmit='return checkLogin();'>
						<h1>Login</h1>
						<div class="input-group mb-3">
							<span class="input-group-addon"><i class="icon-user"></i>
							</span>
							<input type="text" name="dc_nr" class="form-control" id="login_email" placeholder="Schadensfall-Nr">
						</div>
						<div class="input-group mb-4">
								<span class="input-group-addon"><i class="icon-lock"></i>
								</span>
							<input type="password" name="password" class="form-control" placeholder="Passwort">
						</div>
						<div class="row">
							<div class="col-6">
								<button name="submit" value="login" type="submit" class="btn btn-primary px-4">Login</button>
							</div>
							<div class="col-6 text-right">
								<button type="button" class="btn btn-link px-0">Passwort vergessen</button>
							</div>
						</div>
						<div class="row">
							<div class="col-md-12">
								<span id="login_response"></span>
							</div>
						</div>
					</form>
				</div>
			</div>
		</div>-->
    <div class="w3-card-4" style="max-width:600px">
      <form class="w3-container" id='login_form' action='dashboard' method='post' onsubmit='return checkLogin();'>
        <div class="w3-section">
          <label><b>Schadensfall-Nr</b></label>
          <input class="w3-input w3-border w3-margin-bottom form-control" id="login_email" type="text" placeholder="Nr." name="dc_nr" required>
          <label><b>Passwort</b></label>
          <input class="w3-input w3-border form-control" type="password" placeholder="Passwort" name="password" required>
          <button name="submit" value="login" class="w3-button w3-block w3-green w3-section w3-padding" type="submit">Login</button>
          <input class="w3-check w3-margin-top" type="checkbox" checked="checked"> Erinnere mich
        </div>
      </form>

      <div class="w3-container w3-border-top w3-padding-16 w3-light-grey">
        <button type="button" class="w3-button w3-red">Cancel</button>
      </div>

    </div>
		<?php

	}


}
?>
