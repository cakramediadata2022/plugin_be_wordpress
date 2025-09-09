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
		ob_start();
?>
		<link rel="stylesheet" href="<?php echo plugin_dir_url(__FILE__); ?>css/litepicker.css" />
		<link rel="stylesheet" href="<?php echo plugin_dir_url(__FILE__); ?>css/ckh-booking-engine-public.css" />
		<script src="<?php echo plugin_dir_url(__FILE__); ?>js/litepicker.js"></script>
		<script src="<?php echo plugin_dir_url(__FILE__); ?>js/alpine.min.js" defer></script>

		<script>
			function initBookingEngine() {
				return {
					picker: null,
					search: '',
					guestsOpen: false,
					adults: 2,
					children: 0,
					pets: false,
					rooms: 1,
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
					performSearch() {
						console.log('Search Data:', {
							search: this.search,
							dates: this.$refs.dateRange.value,
							adults: this.adults,
							children: this.children,
							pets: this.pets,
							rooms: this.rooms
						});
					},
					initDatePicker() {
						this.$nextTick(() => {
							this.picker = new Litepicker({
								element: this.$refs.dateRange,
								singleMode: false,
								numberOfMonths: window.innerWidth < 640 ? 1 : 2,
								numberOfColumns: window.innerWidth < 640 ? 1 : 2,
								minDate: new Date(),
								autoApply: false,
								format: 'YYYY-MM-DD',
								resetButton: true,
								mobileFriendly: true,
							});
						});
					}
				}
			}
		</script>

		<!-- CKH Booking Engine - Customizable with Admin Settings -->
		<div class="ckh-booking-engine-wrapper">
			<div class="ckh-be-container max-w-2xl w-full p-3 sm-p-4 md-p-5 lg-p-6 rounded-2xl shadow-md space-y-4"
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
							<div class="flex items-center justify-between">
								<span>Rooms</span>
								<div class="flex items-center gap-2">
									<button class="ckh-be-counter-btn px-2 py-1" @click="decreaseRooms()">-</button>
									<span x-text="rooms"></span>
									<button class="ckh-be-counter-btn px-2 py-1" @click="increaseRooms()">+</button>
								</div>
							</div>
						</div>
					</div>
				</div>

				<!-- Search Button -->
				<button class="ckh-be-button w-full cursor-pointer font-semibold py-2 shadow" @click="performSearch()">
					Book Now
				</button>
			</div>
		</div>
<?php
		return ob_get_clean();
	}
}
