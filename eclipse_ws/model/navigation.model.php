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
		
				
				<?php if($this->session_single->isLoggedIn()){ ?>
				
				<header>
        <!-- Navbar -->
        <div class="w3-top">
            <ul class="w3-navbar w3-blue w3-card-2 w3-left-align">
                <li class="" style="height:46.5px"><a href="dashboard.html" class="w3-hover-white w3-center w3-padding-12"><i class="fa fa-tachometer fa-lg" ></i> Dashboard</a></li>
                <li class=" w3-right w3-padding-large w3-hover-white" style="cursor: pointer;">

                    <a class="w3-hover-white" href="settings.html" style="padding: 0px;">

                        <i class="fa fa-cog fa-lg" aria-hidden="true"></i> <span href="settings.html" class="w3-hide-small">Einstellungen</span>

                    </a>

                    </li>




                <div class="w3-dropdown-hover w3-right">
                    <div class="w3-button w3-padding-large w3-hover-white" style="height:46px"><img src="pics/deutschland-fahne-001-rechteckig-200x333-flaggenbilder.de.gif" alt="" class="w3-hover-opacity" style="height:100%"></div>
                    <div class="w3-dropdown-content w3-blue" style="width:50px">
                        <a href="#" class="w3-bar-item w3-button" style="width:75px"><img src="pics/frankreich-fahne-002-rechteckig-schwarz-200x300-flaggenbilder.de.gif" alt="" class="w3-hover-opacity" style="width:100%"></a>
                        <a href="#" class="w3-bar-item w3-button" style="width:75px"><img src="pics/italien-fahne-001-rechteckig-200x300-flaggenbilder.de.gif" alt="" class="w3-hover-opacity" style="width:100%"></a>
                        <a href="#" class="w3-bar-item w3-button" style="width:75px"><img src="pics/vereinigtes_koenigreich-fahne-003-rechteckig-weiss-200x400-flaggenbilder.de.gif" alt="" class="w3-hover-opacity" style="width:100%"></a>
                    </div>
                </div>
            </ul>
        </div>
    </header>
    
    
    
				<?php }else{ ?>	
				
				<!-- Login Button -->
				
				<?php }	?>
			
		<?php
	}
}
?>
