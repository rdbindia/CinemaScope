/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './index.html',               // Include your main HTML file
        './src/**/*.{vue,js,ts,jsx,tsx}', // Include all files in the src folder with these extensions
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
        './resources/js/**/*.vue',
    ],
  theme: {
    extend: {},
  },
  plugins: [],
}

