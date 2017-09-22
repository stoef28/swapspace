

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

function openLogin(target)
{
	// IE workaround
	target = target || '';
	
	var func = function(){ document.getElementById("login_email").focus(); }
	openWindow('login_cover&target='+target, '', 'cover_container', 100, func);
	
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


