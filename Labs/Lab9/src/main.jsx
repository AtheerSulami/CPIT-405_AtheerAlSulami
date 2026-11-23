import React, { useState, useEffect } from "react";
import { createRoot } from "react-dom/client";
import { HashRouter, Routes, Route, Link, useParams } from "react-router-dom";
import "./style.css";

async function getRecipes(path, apiKey) {
    const response = await fetch("https://api.spoonacular.com/recipes/" + path, {
        headers: { "x-api-key": apiKey }
    });
    if (!response.ok) {
        if (response.status === 401 || response.status === 403) {
            throw new Error("The API key is invalid or access is denied.");
        }
        if (response.status === 402 || response.status === 429) {
            throw new Error("API quota or rate limit reached. Please try again later.");
        }
        throw new Error("Unable to load recipes. Please try again.");
    }
    return response.json();
}

function Search({ apiKey }) {
    const [query, setQuery] = useState("");
    const [recipes, setRecipes] = useState([]);
    const [loading, setLoading] = useState(false);
    const [error, setError] = useState("");
    const [searched, setSearched] = useState(false);

    // fetch in response to a submit event.
    async function search(event) {
        event.preventDefault();
        if (!query.trim()) {
            setError("Enter a recipe name.");
            return;
        }
        setLoading(true);
        setError("");
        setRecipes([]);
        setSearched(false);
        try {
            const data = await getRecipes(
                "complexSearch?number=12&query=" + encodeURIComponent(query.trim()), apiKey);
            setRecipes(data.results || []);
            setSearched(true);
        } catch (error) {
            setError(error.message);
        }
        setLoading(false);
    }

    return <section>
        <h1>Find your next recipe</h1>
        <p>Search for a dish, then open its ingredients and instructions.</p>
        <form onSubmit={search}>
            <label htmlFor="query">Recipe name</label>
            <div className="search-bar">
                <input id="query" required value={query} placeholder="Try pasta"
                    onChange={event => setQuery(event.target.value)} disabled={loading} />
                <button disabled={loading}>{loading ? "Searching..." : "Search"}</button>
            </div>
        </form>
        {error && <p className="error" role="alert">{error}</p>}
        {searched && recipes.length === 0 && <p role="status">No recipes found. Try another name.</p>}
        <div className="cards">
            {recipes.map(recipe => <article key={recipe.id}>
                {recipe.image && <img src={recipe.image} alt={recipe.title} />}
                <h2>{recipe.title}</h2>
                <Link to={"/recipe/" + recipe.id}>View recipe</Link>
            </article>)}
        </div>
    </section>;
}

function RecipeDetails({ apiKey }) {
    const { id } = useParams();
    const [recipe, setRecipe] = useState(null);
    const [error, setError] = useState("");
    const [loading, setLoading] = useState(true);

    // fetch when the details component loads or the recipe ID changes.
    useEffect(() => {
        let active = true;
        setLoading(true);
        setRecipe(null);
        setError("");
        async function loadRecipe() {
            try {
                const data = await getRecipes(encodeURIComponent(id) + "/information", apiKey);
                if (active) setRecipe(data);
            } catch (error) {
                if (active) setError(error.message);
            }
            if (active) setLoading(false);
        }
        loadRecipe();
        return () => { active = false; };
    }, [id, apiKey]);

    return <section>
        <Link to="/">Back to search</Link>
        {loading && <p role="status">Loading recipe...</p>}
        {error && <p className="error" role="alert">{error}</p>}
        {recipe && <div>
            <h1>{recipe.title}</h1>
            {recipe.image && <img className="recipe-image" src={recipe.image} alt={recipe.title} />}
            <p>Ready in {recipe.readyInMinutes} minutes · Servings: {recipe.servings}</p>
            <h2>Ingredients</h2>
            {recipe.extendedIngredients && recipe.extendedIngredients.length > 0 ?
                <ul>{recipe.extendedIngredients.map((ingredient, index) =>
                    <li key={index}>{ingredient.original}</li>)}</ul> :
                <p>No ingredients provided.</p>}
            <h2>Instructions</h2>
            {recipe.analyzedInstructions && recipe.analyzedInstructions.some(group => group.steps.length > 0) ?
                recipe.analyzedInstructions.map((group, index) => <div key={index}>
                    {group.name && <h3>{group.name}</h3>}
                    <ol>{group.steps.map(step => <li key={step.number}>{step.step}</li>)}</ol>
                </div>) :
                <p>{recipe.instructions ? recipe.instructions.replace(/<[^>]*>/g, " ") :
                    "No instructions provided for this recipe."}</p>}
            {recipe.sourceUrl && recipe.sourceUrl.startsWith("https://") &&
                <a href={recipe.sourceUrl} target="_blank" rel="noreferrer">Original recipe source</a>}
        </div>}
    </section>;
}

function App() {
    const [keyInput, setKeyInput] = useState("");
    const [apiKey, setApiKey] = useState("");
    function connect(event) {
        event.preventDefault();
        setApiKey(keyInput.trim());
        setKeyInput("");
    }
    return <HashRouter>
        <header><strong>Recipe Finder</strong><Link to="/">Home</Link></header>
        <main>
            {!apiKey ? <section>
                <h1>Connect to Spoonacular</h1>
                <p>Enter your Spoonacular API key to search for recipes.</p>
                <form onSubmit={connect}>
                    <label htmlFor="api-key">API key</label>
                    <input id="api-key" type="password" required value={keyInput}
                        autoComplete="off" onChange={event => setKeyInput(event.target.value)} />
                    <button>Continue</button>
                </form>
                <p>The key stays in memory until this page is refreshed and is sent only to Spoonacular.</p>
                <a href="https://spoonacular.com/food-api/console#Profile" target="_blank" rel="noreferrer">Get your API key</a>
            </section> : <div>
                <button className="secondary" onClick={() => setApiKey("")}>Change API key</button>
                <Routes>
                    <Route path="/" element={<Search apiKey={apiKey} />} />
                    <Route path="/recipe/:id" element={<RecipeDetails apiKey={apiKey} />} />
                    <Route path="*" element={<section><h1>Page not found</h1><Link to="/">Home</Link></section>} />
                </Routes>
            </div>}
        </main>
        <footer>CPIT 405 · Lab 9 · Atheer AlSulami · Recipe data from Spoonacular</footer>
    </HashRouter>;
}
createRoot(document.getElementById("root")).render(<App />);
