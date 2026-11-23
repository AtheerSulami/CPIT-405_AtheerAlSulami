# CPIT 405 - Lab 8
Atheer AlSulami

URL shortening, optional custom aliases, and an About page using React Router.

## Run
`npm install`
`npm start`

## Build
`npm run build`

Import this folder as a Vite React project in CodeSandbox. The lab specifies a public CodeSandbox share link for submission; GitHub source alone does not replace it.

## Course concepts
Function components, JSX, useState, controlled inputs, events, conditional rendering, React Router. Fetch and JSON use the JavaScript/AJAX topics on the course website.
HashRouter supports navigation on static hosting.
The app uses the is.gd API to create real redirects, including custom names. Internet access and service availability are required. No fake local-only shortened links are generated.

Sources:
- https://cpit405.gitlab.io/labs/lab-8/
- https://cpit405.gitlab.io/
- https://react.dev/learn (linked by the course)
- https://is.gd/apishorteningreference.php (service integration reference)

Validation: npm run build passed. Both automatic and custom link creation succeeded against the live is.gd API. Full browser interaction testing was not performed.

Static preview: ./site/index.html (built production files).
