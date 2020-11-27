require('./bootstrap');


$('#sender').on('click', function(e){
   e.preventDefault();
    form = new FormData();
    var token = $('#form').children()[0].value;
    var content = $('#content').val();
    if (typeof($( '#thumbnail' )[0].files[0]) !== 'undefined'){
    var image = $( '#thumbnail' )[0].files[0];
    form.append( 'thumbnail', image );
    } 
    form.append('_token', token);
    form.append('content', content);
  	$.ajax({
 		type: "post",
 		url: "posts",
 		//data: {content: content, _token: token, thumbnail: data},
 		data: form,
 		processData: false,
    	contentType: false,
 		//dataType: 'json',
 			success: function(data){
 				//console.log(data);
 				window.location.href = '/';
 			},
 			error: function(err){

 				if (err.status == 422) {
 					
 					var error = [];

 					if (typeof(err.responseJSON.errors.content) !== 'undefined'){
 					var content_error = err.responseJSON.errors.content;
 						error = content_error;
 					}
 						 if (typeof(err.responseJSON.errors.thumbnail) !== 'undefined'){
 							var image_error = err.responseJSON.errors.thumbnail;
 						 		error = image_error;
 						} 
 							if ( typeof(err.responseJSON.errors.thumbnail) !== 'undefined' &&
 								 typeof(err.responseJSON.errors.content) !== 'undefined' ){
 							var image_error = err.responseJSON.errors.thumbnail;
 								error = image_error.concat(content_error);
 							}

 					$('#alert').remove()
 					
 					$('#form').before('<div id="alert" class="alert alert-danger"></div>')

 					$(error).each(function(i, val){
 						$('#alert').append(val+'<br>');
 					}); 

 				}
 			}
 	})
});