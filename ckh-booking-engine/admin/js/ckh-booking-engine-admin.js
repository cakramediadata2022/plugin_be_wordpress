(function ($) {
	'use strict';

	/**
	 * CKH Booking Engine Admin JavaScript
	 */
	$(document).ready(function () {

		// Initialize color pickers
		if (typeof $.fn.wpColorPicker !== 'undefined') {
			$('.color-picker').wpColorPicker({
				change: function (event, ui) {
					updatePreview();
				}
			});
		}

		// Tab functionality
		$('.nav-tab').on('click', function (e) {
			e.preventDefault();

			// Remove active class from all tabs and content
			$('.nav-tab').removeClass('nav-tab-active');
			$('.tab-content').removeClass('active');

			// Add active class to clicked tab
			$(this).addClass('nav-tab-active');

			// Show corresponding content
			var target = $(this).attr('href');
			$(target).addClass('active');
		});

		// Update preview when form fields change
		$('input, select').on('change keyup', function () {
			updatePreview();
		});

		// Initial preview update
		updatePreview();

		// Export settings functionality
		$('#export-settings').on('click', function () {
			var settings = {};

			// Collect all form values
			$('form input, form select').each(function () {
				var name = $(this).attr('name');
				if (name && name.includes('ckh_booking_engine_options')) {
					var key = name.replace('ckh_booking_engine_options[', '').replace(']', '');
					settings[key] = $(this).val();
				}
			});

			// Create download
			var dataStr = "data:text/json;charset=utf-8," + encodeURIComponent(JSON.stringify(settings, null, 2));
			var downloadAnchorNode = document.createElement('a');
			downloadAnchorNode.setAttribute("href", dataStr);
			downloadAnchorNode.setAttribute("download", "ckh-booking-engine-settings.json");
			document.body.appendChild(downloadAnchorNode);
			downloadAnchorNode.click();
			downloadAnchorNode.remove();
		});

		// Import settings functionality
		$('#import-settings').on('change', function (e) {
			var file = e.target.files[0];
			if (file) {
				var reader = new FileReader();
				reader.onload = function (e) {
					try {
						var settings = JSON.parse(e.target.result);

						// Apply settings to form
						for (var key in settings) {
							var input = $('input[name="ckh_booking_engine_options[' + key + ']"], select[name="ckh_booking_engine_options[' + key + ']"]');
							if (input.length) {
								if (input.hasClass('color-picker')) {
									input.wpColorPicker('color', settings[key]);
								} else {
									input.val(settings[key]);
								}
							}
						}

						updatePreview();
						alert('Settings imported successfully!');
					} catch (error) {
						alert('Error importing settings: Invalid JSON file');
					}
				};
				reader.readAsText(file);
			}
		});

		/**
		 * Update the preview based on current settings
		 */
		function updatePreview() {
			var settings = getFormSettings();

			// Update preview button
			var $previewButton = $('#preview-button');
			$previewButton.css({
				'background-color': settings.button_color || '#007cba',
				'color': settings.button_text_color || '#ffffff',
				'border-radius': (settings.border_radius || 4) + 'px',
				'font-family': settings.font_family || 'inherit',
				'font-size': (settings.font_size || 14) + 'px'
			});

			// Update preview form
			var $previewForm = $('.preview-form');
			$previewForm.css({
				'font-family': settings.font_family || 'inherit',
				'font-size': (settings.font_size || 14) + 'px'
			});

			// Update preview inputs
			$('.preview-field input, .preview-field select').css({
				'border-radius': (settings.border_radius || 4) + 'px',
				'border-color': settings.secondary_color || '#ddd',
				'font-family': settings.font_family || 'inherit',
				'font-size': (settings.font_size || 14) + 'px'
			});

			// Focus effect
			$('.preview-field input, .preview-field select').off('focus blur').on({
				'focus': function () {
					$(this).css('border-color', settings.primary_color || '#007cba');
				},
				'blur': function () {
					$(this).css('border-color', settings.secondary_color || '#ddd');
				}
			});
		}

		/**
		 * Get current form settings
		 */
		function getFormSettings() {
			var settings = {};

			$('input, select').each(function () {
				var name = $(this).attr('name');
				if (name && name.includes('ckh_booking_engine_options')) {
					var key = name.replace('ckh_booking_engine_options[', '').replace(']', '');
					settings[key] = $(this).val();
				}
			});

			return settings;
		}

		// Form validation
		$('form').on('submit', function (e) {
			var apiKey = $('input[name="ckh_booking_engine_options[api_key]"]').val();
			var apiUrl = $('input[name="ckh_booking_engine_options[api_url]"]').val();

			if (!apiKey.trim()) {
				alert('Please enter an API key.');
				e.preventDefault();
				$('.nav-tab[href="#api-settings"]').click();
				$('input[name="ckh_booking_engine_options[api_key]"]').focus();
				return false;
			}

			if (!apiUrl.trim()) {
				alert('Please enter an API URL.');
				e.preventDefault();
				$('.nav-tab[href="#api-settings"]').click();
				$('input[name="ckh_booking_engine_options[api_url]"]').focus();
				return false;
			}
		});

		// Auto-save functionality (optional)
		var autoSaveTimeout;
		$('input, select').on('change', function () {
			clearTimeout(autoSaveTimeout);
			autoSaveTimeout = setTimeout(function () {
				// Show saving indicator
				var $saveButton = $('.button-primary');
				var originalText = $saveButton.val();
				$saveButton.val('Auto-saving...').prop('disabled', true);

				// Auto-save would go here
				setTimeout(function () {
					$saveButton.val(originalText).prop('disabled', false);
				}, 1000);
			}, 2000);
		});

		// API Connection Test functionality
		$('#test-api-connection').on('click', function () {
			var $button = $(this);
			var $resultDiv = $('#api-test-result');
			var apiKey = $('#ckh-api-key').val();

			// Validate API key
			if (!apiKey || apiKey.trim() === '') {
				$resultDiv.html('<div class="notice notice-error inline"><p>Please enter an API key first.</p></div>');
				return;
			}

			// Disable button and show loading
			$button.prop('disabled', true).text('Testing...');
			$resultDiv.html('<div class="notice notice-info inline"><p>Testing API connection...</p></div>');

			// Make AJAX request
			$.ajax({
				url: ajaxurl,
				type: 'POST',
				data: {
					action: 'test_api_connection',
					api_key: apiKey,
					nonce: ckhBookingEngineAdmin.nonce
				},
				success: function (response) {
					if (response.success) {
						var noticeClass = response.data.success ? 'notice-success' : 'notice-error';
						var message = response.data.message;

						// Add debug information if available
						if (response.data.debug_info) {
							message += '<br><br><strong>Debug Info:</strong><br>';
							if (response.data.debug_info.origin) {
								message += '<strong>Origin:</strong> ' + response.data.debug_info.origin + '<br>';
							}
							if (response.data.debug_info.site_url) {
								message += '<strong>Site URL:</strong> ' + response.data.debug_info.site_url + '<br>';
							}
							if (response.data.debug_info.test_url) {
								message += '<strong>Test URL:</strong> ' + response.data.debug_info.test_url + '<br>';
							}
							if (response.data.debug_info.headers_sent) {
								message += '<strong>Headers Sent:</strong><br>';
								for (var header in response.data.debug_info.headers_sent) {
									message += '&nbsp;&nbsp;' + header + ': ' + response.data.debug_info.headers_sent[header] + '<br>';
								}
							}
						}

						$resultDiv.html('<div class="notice ' + noticeClass + ' inline"><p>' + message + '</p></div>');
					} else {
						$resultDiv.html('<div class="notice notice-error inline"><p>Test failed: ' + response.data + '</p></div>');
					}
				},
				error: function (xhr, status, error) {
					$resultDiv.html('<div class="notice notice-error inline"><p>Connection error: ' + error + '</p></div>');
				},
				complete: function () {
					// Re-enable button
					$button.prop('disabled', false).text('Test Connection');
				}
			});
		});

	});

})(jQuery);
