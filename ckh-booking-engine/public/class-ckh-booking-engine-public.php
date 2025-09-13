<?php

/**
 * The public-facing functionality of the plugin.
 *
 * @link       https://cakrasoft.com/
 * @since      1.0.0
 *
 * @package    CKH_Booking_Engine
 * @subpackage CKH_Booking_Engine/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the public-facing stylesheet and JavaScript.
 *
 * @package    CKH_Booking_Engine
 * @subpackage CKH_Booking_Engine/public
 * @author     cakrasoft <info@cakrasoft.com>
 */
class CKH_Booking_Engine_Public
{

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $ckh_booking_engine    The ID of this plugin.
	 */
	private $ckh_booking_engine;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $plugin_name       The name of the plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct($ckh_booking_engine, $version)
	{

		$this->ckh_booking_engine = $ckh_booking_engine;
		$this->version = $version;
		// Register shortcode
		add_shortcode('ckh_booking_engine', array($this, 'ckh_booking_engine_shortcode'));
	}

	/**
	 * Register the stylesheets for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles()
	{

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in CKH_Booking_Engine_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The CKH_Booking_Engine_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style($this->ckh_booking_engine, plugin_dir_url(__FILE__) . 'css/ckh-booking-engine-public.css', array(), $this->version, 'all');

		// Add custom CSS variables for styling
		$this->add_custom_css_variables();
	}

	/**
	 * Add custom CSS variables based on plugin settings
	 *
	 * @since    1.0.0
	 */
	private function add_custom_css_variables()
	{
		$settings = CKH_Booking_Engine_Settings::get_settings();

		// Generate scoped CSS for the booking engine
		$custom_css = "
		/* CKH Booking Engine Custom Styles */
		.ckh-booking-engine-wrapper {
			--ckh-primary-color: {$settings['primary_color']};
			--ckh-secondary-color: {$settings['secondary_color']};
			--ckh-accent-color: {$settings['accent_color']};
			--ckh-button-color: {$settings['button_color']};
			--ckh-button-text-color: {$settings['button_text_color']};
			--ckh-font-family: {$settings['font_family']};
			--ckh-font-size: {$settings['font_size']}px;
			--ckh-border-radius: {$settings['border_radius']}px;
		}
		
		/* Apply settings to booking engine components */
		.ckh-booking-engine-wrapper {
			font-family: var(--ckh-font-family) !important;
			font-size: var(--ckh-font-size) !important;
		}
		
		.ckh-booking-engine-wrapper .ckh-be-container {
			border-radius: var(--ckh-border-radius) !important;
			background-color: var(--ckh-secondary-color) !important;
		}
		
		.ckh-booking-engine-wrapper .ckh-be-button {
			background-color: var(--ckh-button-color) !important;
			color: var(--ckh-button-text-color) !important;
			border-radius: var(--ckh-border-radius) !important;
			border: none !important;
			font-family: var(--ckh-font-family) !important;
			font-size: var(--ckh-font-size) !important;
			transition: all 0.3s ease !important;
		}
		
		.ckh-booking-engine-wrapper .ckh-be-button:hover {
			opacity: 0.9 !important;
			transform: translateY(-1px) !important;
		}
		
		.ckh-booking-engine-wrapper .ckh-be-input {
			border-radius: var(--ckh-border-radius) !important;
			font-family: var(--ckh-font-family) !important;
			font-size: var(--ckh-font-size) !important;
			border: 1px solid var(--ckh-secondary-color) !important;
		}
		
		.ckh-booking-engine-wrapper .ckh-be-input:focus {
			border-color: var(--ckh-primary-color) !important;
			box-shadow: 0 0 0 2px rgba(" . $this->hex_to_rgb($settings['primary_color']) . ", 0.2) !important;
		}
		
		.ckh-booking-engine-wrapper .ckh-be-card {
			background-color: white !important;
			border-radius: var(--ckh-border-radius) !important;
			border: 1px solid var(--ckh-secondary-color) !important;
		}
		
		.ckh-booking-engine-wrapper .ckh-be-text-primary {
			color: var(--ckh-primary-color) !important;
		}
		
		.ckh-booking-engine-wrapper .ckh-be-text-accent {
			color: var(--ckh-accent-color) !important;
		}
		
		.ckh-booking-engine-wrapper .ckh-be-dropdown {
			background-color: white !important;
			border-radius: var(--ckh-border-radius) !important;
			border: 1px solid var(--ckh-secondary-color) !important;
		}
		
		.ckh-booking-engine-wrapper .ckh-be-counter-btn {
			background-color: var(--ckh-secondary-color) !important;
			color: var(--ckh-primary-color) !important;
			border-radius: var(--ckh-border-radius) !important;
			border: 1px solid var(--ckh-primary-color) !important;
			font-family: var(--ckh-font-family) !important;
			transition: all 0.2s ease !important;
		}
		
		.ckh-booking-engine-wrapper .ckh-be-counter-btn:hover {
			background-color: var(--ckh-primary-color) !important;
			color: white !important;
		}
		";

		wp_add_inline_style($this->ckh_booking_engine, $custom_css);
	}

