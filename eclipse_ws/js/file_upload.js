

// Variable to store your files
var files;

// Triggers when an input type=file gets changed
function fileHandler(event)
{	files = event.target.files;
//	console.log(event.target.files);
//	console.log(event.target.files[0].name);
	
	if(event.target.files.length > 1){
		
	}else if(event.target.files.length == 1){
		$("*[name='"+event.target.name+"_display']").val(event.target.files[0].name);

	}else{
		$("*[name='"+event.target.name+"_display']").val('');
	}
}

//Catch the form submit and upload the files
//function uploadFiles(event)
//{	
//	return false;
//	if(!event.data.token || event.data.token == undefined)
//	{	return; }
//	
//	event.stopPropagation(); 	// Stop stuff happening
//	event.preventDefault(); 	// Totally stop stuff happening
//	
//	// Create a formdata object and add the files
//	var data = new FormData();
//	$.each(files, function(key, value){
//		data.append(key, value);
//	});
//	
//	$.ajax({
//		url: 'file_upload_handler&file_upload_token='+event.data.token,
//		type: 'POST',
//		data: data,
//		cache: false,
//		dataType: 'json',
//		processData: false, // Because jQuery will convert the files arrays into strings and the server can't pick it up.
//		contentType: false, // Set this to false because jQuery defaults to application/x-www-form-urlencoded and doesn't send the files. Also setting it to multipart/form-data doesn't seem to work either.
//		success: function(data, textStatus, jqXHR)
//		{
//			if(typeof data.error === 'undefined')
//			{
//				
//				
//			}else
//			{
//				// Handle errors here
//			}
//			
////			alert(data.error);
//		},
//		error: function(jqXHR, textStatus, errorThrown)
//		{
//			// Handle errors here
////			alert(textStatus);
////			alert(errorThrown);
//		}
//	});
//}


//Catch the form submit and upload the files
function uploadImageGalleryCover(event)
{	
//	if(!event.data.token || event.data.token == undefined)
//	{	return; }

	event.stopPropagation(); 	// Stop stuff happening
	event.preventDefault(); 	// Totally stop stuff happening
		
	// Create a formdata object and add the files
	var data = new FormData();
	$.each(files, function(key, value){
		data.append(key, value);
	});
	
	$.ajax({
//		url: 'file_upload_handler&file_upload_token='+event.data.token,
		url: 'file_upload_handler',
		type: 'POST',
		data: data,
		cache: false,
		dataType: 'json',
		processData: false, // Because jQuery will convert the files arrays into strings and the server can't pick it up.
		contentType: false, // Set this to false because jQuery defaults to application/x-www-form-urlencoded and doesn't send the files. Also setting it to multipart/form-data doesn't seem to work either.
		success: function(data, textStatus, jqXHR)
		{

			console.log(data);
			
			if(typeof data.error === 'undefined')
			{
				coverClose();
				setGalleryImage(data.files[0]);
				
			}else
			{
				alert(data.error);
			}
		},
		error: function(jqXHR, textStatus, errorThrown)
		{
			// Handle errors here
//			alert(textStatus);
//			alert(errorThrown);
		}
 	});
	
	return false;
}


//function submitForm(event, data)
//{
//	return;
//	
//  // Create a jQuery object from the form
//    $form = $(event.target);
//
//    // Serialize the form data
//    var formData = $form.serialize();
//
//    // You should sterilise the file names
//    $.each(data.files, function(key, value)
//    {
//        formData = formData + '&filenames[]=' + value;
//    });
//
//    $.ajax({
//        url: 'submit.php',
//        type: 'POST',
//        data: formData,
//        cache: false,
//        dataType: 'json',
//        success: function(data, textStatus, jqXHR)
//        {
//            if(typeof data.error === 'undefined')
//            {
//                // Success so call function to process the form
//                console.log('SUCCESS: ' + data.success);
//            }
//            else
//            {
//                // Handle errors here
//                console.log('ERRORS: ' + data.error);
//            }
//        },
//        error: function(jqXHR, textStatus, errorThrown)
//        {
//            // Handle errors here
//            console.log('ERRORS: ' + textStatus);
//        },
//        complete: function()
//        {
//            // STOP LOADING SPINNER
//        }
//    });
//}



