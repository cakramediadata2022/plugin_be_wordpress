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
							});
						});
					}
				}
			}
		</script>

		<div class="ckh-booking-engine-wrapper">
			<div class="ckh-container" x-data="initBookingEngine()" x-init="initDatePicker()">

				<div class="ckh-flex ckh-items-center ckh-border ckh-rounded-lg ckh-px-3 ckh-py-2 ckh-bg-white">
					<input type="text" placeholder="Find your Perfect Stay..." x-model="search"
						class="ckh-flex-1 ckh-outline-none ckh-text-gray-700 ckh-placeholder-gray-400" />
					<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"
						class="ckh-w-5 ckh-h-5 ckh-text-blue-500">
						<path stroke-linecap="round" stroke-linejoin="round"
							d="M21 21l-4.35-4.35m0 0A7.5 7.5 0 104.5 4.5a7.5 7.5 0 0012.15 12.15z" />
					</svg>
				</div>

				<div class="ckh-flex ckh-flex-col md:ckh-flex-row ckh-gap-3">
					<div class="ckh-flex-1 ckh-flex ckh-items-center ckh-gap-2 ckh-border ckh-rounded-lg ckh-px-3 ckh-py-2 ckh-bg-white ckh-cursor-pointer"
						@click="picker.show()">
						<input type="text" x-ref="dateRange" placeholder="Select date range"
							class="ckh-w-full ckh-text-sm ckh-outline-none ckh-cursor-pointer" readonly />
					</div>

					<div class="ckh-relative ckh-flex-1">
						<div class="ckh-flex ckh-items-center ckh-justify-between ckh-gap-2 ckh-border ckh-rounded-lg ckh-px-3 ckh-py-2 ckh-bg-white ckh-cursor-pointer"
							@click="guestsOpen = !guestsOpen">
							<div>
								<p class="ckh-text-sm ckh-font-medium ckh-text-gray-700 ckh-truncate" x-text="getGuestText()"></p>
								<p class="ckh-text-xs ckh-text-gray-400 ckh-truncate" x-text="getRoomText()"></p>
							</div>
							<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2"
								stroke="currentColor" class="ckh-w-5 ckh-h-5 ckh-text-gray-400">
								<path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
							</svg>
						</div>

						<div x-show="guestsOpen" @click.away="guestsOpen = false"
							class="ckh-absolute ckh-z-10 ckh-mt-2 ckh-w-full ckh-bg-white ckh-border ckh-rounded-lg ckh-shadow-lg ckh-p-4 ckh-space-y-3">
							<div class="ckh-flex ckh-items-center ckh-justify-between">
								<span>Adults</span>
								<div class="ckh-flex ckh-items-center ckh-gap-2">
									<button class="ckh-btn-secondary" @click="decreaseAdults()">-</button>
									<span x-text="adults"></span>
									<button class="ckh-btn-secondary" @click="increaseAdults()">+</button>
								</div>
							</div>

							<div class="ckh-flex ckh-items-center ckh-justify-between">
								<span>Children</span>
								<div class="ckh-flex ckh-items-center ckh-gap-2">
									<button class="ckh-btn-secondary" @click="decreaseChildren()">-</button>
									<span x-text="children"></span>
									<button class="ckh-btn-secondary" @click="increaseChildren()">+</button>
								</div>
							</div>

							<div class="ckh-flex ckh-items-center ckh-justify-between">
								<span>Rooms</span>
								<div class="ckh-flex ckh-items-center ckh-gap-2">
									<button class="ckh-btn-secondary" @click="decreaseRooms()">-</button>
									<span x-text="rooms"></span>
									<button class="ckh-btn-secondary" @click="increaseRooms()">+</button>
								</div>
							</div>

							<hr class="ckh-my-2 ckh-border-gray-200">

							<div class="ckh-flex ckh-items-center ckh-justify-between">
								<label class="ckh-flex ckh-items-center ckh-gap-2 ckh-cursor-pointer">
									<input type="checkbox" x-model="pets" class="ckh-w-4 ckh-h-4 ckh-text-blue-600 ckh-border-gray-300 ckh-rounded">
									<span>Pet friendly</span>
								</label>
							</div>
						</div>
					</div>
				</div>

				<button class="ckh-btn-primary ckh-w-full" @click="performSearch()">
					SEARCH
				</button>
			</div>
		</div>
<?php
		return ob_get_clean();
	}
}