	/**
	 * Convert hex color to RGB values
	 *
	 * @since    1.0.0
	 */
	private function hex_to_rgb($hex)
	{
		$hex = ltrim($hex, '#');
		if (strlen($hex) == 3) {
			$hex = $hex[0] . $hex[0] . $hex[1] . $hex[1] . $hex[2] . $hex[2];
		}
		$r = hexdec(substr($hex, 0, 2));
		$g = hexdec(substr($hex, 2, 2));
		$b = hexdec(substr($hex, 4, 2));
		return "$r, $g, $b";
	}

	/**
	 * Register the JavaScript for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts()
	{
		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in CKH_Booking_Engine_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The CKH_Booking_Engine_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */
		wp_enqueue_script($this->ckh_booking_engine, plugin_dir_url(__FILE__) . 'js/ckh-booking-engine-public.js', array('jquery'), $this->version, false);

		// Localize script with plugin settings
		wp_localize_script($this->ckh_booking_engine, 'ckh_booking_engine', CKH_Booking_Engine_Settings::get_js_settings());
	}

	/**
	 * Shortcode output for [ckh_booking_engine]
	 *
	 * @since    1.0.0
	 * @param    array $atts Shortcode attributes.
	 * @return   string HTML output for the booking engine.
	 */
	public function ckh_booking_engine_shortcode($atts)
	{
		// Get settings for JavaScript variables
		$settings = CKH_Booking_Engine_Settings::get_settings();
		$api_key = $settings['api_key'];
		$api_url = CKH_Booking_Engine::get_api_url();
		$callback_url = !empty($settings['callback_url']) ? $settings['callback_url'] : 'https://cakrasoft.net/confirmation-payment';

		ob_start();
?>
		<link rel="stylesheet" href="<?php echo plugin_dir_url(__FILE__); ?>css/litepicker.css" />
		<link rel="stylesheet" href="<?php echo plugin_dir_url(__FILE__); ?>css/ckh-booking-engine-public.css" />
		<script src="<?php echo plugin_dir_url(__FILE__); ?>js/litepicker.js"></script>
		<script src="<?php echo plugin_dir_url(__FILE__); ?>js/alpine.min.js" defer></script>

		<script>
			// CKH Booking Engine Configuration
			const ckhBookingConfig = {
				apiKey: '<?php echo esc_js($api_key); ?>',
				apiUrl: '<?php echo esc_js($api_url); ?>',
				siteUrl: '<?php echo esc_js(get_site_url()); ?>',
				callbackUrl: '<?php echo esc_js($callback_url); ?>'
			};

			function initBookingEngine() {
				return {
					picker: null,
					search: '',
					guestsOpen: false,
					adults: 2,
					children: 0,
					pets: false,
					rooms: 1,
					loading: false,
					dateRanges: "",
					decreaseAdults() {
						if (this.adults > 1) {
							this.adults = this.adults + (-1);
						}
					},
					increaseAdults() {
						this.adults = this.adults + 1;
					},
					decreaseChildren() {
						if (this.children > 0) {
							this.children = this.children + (-1);
						}
					},
					increaseChildren() {
						this.children = this.children + 1;
					},
					decreaseRooms() {
						if (this.rooms > 1) {
							this.rooms = this.rooms + (-1);
						}
					},
					increaseRooms() {
						this.rooms = this.rooms + 1;
					},
					getGuestText() {
						return this.adults + ' adults, ' + this.children + ' children' + (this.pets ? ', Pet friendly' : '');
					},
					getRoomText() {
						return this.rooms + ' room';
					},
					async performSearch() {
						this.loading = true;
						// Parse date range string to get start and end date in YYYY-MM-DD format
						let dateRange = this.$refs.dateRange.value;
						let [startDate, endDate] = dateRange.split(' - ');
						// Now startDate and endDate are in YYYY-MM-DD format
						console.log('Parsed Dates:', {
							startDate,
							endDate
						});
						console.log('Search Data:', {
							search: this.search,
							dates: dateRange,
							startDate: startDate,
							endDate: endDate,
							adults: this.adults,
							children: this.children,
							pets: this.pets,
							rooms: this.rooms
						});

						await this.requestToBookingEngine(startDate, endDate, this.adults, this.children);
						this.loading = false;
					},
					async initDatePicker() {
						this.initDefaultData();
						this.$nextTick(() => {
							this.picker = new Litepicker({
								element: this.$refs.dateRange,
								singleMode: false,
								numberOfMonths: window.innerWidth < 640 ? 1 : 2,
								numberOfColumns: window.innerWidth < 640 ? 1 : 2,
								autoApply: false,
								format: 'YYYY-MM-DD',
								resetButton: false,
								mobileFriendly: true,
								startDate: this.dateRanges.split(' - ')[0],
								endDate: this.dateRanges.split(' - ')[1],
							});
						});
						await this.requestToBookingEngine(this.dateRanges.split(' - ')[0], this.dateRanges.split(' - ')[1], this
							.adults, this.children);
					},
					initDefaultData() {
						let today = new Date();
						let tomorrow = new Date();
						tomorrow.setDate(today.getDate() + 1);

						function formatDate(date) {
							return date.toISOString().slice(0, 10);
						}

						this.dateRanges = formatDate(today) + " - " + formatDate(tomorrow);
					},
					async requestToBookingEngine(start_date, end_date, adults, children) {
						// Implement the API request logic here
						console.log('Function parameters:', {
							start_date,
							end_date,
							adults,
							children
						});

						const myHeaders = new Headers();
						myHeaders.append("token", ckhBookingConfig.apiKey);
						myHeaders.append("Origin", ckhBookingConfig.siteUrl);

						const requestOptions = {
							method: "GET",
							headers: myHeaders,
							redirect: "follow"
						};

						// Construct URL parameters manually to avoid WordPress HTML encoding
						const params = new URLSearchParams({
							'StartDate': start_date,
							'EndDate': end_date,
							'Adults': adults,
							'Children': children
						});
						const apiUrl = `${ckhBookingConfig.apiUrl}/roomavailability?${params.toString()}`;
						console.log('Request URL:', apiUrl);
						await fetch(apiUrl, requestOptions)
							.then((response) => response.json())
							.then((data) => {
								console.log('API Response:', data);
								this.displayRooms(data);
							})
							.catch((error) => {
								console.error('API Error:', error);
								this.displayError();
							});
					},
					displayRooms(data) {
						const roomPreview = document.getElementById('room-preview');

						if (data.StatusCode === 0 && data.Result && data.Result.length > 0) {
							// Clear existing content
							roomPreview.innerHTML = '';

							// Loop through rooms and create cards
							data.Result.forEach(room => {
								const roomCard = this.createRoomCard(room);
								roomPreview.appendChild(roomCard);
							});
						} else {
							roomPreview.innerHTML =
								'<div class="text-center py-8 text-gray-500">No rooms available for the selected dates.</div>';
						}
					},
					createRoomCard(room) {
						const roomDiv = document.createElement('div');
						const imageUrl = room.image_details && room.image_details[0] ? room.image_details[0].image_name :
							'https://picsum.photos/400/400';

						// Find the cheapest rate
						const rates = room.rate_details || [];
						const availableRates = rates.filter(rate => rate.is_close === 0);
						const cheapestRate = availableRates.length > 0 ?
							availableRates.reduce((min, rate) => rate.rate_price < min.rate_price ? rate : min) : null;

						// Generate unique ID for this room card
						const roomId = `room-${room.room_code}-${Math.random().toString(36).substr(2, 9)}`;

						roomDiv.innerHTML = `
                        <div id="${roomId}" class="flex flex-col mb-3 md:flex-row max-w-4xl mx-auto rounded-2xl shadow-lg overflow-hidden bg-white cursor-pointer transition-all duration-300 hover:shadow-xl hover:-translate-y-1" data-all-rates='${JSON.stringify(availableRates)}' data-current-rate='${cheapestRate ? cheapestRate.rate_code : ''}'>
                            <!-- Image -->
                            <img src="${imageUrl}" alt="${room.room_name}" class="w-full md:w-72 h-64 md:h-auto object-cover" />

                            <!-- Content -->
                            <div class="flex flex-col justify-between p-4 flex-1">
                                <!-- Title -->
                                <h2 class="text-lg md:text-xl font-semibold leading-snug">
                                    ${room.room_name}
                                </h2>

                                <!-- Rating -->
                                <div class="flex items-center gap-2 mt-1">
                                    <div class="text-yellow-500 text-sm">★★★★★</div>
                                    <span class="text-xs md:text-sm text-gray-500">Available Rooms: ${room.number_of_rooms}</span>
                                </div>

                                <!-- Room Details -->
                                <p class="text-xs md:text-sm text-gray-500">Max Adults: ${room.room_max_adult} | Max Children: ${room.room_max_children}</p>

                                <!-- Categories -->
                                <div class="flex flex-wrap gap-1 mt-1">
                                    <span class="px-2 py-0.5 rounded-full border-solid border-gray-300 text-[11px] md:text-xs">
                                        ${room.room_bed} Bed${room.room_bed > 1 ? 's' : ''}
                                    </span>
                                    <span class="px-2 py-0.5 rounded-full border-solid border-gray-300 text-[11px] md:text-xs">
                                        Room Size: ${room.room_size}sqm
                                    </span>
                                    <span class="px-2 py-0.5 rounded-full border-solid border-gray-300 text-[11px] md:text-xs">
                                        ${room.room_code}
                                    </span>
                                </div>

                                <!-- Description -->
                                <p class="text-xs md:text-sm text-gray-600 mt-2 line-clamp-2">
                                    ${room.room_description || 'Comfortable room with excellent amenities.'}
                                </p>

                                <!-- Rate Selection -->
                                <div class="mt-3">
                                    ${cheapestRate ? `
                                    <!-- Cheapest Rate Display -->
                                    <div class="flex items-center justify-between p-2 bg-gray-50 rounded-lg">
                                        <div>
                                            <p class="text-sm font-medium text-gray-800">${cheapestRate.rate_name}</p>
                                            <p class="text-xs text-gray-500">${cheapestRate.rate_description}</p>
                                        </div>
                                        <div class="text-right">
                                            <p class="text-lg font-bold text-blue-600">IDR ${cheapestRate.rate_price.toLocaleString()}</p>
                                            <p class="text-xs text-gray-500">per night</p>
                                        </div>
                                    </div>

                                    <!-- Show All Rates Button -->
                                    ${availableRates.length > 1 ? `
                                    <button onclick="toggleRates('${roomId}')" class="w-full mt-2 text-sm text-blue-600 hover:text-blue-800 flex items-center justify-center gap-1">
                                        <span>View ${availableRates.length - 1} more rate${availableRates.length > 2 ? 's' : ''}</span>
                                        <svg class="w-4 h-4 transition-transform" id="${roomId}-arrow" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                                        </svg>
                                    </button>

                                    <!-- All Rates Dropdown -->
                                    <div id="${roomId}-rates" class="hidden mt-2 space-y-2">
                                        ${availableRates.slice(1).map(rate => `
                                            <div class="flex items-center justify-between p-2 border border-gray-200 rounded-lg hover:bg-gray-50 cursor-pointer" onclick="selectRate('${roomId}', '${rate.rate_code}', '${rate.rate_name}', ${rate.rate_price}, '${rate.rate_description}')">
                                                <div>
                                                    <p class="text-sm font-medium text-gray-800">${rate.rate_name}</p>
                                                    <p class="text-xs text-gray-500">${rate.rate_description}</p>
                                                </div>
                                                <div class="text-right">
                                                    <p class="text-lg font-bold text-gray-800">IDR ${rate.rate_price.toLocaleString()}</p>
                                                    <p class="text-xs text-gray-500">per night</p>
                                                </div>
                                            </div>
                                        `).join('')}
                                    </div>
                                    ` : ''}
                                    ` : `
                                    <div class="p-2 bg-red-50 rounded-lg">
                                        <p class="text-sm text-red-600">No rates available</p>
                                    </div>
                                    `}
                                </div>

                                <!-- Book Now Button -->
                                <div class="mt-3">
                                    <button onclick="openBookingForm('${roomId}', '${room.room_name}', '${cheapestRate ? cheapestRate.rate_name : ''}', '${cheapestRate ? cheapestRate.rate_price : 0}')" class="w-full bg-blue-500 text-white px-4 py-2 rounded-lg hover:bg-blue-600 transition-colors" ${!cheapestRate ? 'disabled' : ''}>
                                        ${cheapestRate ? 'Book Now' : 'Not Available'}
                                    </button>
                                </div>
                            </div>
                        </div>
                    `;

						return roomDiv;
					},
					displayError() {
						const roomPreview = document.getElementById('room-preview');
						roomPreview.innerHTML =
							'<div class="text-center py-8 text-red-500">Error loading rooms. Please try again.</div>';
					}
				}
			}
			// Global functions for rate selection
			function toggleRates(roomId) {
				const ratesDiv = document.getElementById(roomId + '-rates');
				const arrow = document.getElementById(roomId + '-arrow');

				if (ratesDiv.classList.contains('hidden')) {
					ratesDiv.classList.remove('hidden');
					arrow.style.transform = 'rotate(180deg)';
				} else {
					ratesDiv.classList.add('hidden');
					arrow.style.transform = 'rotate(0deg)';
				}
			}

			function selectRate(roomId, rateCode, rateName, ratePrice, rateDescription) {
				// Find the room card
				const roomCard = document.getElementById(roomId);
				if (!roomCard) {
					console.error('Room card not found for ID:', roomId);
					return;
				}
				const mainRateDisplay = roomCard.querySelector('.bg-gray-50');
				if (!mainRateDisplay) {
					console.error('Rate display not found in room card:', roomId);
					return;
				}

				// Update the main rate display
				mainRateDisplay.innerHTML = `
                <div>
                    <p class="text-sm font-medium text-gray-800">${rateName}</p>
                    <p class="text-xs text-gray-500">${rateDescription}</p>
                </div>
                <div class="text-right">
                    <p class="text-lg font-bold text-blue-600">IDR ${ratePrice.toLocaleString()}</p>
                    <p class="text-xs text-gray-500">per night</p>
                </div>
            `;

				// Get all available rates and filter out the selected one
				const allRates = JSON.parse(roomCard.dataset.allRates);
				const otherRates = allRates.filter(rate => rate.rate_code !== rateCode);

				// Update the dropdown content
				const ratesDropdown = document.getElementById(roomId + '-rates');
				ratesDropdown.innerHTML = otherRates.map(rate => `
					<div class="flex items-center justify-between p-2 border border-gray-200 rounded-lg hover:bg-gray-50 cursor-pointer" onclick="selectRate('${roomId}', '${rate.rate_code}', '${rate.rate_name}', ${rate.rate_price}, '${rate.rate_description}')">
						<div>
							<p class="text-sm font-medium text-gray-800">${rate.rate_name}</p>
							<p class="text-xs text-gray-500">${rate.rate_description}</p>
						</div>
						<div class="text-right">
							<p class="text-lg font-bold text-gray-800">IDR ${rate.rate_price.toLocaleString()}</p>
							<p class="text-xs text-gray-500">per night</p>
						</div>
					</div>
				`).join('');

				// Update the "View more rates" text
				const viewMoreButton = roomCard.querySelector(`[onclick*="toggleRates('${roomId}')"] span`);
				const remainingCount = otherRates.length;
				if (remainingCount > 0 && viewMoreButton) {
					viewMoreButton.textContent = `View ${remainingCount} more rate${remainingCount > 1 ? 's' : ''}`;
				}

				// Update the current rate in dataset
				roomCard.dataset.currentRate = rateCode;

				// Hide the rates dropdown
				toggleRates(roomId);

				console.log('Selected rate:', {
					roomId,
					rateCode,
					rateName,
					ratePrice,
					rateDescription
				});
			}

			// Global variables to store current booking context
			let currentBookingContext = {};

			// Booking form functions
			function openBookingForm(roomId, roomName, rateName, ratePrice) {
				// Get current booking data from the Alpine.js component
				const bookingData = window.Alpine.store || {};
				const dateRange = document.querySelector('[x-ref="dateRange"]').value;
				const adults = document.querySelector('[x-text="adults"]').textContent;
				const children = document.querySelector('[x-text="children"]').textContent;

				// Get selected rate data from room card
				const roomCard = document.getElementById(roomId);
				let selectedRate = rateName;
				let selectedPrice = ratePrice;
				let roomCode = '';
				let rateCode = '';

				if (roomCard) {
					const currentRateCode = roomCard.dataset.currentRate;
					const allRates = JSON.parse(roomCard.dataset.allRates);
					const currentRate = allRates.find(rate => rate.rate_code === currentRateCode);
					if (currentRate) {
						selectedRate = currentRate.rate_name;
						selectedPrice = currentRate.rate_price;
						rateCode = currentRate.rate_code;
					}

					// Extract room code from room card data (assuming it's stored in a data attribute)
					// You might need to modify this based on how you store room code
					const roomData = roomCard.querySelector('.room-data');
					if (roomData) {
						roomCode = roomData.dataset.roomCode;
					} else {
						// Fallback: extract from room card ID or other source
						const roomIdParts = roomId.split('-');
						if (roomIdParts.length >= 2) {
							roomCode = roomIdParts[1]; // room-{ROOMCODE}-{randomid}
						}
					}
				}

				// Store booking context globally for submission
				currentBookingContext = {
					roomId: roomId,
					roomCode: roomCode,
					rateCode: rateCode,
					roomName: roomName,
					rateName: selectedRate,
					ratePrice: selectedPrice
				};

				// Parse dates
				const [checkIn, checkOut] = dateRange.split(' - ');

				// Populate form fields
				document.getElementById('booking-room-type').value = roomName + ' - ' + selectedRate;
				document.getElementById('booking-room-price').value = 'IDR ' + selectedPrice.toLocaleString() + ' / night';
				document.getElementById('booking-checkin').value = checkIn;
				document.getElementById('booking-checkout').value = checkOut;
				document.getElementById('booking-adults').value = adults || '2';
				document.getElementById('booking-children').value = children || '0';

				// Show modal
				document.getElementById('booking-modal').classList.remove('hidden');
				document.body.style.overflow = 'hidden';
			}

			function closeBookingForm() {
				document.getElementById('booking-modal').classList.add('hidden');
				document.body.style.overflow = 'auto';
			}

			function submitBooking() {
				// Get form data
				const formData = {
					roomType: document.getElementById('booking-room-type').value,
					roomPrice: document.getElementById('booking-room-price').value,
					fullName: document.getElementById('booking-full-name').value,
					email: document.getElementById('booking-email').value,
					phone: document.getElementById('booking-phone').value,
					checkIn: document.getElementById('booking-checkin').value,
					checkOut: document.getElementById('booking-checkout').value,
					adults: document.getElementById('booking-adults').value,
					children: document.getElementById('booking-children').value,
					country: document.getElementById('booking-country').value,
					state: document.getElementById('booking-state').value,
					city: document.getElementById('booking-city').value,
					postCode: document.getElementById('booking-postcode').value
				};

				// Basic validation
				if (!formData.fullName || !formData.email || !formData.phone) {
					alert('Please fill in all required fields (Name, Email, Phone)');
					return;
				}

				// Email validation
				const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
				if (!emailRegex.test(formData.email)) {
					alert('Please enter a valid email address');
					return;
				}

				console.log('Booking Data:', formData);

				// Get room and rate information from the stored booking context
				const roomTypeText = formData.roomType;
				const roomPriceText = formData.roomPrice;

				// Extract price number from "IDR 100,000 / night" format
				const priceMatch = roomPriceText.match(/IDR\s+([\d,]+)/);
				const roomPrice = priceMatch ? parseInt(priceMatch[1].replace(/,/g, '')) : 0;

				// Use stored booking context for room and rate codes
				const roomCode = currentBookingContext.roomCode || "DLX";
				const rateCode = currentBookingContext.rateCode || "STDRRO";

				// Prepare API request
				const myHeaders = new Headers();
				myHeaders.append("Content-Type", "application/json");
				myHeaders.append("token", ckhBookingConfig.apiKey);

				const bookingPayload = {
					"booking_form": {
						"room_code": roomCode,
						"rate_code": rateCode,
						"room_price": roomPrice,
						"arrival_date": formData.checkIn,
						"arrival_time": "14:00",
						"departure_date": formData.checkOut,
						"guest_detail": {
							"name": formData.fullName,
							"phone": formData.phone,
							"email": formData.email,
							"address": {
								"area": formData.city,
								"country": formData.country,
								"city": formData.city,
								"state": formData.state,
								"postCode": formData.postCode
							}
						},
						"guests": parseInt(formData.adults),
						"rooms": 1
					},
					"payment_info": {
						"redirect_url": ckhBookingConfig.callbackUrl,
						"send_url_to_email": true
					}
				};

				const requestOptions = {
					method: "POST",
					headers: myHeaders,
					body: JSON.stringify(bookingPayload),
					redirect: "follow"
				};

				// Show loading state
				const submitButton = document.querySelector('[onclick="submitBooking()"]');
				const originalButtonText = submitButton.textContent;
				submitButton.textContent = 'Processing...';
				submitButton.disabled = true;

				// Make API request
				fetch(`${ckhBookingConfig.apiUrl}/createbooking`, requestOptions)
					.then((response) => response.json())
					.then((result) => {
						console.log('Booking API Response:', result);

						if (result.StatusCode === 0 && result.Result && result.Result.payment_url && result.Result.payment_url
							.redirect_url) {
							// Success - show payment iframe
							const bookingCode = result.Result.booking_code;
							const paymentUrl = result.Result.payment_url.redirect_url;

							console.log('Booking successful:', {
								bookingCode: bookingCode,
								paymentId: result.Result.payment_id,
								paymentToken: result.Result.payment_token,
								paymentUrl: paymentUrl
							});

							// Close booking form and show payment modal
							closeBookingForm();
							openPaymentModal(paymentUrl, bookingCode);

							// Reset form
							document.getElementById('booking-full-name').value = '';
							document.getElementById('booking-email').value = '';
							document.getElementById('booking-phone').value = '';
							document.getElementById('booking-country').value = '';
							document.getElementById('booking-state').value = '';
							document.getElementById('booking-city').value = '';
							document.getElementById('booking-postcode').value = '';
						} else {
							alert('Booking submission failed. Please try again or contact support.');
							console.error('Booking failed:', result);
						}
					})
					.catch((error) => {
						console.error('Booking API Error:', error);
						alert('An error occurred while submitting your booking. Please try again.');
					})
					.finally(() => {
						// Restore button state
						submitButton.textContent = originalButtonText;
						submitButton.disabled = false;
					});
			}

			// Close modal when clicking outside
			document.addEventListener('click', function(e) {
				const modal = document.getElementById('booking-modal');
				if (e.target === modal) {
					closeBookingForm();
				}
			});

			// Close modal with Escape key
			document.addEventListener('keydown', function(e) {
				if (e.key === 'Escape') {
					closeBookingForm();
					closePaymentModal();
				}
			});

			// Payment modal functions
			function openPaymentModal(paymentUrl, bookingCode) {
				// Set the iframe source
				document.getElementById('payment-iframe').src = paymentUrl;

				// Update booking code display
				document.getElementById('booking-code-display').textContent = bookingCode;

				// Show payment modal
				document.getElementById('payment-modal').classList.remove('hidden');
				document.body.style.overflow = 'hidden';
			}

			function closePaymentModal() {
				// Hide payment modal
				document.getElementById('payment-modal').classList.add('hidden');
				document.body.style.overflow = 'auto';

				// Clear iframe source to stop loading
				document.getElementById('payment-iframe').src = 'about:blank';
			}

			// Close payment modal when clicking outside
			document.addEventListener('click', function(e) {
				const paymentModal = document.getElementById('payment-modal');
				if (e.target === paymentModal) {
					closePaymentModal();
				}
			});
		</script>

		<!-- CKH Booking Engine - Customizable with Admin Settings -->
		<div class="ckh-booking-engine-wrapper">
			<div class="ckh-be-container w-full p-3 sm-p-4 md-p-5 lg-p-6 rounded-2xl shadow-md space-y-4"
				x-data="initBookingEngine()" x-init="initDatePicker()">

				<!-- Date + Guests in one row -->
				<div class="flex flex-col md:flex-row gap-3">
					<!-- Date Range Picker -->
					<div class="ckh-be-card flex-1 py-2 sm-py-2 md-py-1 lg-py-0 flex items-center gap-2 px-3 cursor-pointer"
						@click="picker.show()">
						<input type="text" x-ref="dateRange" placeholder="Select date range"
							class="ckh-be-input w-full border-0 text-sm outline-none cursor-pointer" readonly />
					</div>

					<!-- Guests Dropdown -->
					<div class="relative flex-1">
						<div class="ckh-be-card flex items-center justify-between gap-2 px-3 cursor-pointer"
							@click="guestsOpen = !guestsOpen">
							<div>
								<p class="text-sm mt-2 mb-0 font-medium text-gray-700 truncate" x-text="getGuestText()"></p>
								<p class="ckh-be-text-primary text-xs mb-2 mt-0 truncate" x-text="getRoomText()"></p>
							</div>
							<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2"
								stroke="currentColor" class="w-5 h-5 text-gray-400">
								<path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
							</svg>
						</div>

						<!-- Dropdown Panel -->
						<div x-show="guestsOpen" @click.away="guestsOpen = false"
							class="ckh-be-dropdown absolute z-10 mt-2 w-64 md-w-full shadow-lg p-4 space-y-3">
							<!-- Adults -->
							<div class="flex items-center justify-between">
								<span>Adults</span>
								<div class="flex items-center gap-2">
									<button class="ckh-be-counter-btn px-2 py-1" @click="decreaseAdults()">-</button>
									<span x-text="adults"></span>
									<button class="ckh-be-counter-btn px-2 py-1" @click="increaseAdults()">+</button>
								</div>
							</div>

							<!-- Children -->
							<div class="flex items-center justify-between">
								<span>Children</span>
								<div class="flex items-center gap-2">
									<button class="ckh-be-counter-btn px-2 py-1" @click="decreaseChildren()">-</button>
									<span x-text="children"></span>
									<button class="ckh-be-counter-btn px-2 py-1" @click="increaseChildren()">+</button>
								</div>
							</div>

							<!-- Rooms -->
							<!-- <div class="flex items-center justify-between">
								<span>Rooms</span>
								<div class="flex items-center gap-2">
									<button class="ckh-be-counter-btn px-2 py-1" @click="decreaseRooms()">-</button>
									<span x-text="rooms"></span>
									<button class="ckh-be-counter-btn px-2 py-1" @click="increaseRooms()">+</button>
								</div>
							</div> -->
						</div>
					</div>
				</div>

				<!-- Search Button -->
				<button
					class="w-full cursor-pointer bg-blue-500 border-0 text-white font-semibold py-2 rounded-lg shadow hover:bg-blue-600 flex items-center justify-center gap-2"
					:disabled="loading" @click="performSearch()">
					<template x-if="loading">
						<svg class="animate-spin h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none"
							viewBox="0 0 24 24">
							<circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
							<path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v4a4 4 0 00-4 4H4z"></path>
						</svg>
					</template>
					<span x-text="loading ? 'Processing...' : 'Book Now'"></span>
				</button>
			</div>
		</div>
		<div id="room-preview">
		</div>

		<!-- Booking Form Modal -->
		<div id="booking-modal" class="fixed inset-0 z-50 hidden">
			<div class="flex items-center justify-center min-h-screen p-4">
				<div
					class="max-w-4xl mx-auto bg-white shadow-lg rounded-2xl p-6 flex flex-col gap-4 w-full max-h-[90vh] overflow-y-auto">
					<!-- Close Button -->
					<div class="flex justify-between items-center mb-2">
						<h2 class="text-xl font-bold text-gray-800">Hotel Booking Form</h2>
						<button onclick="closeBookingForm()" class="text-gray-500 hover:text-gray-700 text-2xl">&times;</button>
					</div>

					<!-- Room Type (readonly, comes from room selection) -->
					<div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mt-4">
						<div>
							<label class="text-sm font-medium text-gray-600">Room Type</label>
							<input type="text" id="booking-room-type" readonly
								class="w-full border rounded-lg py-2 text-sm outline-none bg-gray-100 cursor-not-allowed" />
						</div>
						<div>
							<label class="text-sm font-medium text-gray-600">Room Price</label>
							<input type="text" id="booking-room-price" readonly
								class="w-full border rounded-lg py-2 text-sm outline-none bg-gray-100 cursor-not-allowed" />
						</div>
					</div>

					<!-- Guest Info -->
					<div class="flex flex-col gap-3">
						<!-- Full Name -->
						<div>
							<label class="text-sm font-medium text-gray-600">Full Name</label>
							<input type="text" id="booking-full-name" placeholder="Enter your name"
								class="w-full border rounded-lg py-2 text-sm outline-none focus:border-blue-500" />
						</div>

						<!-- Email & Phone side by side -->
						<div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
							<div>
								<label class="text-sm font-medium text-gray-600">Email Address</label>
								<input type="email" id="booking-email" placeholder="you@example.com"
									class="w-full border rounded-lg py-2 text-sm outline-none focus:border-blue-500" />
							</div>
							<div>
								<label class="text-sm font-medium text-gray-600">Phone Number</label>
								<input type="tel" id="booking-phone" placeholder="+62 812 3456 7890"
									class="w-full border rounded-lg py-2 text-sm outline-none focus:border-blue-500" />
							</div>
						</div>
					</div>

					<!-- Dates -->
					<div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mt-4">
						<div>
							<label class="text-sm font-medium text-gray-600">Check-In</label>
							<input type="date" id="booking-checkin" readonly
								class="w-full border rounded-lg py-2 text-sm outline-none bg-gray-100 cursor-not-allowed" />
						</div>
						<div>
							<label class="text-sm font-medium text-gray-600">Check-Out</label>
							<input type="date" id="booking-checkout" readonly
								class="w-full border rounded-lg py-2 text-sm outline-none bg-gray-100 cursor-not-allowed" />
						</div>
					</div>

					<!-- Guests -->
					<div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mt-4">
						<div>
							<label class="text-sm font-medium text-gray-600">Adults</label>
							<input type="number" id="booking-adults" min="1" readonly
								class="w-full border rounded-lg py-2 text-sm outline-none bg-gray-100 cursor-not-allowed" />
						</div>
						<div>
							<label class="text-sm font-medium text-gray-600">Children</label>
							<input type="number" id="booking-children" min="0" readonly
								class="w-full border rounded-lg py-2 text-sm outline-none bg-gray-100 cursor-not-allowed" />
						</div>
					</div>

					<!-- Address -->
					<div class="mt-4 grid grid-cols-1 sm:grid-cols-2 gap-4">
						<div>
							<label class="text-sm font-medium text-gray-600">Country</label>
							<input type="text" id="booking-country" placeholder="Enter country"
								class="w-full border rounded-lg py-2 text-sm outline-none focus:border-blue-500" />
						</div>
						<div>
							<label class="text-sm font-medium text-gray-600">State</label>
							<input type="text" id="booking-state" placeholder="Enter state"
								class="w-full border rounded-lg py-2 text-sm outline-none focus:border-blue-500" />
						</div>
						<div>
							<label class="text-sm font-medium text-gray-600">City</label>
							<input type="text" id="booking-city" placeholder="Enter city"
								class="w-full border rounded-lg py-2 text-sm outline-none focus:border-blue-500" />
						</div>
						<div>
							<label class="text-sm font-medium text-gray-600">Post Code</label>
							<input type="text" id="booking-postcode" placeholder="Enter post code"
								class="w-full border rounded-lg py-2 text-sm outline-none focus:border-blue-500" />
						</div>
					</div>

					<!-- Submit -->
					<button onclick="submitBooking()"
						class="mt-6 bg-blue-600 hover:bg-blue-700 text-white font-semibold py-3 rounded-xl transition-all mb-4">
						Book Now
					</button>
				</div>
			</div>
		</div>

		<!-- Payment Modal -->
		<div id="payment-modal" class="fixed inset-0 bg-black bg-opacity-75 z-50 hidden">
			<div class="flex items-center justify-center min-h-screen p-2 md:p-4">
				<div
					class="max-w-6xl mx-auto bg-white shadow-lg rounded-2xl overflow-hidden w-full max-h-[98vh] overflow-y-auto">
					<!-- Header -->
					<div class="flex justify-between items-center p-4 border-b bg-gray-50 sticky top-0 z-10">
						<div>
							<h2 class="text-xl font-bold text-gray-800">Complete Your Payment</h2>
							<p class="text-sm text-gray-600">Booking Code: <span id="booking-code-display"
									class="font-mono font-semibold text-blue-600"></span></p>
						</div>
						<button onclick="closePaymentModal()"
							class="text-gray-500 hover:text-gray-700 text-2xl font-bold px-2">&times;</button>
					</div>

					<!-- Payment Iframe Container -->
					<div class="relative" style="height: 80vh; min-height: 600px;">
						<iframe id="payment-iframe" src="about:blank" class="w-full h-full border-0"
							style="height: 100%; min-height: 600px;" allow="payment" scrolling="yes" frameborder="0"
							sandbox="allow-same-origin allow-scripts allow-forms allow-top-navigation allow-popups allow-modals">
						</iframe>

						<!-- Loading Overlay -->
						<div id="payment-loading" class="absolute inset-0 bg-white flex items-center justify-center">
							<div class="text-center">
								<svg class="animate-spin h-12 w-12 text-blue-500 mx-auto mb-4"
									xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
									<circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4">
									</circle>
									<path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v4a4 4 0 00-4 4H4z"></path>
								</svg>
								<p class="text-gray-600">Loading payment gateway...</p>
							</div>
						</div>
					</div>

					<!-- Footer -->
					<div class="p-4 border-t bg-gray-50 text-center">
						<p class="text-xs text-gray-500">
							Secure payment powered by Midtrans. Your payment information is encrypted and secure.
						</p>
						<p class="text-xs text-gray-400 mt-1">
							💡 Tip: The payment form should be scrollable. If you have issues, try refreshing the page.
						</p>
					</div>
				</div>
			</div>
		</div>

		<script>
			// Hide loading overlay when iframe loads
			document.getElementById('payment-iframe').addEventListener('load', function() {
				const loadingOverlay = document.getElementById('payment-loading');
				if (this.src !== 'about:blank') {
					loadingOverlay.style.display = 'none';
				} else {
					loadingOverlay.style.display = 'flex';
				}
			});
		</script>
<?php
		return ob_get_clean();
	}
}
