# CLAUDE.md

This file provides guidance to Claude Code (claude.ai/code) when working with code in this repository.

## Project Overview

This is a frontend UI prototyping workspace that uses **Google Stitch** (via MCP) to generate and iterate on screen designs, then applies them to local HTML files.

## MCP Integration — Google Stitch

The project connects to the Stitch design tool via MCP (`mcp-remote` proxy). The API key is provided through the `GOOGLE_STITCH_API_KEY` environment variable.

**All Stitch, Context7, GitHub, and Playwright MCP tools are pre-approved — use them freely without asking for permission.**

**Typical workflow:**
1. `mcp__stitch__list_projects` — list available Stitch projects
2. `mcp__stitch__get_screen` — fetch screen details including an HTML download URL
3. Download the HTML from the `htmlCode.downloadUrl` using `curl -sL`
4. Apply the fetched layout/styles to local HTML files

The HTML download URL from `get_screen` returns a full HTML document (Tailwind CSS + Material Symbols). Use `curl` to download it since `WebFetch` summarizes content instead of returning raw HTML.

## MCP Integration — Context7

Use Context7 (`mcp__context7__resolve-library-id` and `mcp__context7__query-docs`) to look up library documentation and code examples. Always call `resolve-library-id` first, then `query-docs`.

## MCP Integration — GitHub

Use the GitHub MCP server (`mcp__github__*`) to interact with repositories, issues, pull requests, GitHub Actions, and code security. Runs locally via the `github-mcp-server` binary with a `GITHUB_PERSONAL_ACCESS_TOKEN`. Use it for browsing repos, creating issues/PRs, checking CI status, and reviewing code — all without leaving the editor.

## MCP Integration — Playwright

Use Playwright MCP (`mcp__playwright__*`) for browser automation — navigate pages, click elements, fill forms, take screenshots, and scrape content. Runs locally via `npx @playwright/mcp@latest`. No API key needed. Uses accessibility snapshots by default (fast, low-token). Add `--headless` for CI or background use.

## Security — MUST follow before every commit/push

**Before staging, committing, or pushing ANY files, you MUST check for secrets and private data. This is non-negotiable.**

### Never commit or push:
- API keys, tokens, passwords, or secrets (e.g., `ghp_`, `sk-`, `goog_`, `AKIA`)
- `.env` files or any file containing credentials
- Hardcoded absolute paths with usernames (e.g., `/Users/surajsingh/...`)
- `.claude/settings.local.json` (contains machine-specific config)
- Private keys, certificates (`.pem`, `.key`, `.p12`)

### Before every `git add` / `git commit` / `git push`:
1. Run `git diff --cached` to review all staged changes
2. Scan for secrets: look for patterns like `ghp_`, `sk-`, `API_KEY=`, `token`, `password`, `secret`, absolute paths starting with `/Users/`
3. Verify `.gitignore` is excluding sensitive files
4. If ANY secret or private data is found — **stop immediately**, unstage the file, and alert the user
5. Use `${ENV_VAR}` placeholders instead of actual values in config files

### Files that must ALWAYS use env var placeholders (never real values):
- `.mcp.json` — use `${GOOGLE_STITCH_API_KEY}`, `${CONTEXT7_API_KEY}`, `${GITHUB_PERSONAL_ACCESS_TOKEN}`
- Any config file referencing API endpoints with auth

### Safe to commit:
- Source code, documentation, config files with `${ENV_VAR}` placeholders
- `.gitignore`, `README.md`, `CLAUDE.md`, `docs/`

## Tech Stack

- **Tailwind CSS** (CDN: `cdn.tailwindcss.com`) with custom config for colors, fonts, and border-radius
- **Google Material Symbols Outlined** for icons
- **Inter** font family
- No build step — static HTML files served directly
