# Playwright

Microsoft's official MCP server for browser automation — navigate pages, fill forms, click elements, take screenshots, and more.

## Overview

Playwright MCP lets Claude control a browser through structured accessibility snapshots (not screenshots). It's fast, lightweight, and doesn't require vision models. Use it for web scraping, testing, form automation, and exploratory browser workflows.

**Repo:** [microsoft/playwright-mcp](https://github.com/microsoft/playwright-mcp) (27k+ stars)

## Prerequisites

- [Node.js](https://nodejs.org/) v18+

That's it. No API keys needed — Playwright MCP runs entirely locally.

## Setup

### 1. MCP config (already included in `.mcp.json`)

```json
{
  "playwright": {
    "command": "npx",
    "args": ["@playwright/mcp@latest"]
  }
}
```

First run will auto-download the Playwright package and browser binaries.

### 2. Verify it works

Restart Claude Code, then ask:

```
> Navigate to https://example.com and tell me what's on the page
```

Claude should open a browser, navigate, and describe the page content.

## Configuration

### Headless mode (no visible browser)

```json
{
  "playwright": {
    "command": "npx",
    "args": ["@playwright/mcp@latest", "--headless"]
  }
}
```

### Choose a browser

```json
{
  "playwright": {
    "command": "npx",
    "args": ["@playwright/mcp@latest", "--browser", "firefox"]
  }
}
```

Supported: `chrome`, `firefox`, `webkit`, `msedge`

### Device emulation

```json
{
  "playwright": {
    "command": "npx",
    "args": ["@playwright/mcp@latest", "--device", "iPhone 15"]
  }
}
```

### Custom viewport

```json
{
  "playwright": {
    "command": "npx",
    "args": ["@playwright/mcp@latest", "--viewport-size", "1280x720"]
  }
}
```

### Vision mode (screenshot-based interactions)

```json
{
  "playwright": {
    "command": "npx",
    "args": ["@playwright/mcp@latest", "--caps", "vision"]
  }
}
```

## CLI Flags

| Flag | Purpose | Default |
|---|---|---|
| `--headless` | Run without visible browser | off (headed) |
| `--browser` | Browser engine: chrome, firefox, webkit, msedge | chrome |
| `--device` | Emulate a device (e.g., "iPhone 15") | — |
| `--viewport-size` | Set viewport (e.g., "1280x720") | browser default |
| `--caps` | Enable capabilities: vision, pdf, devtools | — |
| `--isolated` | Fresh profile per session | off |
| `--user-data-dir` | Persistent profile location | auto |
| `--storage-state` | Load cookies/storage from file | — |
| `--proxy-server` | Route through proxy | — |
| `--ignore-https-errors` | Bypass SSL validation | off |
| `--timeout-action` | Action timeout in ms | 5000 |
| `--timeout-navigation` | Navigation timeout in ms | 60000 |
| `--save-trace` | Save Playwright trace for debugging | off |
| `--save-video` | Record session video (e.g., "800x600") | off |
| `--codegen` | Generate code: typescript, none | — |
| `--no-sandbox` | Disable sandbox (Docker/CI) | off |

## Tools

### Navigation

| Tool | Description |
|---|---|
| `browser_navigate` | Navigate to a URL |
| `browser_go_back` | Go back in history |
| `browser_go_forward` | Go forward in history |
| `browser_reload` | Reload the page |
| `browser_wait` | Wait for a specified time |

### Interaction

| Tool | Description |
|---|---|
| `browser_click` | Click an element |
| `browser_type` | Type text into an input field |
| `browser_fill` | Fill a form field |
| `browser_select_option` | Select from a dropdown |
| `browser_check` | Check/uncheck a checkbox |
| `browser_press_key` | Press a keyboard key |
| `browser_hover` | Hover over an element |
| `browser_drag` | Drag an element |

### Content

| Tool | Description |
|---|---|
| `browser_snapshot` | Get accessibility snapshot of the page |
| `browser_screenshot` | Take a screenshot |
| `browser_pdf` | Generate PDF of the page |
| `browser_get_text` | Get text content of an element |
| `browser_get_attribute` | Get an attribute of an element |

### Tabs

| Tool | Description |
|---|---|
| `browser_tab_new` | Open a new tab |
| `browser_tab_select` | Switch to a tab |
| `browser_tab_close` | Close a tab |
| `browser_tab_list` | List all open tabs |

### Network & Console

| Tool | Description |
|---|---|
| `browser_network_requests` | List network requests |
| `browser_console_messages` | Get console messages |

### Utilities

| Tool | Description |
|---|---|
| `browser_evaluate` | Execute JavaScript in the page |
| `browser_file_upload` | Upload a file to an input |

## Examples

### Navigate and read a page

**Prompt:**
```
Go to https://news.ycombinator.com and tell me the top 5 stories
```

### Fill out a form

**Prompt:**
```
Navigate to the contact page on my site at localhost:3000/contact,
fill in the name field with "John" and email with "john@example.com",
then submit the form
```

### Test a web app

**Prompt:**
```
Open localhost:8080, log in with the test credentials,
navigate to the settings page, and verify the dark mode toggle works
```

### Scrape data

**Prompt:**
```
Go to https://example.com/products, take a snapshot of the page,
and list all product names and prices
```

### Take a screenshot

**Prompt:**
```
Navigate to my site at localhost:3000 and take a screenshot
```

### Mobile testing

With device emulation configured:

**Prompt:**
```
Open my site on an iPhone 15 emulator and check if the
navigation menu is responsive
```

## Session Persistence

By default, Playwright MCP uses a persistent browser profile (cookies, localStorage, etc. are kept between sessions).

**Profile locations:**
- macOS: `~/Library/Caches/ms-playwright/mcp-chrome-profile`
- Linux: `~/.cache/ms-playwright/mcp-chrome-profile`
- Windows: `%USERPROFILE%\AppData\Local\ms-playwright\mcp-chrome-profile`

Use `--isolated` for a clean session every time, or `--storage-state path/to/state.json` to load specific cookies.

## Tips

- No API key needed — Playwright runs entirely on your machine.
- First run downloads browser binaries (~200MB), which takes a moment.
- Use `--headless` for CI/CD or when you don't need to see the browser.
- Accessibility snapshots are faster and cheaper (fewer tokens) than screenshots.
- Use `--save-trace` to debug complex automation workflows.
- Works great with other MCPs — e.g., use Context7 to look up a library's docs, then Playwright to test your implementation.

## References

- [microsoft/playwright-mcp](https://github.com/microsoft/playwright-mcp)
- [Playwright docs](https://playwright.dev/)
