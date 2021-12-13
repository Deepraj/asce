$(document).ready(function() {
	$("#unit_toggling").change(function() {
		selected_Unit = $('select[name=unit_toogling]').val();
		var page = $('#page_frame')
		var commentary = $('#commentry_frame')
		if (selected_Unit == 'customary') {
			page.contents().find('.si').hide();
			page.contents().find('.toggle').hide();
			page.contents().find('.customary').show();
			commentary.contents().find('.si').hide();
			commentary.contents().find('.toggle').hide();
			commentary.contents().find('.both').hide();
			commentary.contents().find('.customary').show();
		}
		if (selected_Unit == 'si') {
			page.contents().find('.customary').hide();
			page.contents().find('.toggle').hide();
			page.contents().find('.si').show();
			commentary.contents().find('.customary').hide();
			commentary.contents().find('.toggle').hide();
			commentary.contents().find('.both').hide();
			commentary.contents().find('.si').show();
		}
		if (selected_Unit == 'both') {
			page.contents().find('.customary').show();
			page.contents().find('.toggle').show();
			page.contents().find('.si').show();
			commentary.contents().find('.customary').show();
			commentary.contents().find('.toggle').show();
			commentary.contents().find('.si').show();
		}
	});
});