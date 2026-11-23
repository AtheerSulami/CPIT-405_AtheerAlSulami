# CPIT 405 - Lab 9: Recipe Finder
Atheer AlSulami

## Run
npm install
npm start

## Build
npm run build

## Setup
Obtain a Spoonacular API key from your own account. Enter it in the app's password field. The key is held only in React state, never committed or saved to browser storage. Refreshing requires entering it again.

## Requirements
- Search: complexSearch endpoint, fetch on submit, useState.
- Details: /recipes/{id}/information endpoint, fetch inside useEffect.
- React Router links search results to recipe details.
- Displays images, ingredients and instructions.
- Loading, no-results, API authentication/quota and network errors.

Sources:
https://cpit405.gitlab.io/labs/lab-9/
https://spoonacular.com/food-api/docs

The course requests a public CodeSandbox share link. This GitHub copy includes a static build under site/.
Live recipe requests require your API key; no fake recipe data is included.
