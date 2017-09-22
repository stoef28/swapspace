<?php 

abstract class model
{
	protected $title = '';
	protected $title_class = 'page_title';
	protected $back = array('target' => '');
	protected $show_title = true;
	protected $has_content_wraper = true;
	protected $has_cards = false;
	
	protected $pdo_single;
	protected $session_single;
	protected $function_single;
// 	protected $dict_single;
	protected $constant_single;
	
	public function __construct($params)
	{
		$this->pdo_single 		= pdo_singleton::getInstance();
		$this->session_single 	= session_singleton::getInstance();
		$this->function_single 	= function_singleton::getInstance();
// 		$this->dict_single 		= dict_singleton::getInstance();
		$this->constant_single 	= constant_singleton::getInstance();
		
		$this->init($params);
	}
	
	abstract protected function init($params);
	
	abstract protected function createContent();
	
	public function createPage()
	{	
		// only execute init. no content displayed
		if($this->session_single->isAjaxRequest())
		{
			return;
		}
		
		$this->createHead();
		
		// Cover Container	
		?>
		<div id="dropdown_container"></div>
		
		<div id="none" style="display: none;"></div> 
		
		<div id="cover_background"></div> 
		<div id="cover">
			<div id="cover_container">
			</div> 
		</div> 
		
		<?php 		
		$navigation_page = new navigation_model(array()); 
		$navigation_page->createContent(); 
		
		?>
		
		<div class="app-body">
			
			<main class="main">
			
				<div class="container-fluid">
					<div id="ui-view">
						<div class="row">
							<div class="col-md-12">
								<div class="card">
									<div class="card-block">
										<h4 class="card-title mb-0"><?php echo $this->title; ?></h4>
										<div class="small text-muted">asdf insert text</div>
										<hr class="mb-4">

										<?php $this->createContent(); ?>
										
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
				<!-- /.conainer-fluid -->
			
			</main>
		
		</div> <!-- END div.app-body -->
		<?php 
		$footer_page = new footer_model(array()); 
		$footer_page->createContent(); 
		
		$this->createEnd();
	}

	public function createCover()
	{	?>
		<div class="container-fluid">
			<div class="row cover_title_row">
				<div class="col-sm-11">
					<?php /* 
					<span id='cover_title'><?php echo $this->title; ?></span>
					*/ ?>
				</div>
				<div class="col-sm-1">
					<span onclick="coverClose()">[X]</span>
				</div>
			</div>
			<?php $this->createContent(); ?>
			<div class="row">
				<div class="col-sm-12">
				<div class="cover_close_col">
					<button type="button" class="btn btn-secondary" onclick="coverClose();">Schliessen</button>
				</div>
			</div>
		</div>
		<script type="text/javascript">bind_events();</script>
		<?php 
	}	
	
	private function createHead()
	{	?>
<!DOCTYPE html>
<html lang="de">
	<head>
	
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	
		<meta http-equiv="content-type" content="text/html; charset=utf-8" />
		<link rel="icon" href="">
		
		<title>Swape Space</title>
		
		<link rel="stylesheet" href="css/bootstrap.css">
		<link rel="stylesheet" href="css/jquery-ui.css">		

		
		<!-- My CSS Sheets -->
		<link rel="stylesheet" href="css/myCSS/style.css">
		<link rel="stylesheet" href="css/myCSS/cover.css">

		
	</head>
	<body class="app header-fixed aside-menu-fixed aside-menu-hidden sidebar-hidden">
	<?php 
	}
	
	private function createEnd()
	{	?>
		<!-- Bootstrap and necessary plugins -->
		<script type="text/javascript" src="js/jquery-2.2.3.js"></script>
		<script type="text/javascript" src="js/jquery-ui.js"></script>
		<script type="text/javascript" src="js/bootstrap.js"></script>
		
		<!-- Firmenradar specific Scripts -->
		
		<script type="text/javascript" src="js/file_upload.js"></script>
		<script type="text/javascript" src="js/main.js"></script>
		<script type="text/javascript" src="js/jquery_binder.js"></script>
		
	</body>
</html>
		<?php 
	}
	
	/**
	 * 
	 * @param string $target - pagename
	 */
	protected function setBackButtonTarget($target)
	{	$this->back['target'] = $target; }

// 	protected function include404()
// 	{	$mypage = new not_found_page(array()); 
// 		$mypage->createCover(); 
// 	}
	
	protected function setTitle($title)
	{	$this->title = $title; }
	
	protected function setTitleClass($title_class)
	{	$this->title_class = $title_class; }
	
	protected function hideTitleRow()
	{	$this->show_title = false; }
	
	protected function hideContentWraper()
	{	$this->has_content_wraper = false; }
	
	protected function hasContentWraper()
	{	return $this->has_content_wraper; }
	

	
}
?>