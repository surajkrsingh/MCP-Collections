# Context7

Real-time documentation and code examples lookup for any programming library — powered by MCP.

## Overview

Context7 gives Claude access to up-to-date documentation for thousands of libraries and frameworks. Instead of relying on training data that may be outdated, Claude can fetch the latest docs and code snippets on the fly.

## Setup

### 1. Get an API key

Sign up at [Context7](https://context7.com/) to get an API key.

### 2. Set environment variable

```bash
export CONTEXT7_API_KEY="your-context7-api-key"
```

### 3. MCP config (already included in `.mcp.json`)

```json
{
  "context7": {
    "command": "node",
    "args": [
      "/path/to/mcp-remote/dist/proxy.js",
      "https://mcp.context7.com/mcp",
      "--header",
      "CONTEXT7_API_KEY: ${CONTEXT7_API_KEY}"
    ]
  }
}
```

## Tools

| Tool | Description |
|---|---|
| `resolve-library-id` | Search for a library and get its Context7-compatible ID |
| `query-docs` | Fetch documentation and code examples for a resolved library |

## Workflow

```
resolve-library-id ──> query-docs ──> accurate, current answer
```

> Always call `resolve-library-id` first. The returned library ID is required by `query-docs`.

## Examples

### Look up a library

**Prompt:**
```
How do I set up middleware in Express.js? Use context7
```

**Behind the scenes:**
```
1. mcp__context7__resolve-library-id(
     libraryName: "express",
     query: "set up middleware in Express.js"
   )
   → library ID: /expressjs/express

2. mcp__context7__query-docs(
     libraryId: "/expressjs/express",
     query: "How to set up middleware in Express.js"
   )
   → returns current docs with code examples
```

### Compare two libraries

**Prompt:**
```
Show me how form validation works in both Zod and Yup. Use context7
```

**Behind the scenes:**
```
1. resolve-library-id(libraryName: "zod", ...)
   → /colinhacks/zod

2. resolve-library-id(libraryName: "yup", ...)
   → /jquense/yup

3. query-docs(libraryId: "/colinhacks/zod", query: "form validation schema")

4. query-docs(libraryId: "/jquense/yup", query: "form validation schema")
```

### Get framework-specific code

**Prompt:**
```
How do I use server actions in Next.js 15? Use context7
```

**Behind the scenes:**
```
1. resolve-library-id(
     libraryName: "next.js",
     query: "server actions in Next.js 15"
   )
   → /vercel/next.js

2. query-docs(
     libraryId: "/vercel/next.js",
     query: "server actions usage and examples"
   )
   → returns latest Next.js docs with server action patterns
```

## How library resolution works

When you call `resolve-library-id`, Context7 returns matches ranked by:

- **Name similarity** — exact matches are prioritized
- **Description relevance** — how well the library matches your query
- **Code snippet count** — libraries with more examples rank higher
- **Source reputation** — High/Medium reputation sources are preferred
- **Benchmark score** — quality indicator (0–100)

Claude picks the best match automatically. If the query is ambiguous, it may ask you to clarify.

## Supported libraries

Context7 covers thousands of libraries across all major ecosystems:

- **JavaScript/TypeScript** — React, Next.js, Vue, Svelte, Express, etc.
- **Python** — Django, Flask, FastAPI, pandas, etc.
- **Rust, Go, Java, PHP** — and many more
- **CSS frameworks** — Tailwind, Bootstrap, etc.
- **Databases** — MongoDB, PostgreSQL, Supabase, Prisma, etc.

## Tips

- Add **"use context7"** to your prompt so Claude knows to look up docs.
- Be specific in your query — "React useEffect cleanup" works better than "hooks".
- Context7 returns code snippets, not just prose — great for copy-paste examples.
- You can combine Context7 with other MCPs (e.g., look up docs, then generate a Stitch screen based on what you learned).
- Maximum 3 calls per question to avoid rate limits — Claude manages this automatically.
