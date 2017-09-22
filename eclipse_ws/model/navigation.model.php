<?php

class navigation_model extends model
{
	protected function init($params)
	{
		
	}
	
	protected function createContent()
	{	
		$active_user	= $this->session_single->getActiveUser();
		
		?>
		<header class="app-header navbar">
			<button class="navbar-toggler mobile-sidebar-toggler d-lg-none" type="button">&#9776;</button>
			<a class="navbar-brand" href="login"></a>
			<ul class="nav navbar-nav d-md-down-none">

				
				<li class="nav-item px-3">
					<a class="nav-link" href="dashboard">Dashboard</a>
				</li>
				
			</ul>
			
			<ul class="nav navbar-nav ml-auto">
				
				<?php if($this->session_single->isLoggedIn()){ ?>
				
				<!-- User Dropdown -->
				<!-- Icons from Font-Awesome: http://fontawesome.io/icons/ -->
				<li class="nav-item dropdown">
					<a class="nav-link dropdown-toggle nav-link" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">
						<span class="d-md-down-none"><?php echo $active_user->getName(); ?> </span>
					</a>
					<div class="dropdown-menu dropdown-menu-right">
						<a class="dropdown-item" href="user_profile"><i class="fa fa-wrench"></i> Meine Daten</a>
						<a class="dropdown-item" onclick='return logout();' href="welcome"><i class="fa fa-lock"></i> Logout</a>
					</div>
				</li>
				<?php }else{ ?>	
				
				<!-- Login Button -->
				<li class="nav-item px-3">
					<a class="nav-link"  onclick="openLogin('dashboard'); return false;" href="javascript: void(0);">Login</a>
				</li>
				<?php }	?>
			</ul>
		</header>
		<?php
	}
}
?>
