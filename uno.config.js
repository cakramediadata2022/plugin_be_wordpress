import { defineConfig, presetUno, presetAttributify } from 'unocss'

export default defineConfig({
    // Use presets
    presets: [
        presetUno(),
    ],

    // Custom shortcuts for common patterns - these will be prefixed
    shortcuts: {
        'ckh-container': 'max-w-2xl w-full bg-gray-50 p-6 rounded-2xl shadow-md space-y-4',
        'ckh-btn-primary': 'bg-blue-500 text-white px-4 py-2 rounded-lg font-semibold shadow hover:bg-blue-600 transition-colors w-full',
        'ckh-btn-secondary': 'bg-gray-200 text-gray-800 px-3 py-1 rounded border hover:bg-gray-300',
        'ckh-input': 'w-full px-3 py-2 border rounded-lg outline-none focus:ring-2 focus:ring-blue-500',
        'ckh-card': 'bg-white rounded-lg shadow-md border',
        // Individual utilities with ckh prefix
        'ckh-flex': 'flex',
        'ckh-items-center': 'items-center',
        'ckh-justify-between': 'justify-between',
        'ckh-gap-2': 'gap-2',
        'ckh-gap-3': 'gap-3',
        'ckh-border': 'border',
        'ckh-rounded-lg': 'rounded-lg',
        'ckh-px-3': 'px-3',
        'ckh-py-2': 'py-2',
        'ckh-bg-white': 'bg-white',
        'ckh-cursor-pointer': 'cursor-pointer',
        'ckh-flex-1': 'flex-1',
        'ckh-outline-none': 'outline-none',
        'ckh-text-gray-700': 'text-gray-700',
        'ckh-placeholder-gray-400': 'placeholder-gray-400',
        'ckh-w-5': 'w-5',
        'ckh-h-5': 'h-5',
        'ckh-text-blue-500': 'text-blue-500',
        'ckh-flex-col': 'flex-col',
        'ckh-relative': 'relative',
        'ckh-w-full': 'w-full',
        'ckh-text-sm': 'text-sm',
        'ckh-font-medium': 'font-medium',
        'ckh-truncate': 'truncate',
        'ckh-text-xs': 'text-xs',
        'ckh-text-gray-400': 'text-gray-400',
        'ckh-absolute': 'absolute',
        'ckh-z-10': 'z-10',
        'ckh-mt-2': 'mt-2',
        'ckh-shadow-lg': 'shadow-lg',
        'ckh-p-4': 'p-4',
        'ckh-space-y-3': 'space-y-3',
        'ckh-my-2': 'my-2',
        'ckh-border-gray-200': 'border-gray-200',
        'ckh-w-4': 'w-4',
        'ckh-h-4': 'h-4',
        'ckh-text-blue-600': 'text-blue-600',
        'ckh-border-gray-300': 'border-gray-300',
        'ckh-rounded': 'rounded',
        // Responsive
        'md:ckh-flex-row': 'md:flex-row',
    },

    // Scan these files for classes
    content: {
        filesystem: [
            'ckh-booking-engine/**/*.php',
            'src/**/*.{html,js,ts,jsx,tsx,vue,svelte}'
        ]
    },

    // Add CSS reset scoped to our plugin
    preflights: [
        {
            getCSS: () => `
        .ckh-booking-engine-wrapper {
          /* Reset any WordPress styles */
          all: initial;
          font-family: ui-sans-serif, system-ui, -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, "Noto Sans", sans-serif;
          box-sizing: border-box;
        }
        
        .ckh-booking-engine-wrapper *,
        .ckh-booking-engine-wrapper *::before,
        .ckh-booking-engine-wrapper *::after {
          box-sizing: border-box;
          margin: 0;
          padding: 0;
        }
        
        .ckh-booking-engine-wrapper button {
          background: none !important;
          border: none !important;
          padding: 0 !important;
          margin: 0 !important;
          font: inherit !important;
          color: inherit !important;
          text-decoration: none !important;
          cursor: pointer !important;
        }
        
        .ckh-booking-engine-wrapper input {
          background: none !important;
          border: none !important;
          padding: 0 !important;
          margin: 0 !important;
          font: inherit !important;
          color: inherit !important;
          outline: none !important;
        }
      `
        }
    ]
})