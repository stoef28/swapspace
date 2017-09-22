

//HTML Request per AJAX holen
function loadPage(page_url, page_data, target_div_id, func) 
{		
    $.ajax({
        headers: {
            "Content-type": "application/x-www-form-urlencoded"
        },
        type: "POST",
        url: page_url,
        data: page_data,
        
        success: function(response){
        
            $('#none').html(response);

            if($('#' + target_div_id)!=null && $('#' + target_div_id).html() != $('#none').html())
            {
                //Internet Explorer Table Bug
                if(navigator.appVersion.indexOf("MSIE")>-1 || navigator.appVersion.indexOf("Chrome")>-1 || navigator.appVersion.indexOf("Safari")>-1) {
                    response=response.replace(/>\s+(?=<\/?(t|c)[hardfob])/gm,'>');
                }

                $('#' + target_div_id).html(response);
                
            }
            
            $('#none').html('');
            
            if(typeof func === 'function')
            {	func(); }
   
        }        
    });
}

function checkLogin()
{
	var submit_data = $("form#login_form").serialize();
	submit_data 	+= '&submit='+$("form#login_form").find("button[name='submit']").val();
	
	var ajex = $.ajax({
        headers: {
            "Content-type": "application/x-www-form-urlencoded"
        },
        type: "POST",
        url: "login_ajax",
        data: submit_data,
        
        success: function(response){
  
    		$("span#login_response").fadeOut(400, function() {
    			$("span#login_response").html(response); 
    			$("span#login_response").fadeIn(400); 
    		})
        	
        }        
    });
	
//	if($("div#login_response").html() == '')
//	{	return true; }
	
	return false;
}



function openLogin()
{
	// IE workaround
	
	var func = function(){ document.getElementById("login_email").focus(); }
	openWindow('login_cover', '', 'cover_container', 100, func);
	
}


function openCover(page_url, page_data, func) 
{ 
	$("div#cover_background").addClass("default");
	$("div#cover").addClass("cover_window");
	$("div#cover_background").fadeIn();
	$("div#cover").fadeIn();
	loadPage(page_url, page_data, 'cover_container', func);
}

function openWindow(page_url, page_data, target_div_id, margin_top, func) 
{ 
	$("div#cover_background").addClass("default");
    $("div#cover").addClass("cover_window");
    $("div#cover_background").fadeIn();
    $("div#cover").fadeIn();
    loadPage(page_url, page_data, target_div_id, func);
}


function coverClose() 
{
	$("div#cover_background").fadeOut(
			400, function() {
				$("div#cover_background").attr('class', '');
			}
	);
	
	$("div#cover").fadeOut(
			400, function() {
					$("div#cover_container").html('');
					$("div#cover").attr('class', '');
			}
	);
	
}

function gotoPage(page)
{	window.location = page; }

function showChat(){
	$('div#chat_window').addClass('show_chat');
	$('div#chat_window').removeClass('blinking');
}

function hideChat(){
	$('div#chat_window').removeClass('show_chat');
}

function sendMessage(dc_ide, text){
	
	text = $("input#chat_message").val();
	
	var ajex = $.ajax({
        headers: {
            "Content-type": "application/x-www-form-urlencoded"
        },
        type: "POST",
        url: "send_message_ajax",
        data: "dc_ide="+dc_ide+"&text="+text,
        
        success: function(response){
  
        	if(response){
        	
        	$('div#message_container').append('<div class="chat_item">'+text+'</div>');
        	}
        }        
    });
}

function auto_chat_update(){
	if(typeof chat_is_running != 'undefined' && chat_is_running){
		
		setInterval("loadMessage()", 1000); 
	}
	
}

async function loadMessage(){
	
	var ajex = $.ajax({
        headers: {
            "Content-type": "application/x-www-form-urlencoded"
        },
        type: "POST",
        url: "chat_messages_ajax",
        data: '',
        
        success: function(response){
  
        	if(response){
        		if($('div#chat_window').hasClass('hidden') && $('div#chat_window').hasClass('blinking')){
        			$('div#chat_window').removeClass('blinking');
        			
        		}else if($('div#chat_window').hasClass('hidden')){
        			$('div#chat_window').addClass('blinking');
        			
        		}else{
        			$('div#message_container').append(response);
        		}
        	}
        	
        }        
    });
}


