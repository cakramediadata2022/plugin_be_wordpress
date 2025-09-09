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
				siteUrl: '<?php echo esc_js(get_site_url()); ?>'
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
                                    <button class="w-full bg-blue-500 text-white px-4 py-2 rounded-lg hover:bg-blue-600 transition-colors" ${!cheapestRate ? 'disabled' : ''}>
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
<?php
		return ob_get_clean();
	}
}
