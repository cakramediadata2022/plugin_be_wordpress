import { defineConfig, presetWind3, presetAttributify } from 'unocss'

export default defineConfig({
  // Use presets
  presets: [
    presetWind3(),
    presetAttributify(),
  ],

  // Scan these files for classes
  content: {
    filesystem: [
      'ckh-booking-engine/**/*.php',
      'src/**/*.{html,js,ts,jsx,tsx,vue,svelte}'
    ]
  }
})