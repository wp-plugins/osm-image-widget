jQuery(document).ready(function($){
	$('.widget-liquid-right').on('click', '.osm-image-widget-upload', function() {
		var send_attachment_bkp = wp.media.editor.send.attachment;
		var button = $(this);

		wp.media.editor.send.attachment = function(props, attachment) {
			$(button).prev().prev().val(attachment.id);
			$(button).prev().attr('src', attachment.url);
			$(button).prev().show();
			$(button).next('.osm-image-widget-delete').show();

			wp.media.editor.send.attachment = send_attachment_bkp;
		}
		wp.media.editor.open(button);

		return false;       
	});

	$('.widget-liquid-right').on('click', '.osm-image-widget-delete', function() {
		var button = $(this);

		$(button).hide();
		$(button).prev().prev().attr('src', '');
		$(button).prev().prev().hide();
		$(button).prev().prev().prev().val('');

		return false;       
	});

	$('.osm-image-widget-link-button').on('click', function(){
		get_post_list("");
    });

	$('#post-link-submit').on('click', function(){
		get_post_list($(this).prev().val());
	});

	function get_post_list( filter ){
		// la variable ajaxurl debe estar definida y apuntar a wp-admin/admin-ajax.php
		// en la data enviada con la petición, el parámetro "action" debe coincidir con la detección de la acción en PHP
		$.ajax({
			type: "POST",
			url: ajaxurl,
			data: {
				action: 'get_publish_posts',
				filter: filter,
			},
			success: function( data ){
				$("div#post-list-items").html(data);
			}
		});	
	}

	$('div#post-list-items').on('click', '.post-item', function(){
        $('.osm-image-widget-link').val($(this).attr('id'));
        tb_remove();
    });
});