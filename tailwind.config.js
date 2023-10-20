/** @type {import('tailwindcss').Config} */
export default {
  content: [
      "./resources/**/**/*.blade.php",
      "./resources/**/**/*.js",
      "./app/View/Components/**/**/*.php",
      "./app/Livewire/**/**/*.php",
      "./node_modules/flowbite/**/*.js"
  ],
    daisyui: {
        themes: [ "night"],
    },
  theme: {

    extend: {},
  },
    plugins: [
        require('flowbite/plugin'),
        require("daisyui")
    ],
}

