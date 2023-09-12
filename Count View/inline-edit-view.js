jQuery(document).ready(function ($) {
	// Save changes via AJAX
	$('.view-edit').on('click', function () {
		$(this).hide();
		$(this).siblings('.view-count-wrapper').slideDown();
	});
	$('.save-view-count').on('click', function () {
		var $this = $(this);
		var post_id = $this.prev('.edit-view-count').data('post-id');
		var newCount = $this.prev('.edit-view-count').val();
		// Send the AJAX request to update the view count
		if (newCount < 0) {
			alert('Vui lòng nhập lượt xem lớn hơn 0');
			return;
		}
		$.ajax({
			type: 'POST',
			url: ajaxurl,
			data: {
				action: 'update_view_count',
				post_id: post_id,
				new_count: newCount,
			},
			success: function (response) {
				response = response.replace(/\n/g, '');
				$this.closest('.column-views').find('.edit-view-count').val(response);
				$this.closest('.column-views').find('.view-count').text(response);
			},
		});
	});
});
