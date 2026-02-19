# MCP Collections

A curated collection of [MCP](https://modelcontextprotocol.io/) (Model Context Protocol) server integrations for Claude Code. Each MCP server adds external capabilities — from AI-powered UI design to live documentation lookup — that Claude can use directly in your editor.

## Included MCPs

| MCP | What it does | Docs |
|---|---|---|
| **Google Stitch** | Generate, edit, and iterate on UI designs from text prompts | [docs/google-stitch.md](docs/google-stitch.md) |
| **Context7** | Look up current documentation and code examples for any library | [docs/context7.md](docs/context7.md) |
| **GitHub** | Interact with repos, issues, PRs, actions, and code security | [docs/github.md](docs/github.md) |

> More MCPs will be added over time. See [Adding a new MCP](#adding-a-new-mcp) below.

## Quick Start

### Prerequisites

- [Node.js](https://nodejs.org/) v22+
- [`mcp-remote`](https://www.npmjs.com/package/mcp-remote) — `npm install -g mcp-remote`
- [`github-mcp-server`](https://github.com/github/github-mcp-server/releases) binary — see [install steps](docs/github.md#1-install-the-binary)
- [Claude Code](https://docs.anthropic.com/en/docs/claude-code) CLI

### 1. Clone and enter the project

```bash
git clone <repo-url> MCP-Collections
cd MCP-Collections
```

### 2. Set your API keys

Add these to your shell profile (`~/.zshrc` or `~/.bashrc`):

```bash
export GOOGLE_STITCH_API_KEY="your-key"
export CONTEXT7_API_KEY="your-key"
export GITHUB_PERSONAL_ACCESS_TOKEN="ghp_your-token"
```

```bash
source ~/.zshrc
```

### 3. Launch

```bash
claude
```

That's it. Claude picks up the MCP servers from `.mcp.json` and the pre-approved permissions from `.claude/settings.local.json` automatically. No permission prompts.

## Project Structure

```
MCP-Collections/
├── .mcp.json                  # MCP server connections
├── .claude/
│   └── settings.local.json    # Pre-approved tool permissions
├── CLAUDE.md                  # Instructions for Claude Code
├── docs/
│   ├── google-stitch.md       # Stitch setup, tools, and examples
│   ├── context7.md            # Context7 setup, tools, and examples
│   └── github.md              # GitHub MCP setup, tools, and examples
└── README.md
```

| File | Purpose |
|---|---|
| `.mcp.json` | Defines which MCP servers to connect to and how to authenticate |
| `.claude/settings.local.json` | Pre-approves MCP tool calls so Claude doesn't ask every time |
| `CLAUDE.md` | Tells Claude how and when to use each MCP |
| `docs/` | Detailed documentation for each individual MCP |

## Usage at a Glance

### Design a UI with Stitch

```
> Create a Stitch project called "Dashboard" and generate a login screen
```

Claude creates the project, generates the screen, downloads the HTML, and saves it locally. See [full Stitch docs](docs/google-stitch.md) for all tools and examples.

### Look up library docs with Context7

```
> How do I use server actions in Next.js? Use context7
```

Claude fetches the latest docs and gives you an accurate answer with working code. See [full Context7 docs](docs/context7.md) for details.

### Manage GitHub repos, issues, and PRs

```
> Show me open issues labeled "bug" on my-org/my-repo and summarize them
```

Claude queries GitHub directly and returns structured results. See [full GitHub docs](docs/github.md) for all tools and examples.

### Combine MCPs

```
> Look up Tailwind grid docs with context7, then create a Stitch pricing page using a 3-column grid
```

Claude queries Context7 first, then uses that knowledge to craft a better Stitch prompt.

## Adding a New MCP

Four files to update:

**1. `.mcp.json`** — register the server

```json
"your-server": {
  "command": "npx",
  "args": [
    "mcp-remote",
    "https://your-endpoint.com/mcp",
    "--header",
    "Authorization: Bearer ${YOUR_API_KEY}"
  ]
}
```

**2. Environment** — add the API key

```bash
export YOUR_API_KEY="your-key"
```

**3. `.claude/settings.local.json`** — pre-approve the tools

```json
"mcp__your_server__tool_name"
```

**4. `docs/your-server.md`** — create a doc file and link it in this README

Then restart Claude Code to pick up the changes.

## License

GPL v2 or later
