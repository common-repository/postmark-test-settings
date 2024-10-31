(function() {
	var enable_selector
		= document.querySelector('input[name="pm_test_settings_enabled"]');
	var default_recipient_selector
		= document.querySelector('input[name="pm_test_settings_default_recipient"]');

	enable_selector.addEventListener('click', function() {
		default_recipient_selector.disabled = !enable_selector.checked;
	}, false);
})();
