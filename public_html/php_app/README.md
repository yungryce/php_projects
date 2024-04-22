npm init -y
npm i -D tailwindcss
npx tailwindcss init -p

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