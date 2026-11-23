import React, { useState } from "react";
import { createRoot } from "react-dom/client";
import { HashRouter, Routes, Route, Link } from "react-router-dom";
import "./style.css";

function Home() {
    const [url, setUrl] = useState("");
    const [alias, setAlias] = useState("");
    const [shortUrl, setShortUrl] = useState("");
    const [error, setError] = useState("");
    const [loading, setLoading] = useState(false);

    async function shorten(event) {
        event.preventDefault();
        setShortUrl("");
        setError("");
        const address = url.trim();
        if (!address.startsWith("https://") && !address.startsWith("http://")) {
            setError("Enter a complete URL starting with https:// or http://.");
            return;
        }
        setLoading(true);
        // The external service stores the redirect so the result is shareable.
        let endpoint = "https://is.gd/create.php?format=json&url=" +
            encodeURIComponent(address);
        if (alias.trim() !== "") {
            endpoint += "&shorturl=" + encodeURIComponent(alias.trim());
        }
        try {
            const response = await fetch(endpoint);
            const data = await response.json();
            if (data.shorturl && data.shorturl.startsWith("https://is.gd/")) {
                setShortUrl(data.shorturl);
            } else {
                setError(data.errormessage || "The service could not shorten this URL.");
            }
        } catch (error) {
            setError("Could not reach the shortening service. Check your connection and try again.");
        }
        setLoading(false);
    }

    return <section>
        <h1>Link Shrinker</h1>
        <p>Turn a long URL into a short, shareable link.</p>
        <form onSubmit={shorten}>
            <label htmlFor="url">Long URL</label>
            <input id="url" type="url" required value={url}
                placeholder="https://example.com/a-long-page-address"
                onChange={event => setUrl(event.target.value)} disabled={loading} />
            <label htmlFor="alias">Custom name (optional)</label>
            <input id="alias" value={alias} minLength="5" maxLength="30"
                pattern="[A-Za-z0-9_]{5,30}" placeholder="my_custom_link"
                onChange={event => setAlias(event.target.value)} disabled={loading} />
            <small>Use 5–30 letters, numbers or underscores. The name must be available.</small>
            <p className="notice">The URL is sent to is.gd to create your short link.</p>
            <button disabled={loading}>{loading ? "Shortening..." : "Shorten URL"}</button>
        </form>
        {error && <p role="alert" className="error">{error}</p>}
        {shortUrl && <div className="result" role="status">
            <h2>Your short link</h2>
            <a href={shortUrl} target="_blank" rel="noreferrer">{shortUrl}</a>
            <p>You can copy and share this link.</p>
        </div>}
    </section>;
}

function About() {
    return <section>
        <h1>About us</h1>
        <p>Link Shrinker is a CPIT 405 Lab 8 application by Atheer AlSulami.</p>
        <p>Enter a long URL to create a short link, or choose an available custom name.</p>
        <p>This application uses React components, useState, event handling and React Router.
        The is.gd service creates and stores the shortened links.</p>
        <Link to="/">Back to Home</Link>
    </section>;
}

function App() {
    return <HashRouter>
        <header><strong>Link Shrinker</strong><nav>
            <Link to="/">Home</Link><Link to="/about">About us</Link>
        </nav></header>
        <main><Routes>
            <Route path="/" element={<Home />} />
            <Route path="/about" element={<About />} />
            <Route path="*" element={<section><h1>Page not found</h1><Link to="/">Home</Link></section>} />
        </Routes></main>
    </HashRouter>;
}

createRoot(document.getElementById("root")).render(<App />);
