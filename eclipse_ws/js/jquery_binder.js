
$(document).ready(function() {
	bind_events();
});

function bind_events()
{	
	// active tooltips
	$('[data-toggle="tooltip"]').tooltip();
		 
	$('input[type=file]').on('change', fileHandler);
	
	var data = {token: $("form.file_upload").attr('token')};
//	$('form.file_upload').on('submit', uploadFiles);
//	$('form.file_upload_image_gallery').on('submit', uploadFiles);
	$('form.file_upload_image_gallery_cover').on('submit', uploadImageGalleryCover);
	
	
}

