npm init -y
npm i -D tailwindcss
npx tailwindcss init

EDIT:
tailwind.config.js: 
        content: ['./*.html']
package.json:
        "scripts": {
        "build": "tailwindcss -i ./input.css -o ./css/main.css",
        "watch": "tailwindcss -i ./input.css -o ./css/main.css --watch"
        }
npm run watch



#db test


colors: {
 'text': '#d5d0e2',
 'background': '#2a2438',
 'primary': '#00bcf0',
 'secondary': '#b64120',
 'accent': '#bf8e8e',
},
font-poppins, alegreya, baloo 2
realtimecolors.com