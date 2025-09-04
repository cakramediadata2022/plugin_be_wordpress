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
		<!-- Alpine.js -->
		<script src="<?php echo plugin_dir_url(__FILE__); ?>js/alpine.min.js" defer></script>
		<!-- Litepicker -->
		<link rel="stylesheet" href="<?php echo plugin_dir_url(__FILE__); ?>css/litepicker.css" />
		<script src="<?php echo plugin_dir_url(__FILE__); ?>js/litepicker.js"></script>

		<div class="max-w-2xl w-full bg-gray-50 p-6 rounded-2xl shadow-md space-y-4" x-data="{
								 picker: null,
								 search: '',
								 guestsOpen: false,
								 adults: 2,
								 children: 0,
								 pets: false,
								 rooms: 1
								}" x-init="
									picker = new Litepicker({
										element: $refs.dateRange,
										singleMode: false,
										numberOfMonths: window.innerWidth < 640 ? 1 : 2,
										numberOfColumns: window.innerWidth < 640 ? 1 : 2,
										minDate: new Date(),
										autoApply: false,
										format: 'YYYY-MM-DD',
										resetButton: true,
									});
								">
			<!-- Search Input -->
			<div class="flex items-center border rounded-lg px-3 py-2 bg-white">
				<input type="text" placeholder="Find your Perfect Stay..." x-model="search"
					class="flex-1 outline-none text-gray-700 placeholder-gray-400" />
				<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"
					class="w-5 h-5 text-blue-500">
					<path stroke-linecap="round" stroke-linejoin="round"
						d="M21 21l-4.35-4.35m0 0A7.5 7.5 0 104.5 4.5a7.5 7.5 0 0012.15 12.15z" />
				</svg>
			</div>

			<!-- Date + Guests in one row -->
			<div class="flex flex-col md:flex-row gap-3">
				<!-- Date Range Picker -->
				<div class="flex-1 flex items-center gap-2 border rounded-lg px-3 py-2 bg-white cursor-pointer"
					@click="picker.show()">
					<input type="text" x-ref="dateRange" placeholder="Select date range"
						class="w-full text-sm outline-none cursor-pointer" readonly />
				</div>

				<!-- Guests Dropdown -->
				<div class="relative flex-1">
					<div class="flex items-center justify-between gap-2 border rounded-lg px-3 py-2 bg-white cursor-pointer"
						@click="guestsOpen = !guestsOpen">
						<div>
							<p class="text-sm font-medium text-gray-700 truncate"
								x-text="`${adults} adult, ${children} children` + (pets ? ', Pet friendly' : '')"></p>
							<p class="text-xs text-gray-400 truncate" x-text="`${rooms} room`"></p>
						</div>
						<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2"
							stroke="currentColor" class="w-5 h-5 text-gray-400">
							<path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
						</svg>
					</div>

					<!-- Dropdown Panel -->
					<div x-show="guestsOpen" @click.away="guestsOpen = false"
						class="absolute z-10 mt-2 w-full bg-white border rounded-lg shadow-lg p-4 space-y-3">
						<!-- Adults -->
						<div class="flex items-center justify-between">
							<span>Adults</span>
							<div class="flex items-center gap-2">
								<button class="px-2 py-1 border rounded" @click="if(adults>1) adults--">-</button>
								<span x-text="adults"></span>
								<button class="px-2 py-1 border rounded" @click="adults++">+</button>
							</div>
						</div>

						<!-- Children -->
						<div class="flex items-center justify-between">
							<span>Children</span>
							<div class="flex items-center gap-2">
								<button class="px-2 py-1 border rounded" @click="if(children>0) children--">-</button>
								<span x-text="children"></span>
								<button class="px-2 py-1 border rounded" @click="children++">+</button>
							</div>
						</div>

						<!-- Rooms -->
						<div class="flex items-center justify-between">
							<span>Rooms</span>
							<div class="flex items-center gap-2">
								<button class="px-2 py-1 border rounded" @click="if(rooms>1) rooms--">-</button>
								<span x-text="rooms"></span>
								<button class="px-2 py-1 border rounded" @click="rooms++">+</button>
							</div>
						</div>

						<!-- Separator -->
						<hr class="my-2 border-gray-200">

						<!-- Pets as Checkbox -->
						<div class="flex items-center justify-between">
							<label class="flex items-center gap-2 cursor-pointer">
								<input type="checkbox" x-model="pets" class="w-4 h-4 text-blue-600 border-gray-300 rounded">
								<span>Pet friendly</span>
							</label>
						</div>
					</div>
				</div>
			</div>

			<!-- Search Button -->
			<button class="w-full bg-blue-500 text-white font-semibold py-2 rounded-lg shadow hover:bg-blue-600"
				@click="alert(`Searching: ${search}, Dates: ${$refs.dateRange.value}, ${adults} adult, ${children} children, ${pets} pets, ${rooms} rooms`)">
				SEARCH
			</button>
		</div>
<?php
		return ob_get_clean();
	}
}
