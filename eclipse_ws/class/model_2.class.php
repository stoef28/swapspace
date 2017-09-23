<?php

abstract class model
{
// 	protected $title = '';
// 	protected $title_class = 'page_title';
// 	protected $back = array('target' => '');
// 	protected $show_title = true;
// 	protected $has_content_wraper = true;
// 	protected $has_cards = false;
	protected $chat_active = false;

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
		

		<?php
		$navigation_page = new navigation_model(array());
		$navigation_page->createContent();

		?>
 		<main>

			<div class=" w3-content w3-center w3-animate-bottom " style="max-width:1200px; margin-top:50px">
				<?php $this->createContent(); ?>
			</div>
			
			<?php if($this->isChatActive()): ?>
			<div id="chatwindow"  class="w3-border-blue chatwindow w3-hide">
	            <div onclick="closeChatWindow()" class="w3-container w3-blue">
	                <span>Chat</span>
	            </div>
	            <div class="w3-container messagewindow">
	                <div class="left">
	                    <span>hi</span>
	                </div>
	                <div class="left">
	                    <span>how are you?</span>
	                </div>
	                <div class="right">
	                    <span>shut up!</span>
	                </div>
	
	            </div>
	            <div class=" w3-container" >
	                <form class="" action="index.html" method="post">
	                    <input type="text" name="" value="" style="width:180px">
	                    <input class="w3-btn w3-blue w3-hover-shadow" type="submit" name="" value="Send" style="height: 28.5px; margin-bottom:3px; padding-top:3px; width:76px">
	                </form>
	            </div>
	
	        </div>
	
	        <div id="chatbutton" onclick="openChatWindow()" class="w3-border-blue w3-center w3-hover-blue chatbutton w3-show">
	            <span>Chat</span>
	        </div>
			<?php endif; ?>
		</main>

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

		<title>Swap Space</title>

		<link rel="stylesheet" href="css/w3.css">
		<link rel="stylesheet" href="css/bootstrap.css">
	    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Lato">
	    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
		<link rel="stylesheet" href="css/jquery-ui.css">
	

		<!-- My CSS Sheets -->
		<link rel="stylesheet" href="css/myCSS/style.css">
		<link rel="stylesheet" href="css/myCSS/cover.css">
		<link rel="stylesheet" href="css/master.css">


	</head>
	
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

	protected function showChat(){
		$this->chat_active = true;
	}
	protected function isChatActive(){
		return $this->chat_active;
	}
}
?>
