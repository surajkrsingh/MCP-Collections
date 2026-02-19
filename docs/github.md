# GitHub

GitHub's official MCP server — interact with repositories, issues, pull requests, actions, and code directly through Claude.

## Overview

The GitHub MCP server connects Claude to the GitHub platform. You can browse repos, manage issues and PRs, monitor CI/CD workflows, review security alerts, and more — all through natural language in your editor.

## Prerequisites

- [`github-mcp-server`](https://github.com/github/github-mcp-server/releases) binary installed and on your PATH
- A [GitHub Personal Access Token](https://github.com/settings/tokens) (Classic or Fine-grained)

## Setup

### 1. Install the binary

Download the latest release for your platform from [GitHub releases](https://github.com/github/github-mcp-server/releases) and place it on your PATH:

```bash
# macOS ARM (Apple Silicon)
gh release download --repo github/github-mcp-server --pattern "github-mcp-server_Darwin_arm64.tar.gz" --dir /tmp
tar -xzf /tmp/github-mcp-server_Darwin_arm64.tar.gz -C /tmp
sudo mv /tmp/github-mcp-server /usr/local/bin/

# Verify
github-mcp-server --help
```

### 2. Create a Personal Access Token

#### Option A: Classic Token (simpler, broader access)

Go to [github.com/settings/tokens](https://github.com/settings/tokens) and create a classic token.

| Scope | What it enables |
|---|---|
| `repo` | Read/write repos, issues, PRs, commits |
| `read:org` | Read org and team membership |
| `admin:repo_hook` | Manage webhooks (optional) |

> Classic tokens with `repo` scope cover all toolsets including creating repos.

#### Option B: Fine-grained Token (more secure, granular control)

Go to [github.com/settings/personal-access-tokens/new](https://github.com/settings/personal-access-tokens/new) and enable only what you need:

| Permission | Access | Enables |
|---|---|---|
| **Contents** | Read & Write | Browse code, push files, manage releases |
| **Issues** | Read & Write | Create, update, comment on issues |
| **Pull requests** | Read & Write | Create, review, merge PRs |
| **Actions** | Read | Monitor workflow runs, view logs |
| **Security events** | Read | Code scanning, Dependabot alerts |
| **Discussions** | Read & Write | Team discussions |
| **Administration** | Read & Write | Create/delete repositories |
| **Metadata** | Read | Required (auto-selected) |

> **Note:** Without `Administration` permission, `create_repository` and `fork_repository` will return a `403` error.

### 3. Set environment variable

Add to your shell profile (`~/.zshrc` or `~/.bashrc`):

```bash
export GITHUB_PERSONAL_ACCESS_TOKEN="ghp_your_token_here"
```

```bash
source ~/.zshrc
```

### 4. MCP config (already included in `.mcp.json`)

```json
{
  "github": {
    "command": "github-mcp-server",
    "args": ["stdio"],
    "env": {
      "GITHUB_PERSONAL_ACCESS_TOKEN": "${GITHUB_PERSONAL_ACCESS_TOKEN}"
    }
  }
}
```

### 5. Verify it works

Restart Claude Code, then ask:

```
> Get my GitHub profile using MCP
```

Claude should return your username, bio, and profile details.

## Toolsets

The GitHub MCP server organizes tools into toolsets. All are enabled by default.

| Toolset | What it covers |
|---|---|
| **repos** | Browse repos, search files, read code, analyze commits |
| **issues** | Create, update, search, and manage issues |
| **pull_requests** | Create, review, merge PRs, manage reviews |
| **actions** | Monitor workflow runs, check status, access artifacts |
| **code_security** | Security findings, Dependabot alerts, vulnerability analysis |
| **discussions** | Team discussions and notifications |
| **release_management** | Create and manage releases |

## Key Tools

### Repository tools

| Tool | Description |
|---|---|
| `get_file_contents` | Read a file or directory from a repo |
| `search_repositories` | Search for repositories on GitHub |
| `search_code` | Search code across GitHub |
| `list_commits` | List commits in a repo or branch |
| `get_commit` | Get details of a specific commit |
| `create_or_update_file` | Create or update a file in a repo |
| `push_files` | Push multiple files in a single commit |
| `create_repository` | Create a new repository |
| `fork_repository` | Fork a repository |

### Issue tools

| Tool | Description |
|---|---|
| `create_issue` | Create a new issue |
| `get_issue` | Get issue details |
| `list_issues` | List issues with filters |
| `update_issue` | Update an issue |
| `search_issues` | Search issues across GitHub |
| `add_issue_comment` | Add a comment to an issue |

### Pull request tools

| Tool | Description |
|---|---|
| `create_pull_request` | Create a new PR |
| `get_pull_request` | Get PR details |
| `list_pull_requests` | List PRs with filters |
| `merge_pull_request` | Merge a PR |
| `get_pull_request_diff` | Get the diff of a PR |
| `get_pull_request_reviews` | Get reviews on a PR |
| `create_pull_request_review` | Submit a PR review |
| `update_pull_request` | Update PR title, body, or state |

### Actions tools

| Tool | Description |
|---|---|
| `list_workflow_runs` | List workflow runs |
| `get_workflow_run` | Get details of a workflow run |
| `get_workflow_run_logs` | Get logs from a workflow run |
| `rerun_workflow` | Re-run a failed workflow |

### Code security tools

| Tool | Description |
|---|---|
| `get_code_scanning_alert` | Get a code scanning alert |
| `list_code_scanning_alerts` | List code scanning alerts |
| `get_secret_scanning_alert` | Get a secret scanning alert |
| `list_secret_scanning_alerts` | List secret scanning alerts |

## Examples

### Browse a repository

**Prompt:**
```
Show me the folder structure of the vercel/next.js repo
```

### Create an issue

**Prompt:**
```
Create an issue on my-org/my-repo titled "Add dark mode support"
with a description of the feature requirements
```

### Review a pull request

**Prompt:**
```
Show me the diff for PR #42 on my-org/my-repo and summarize the changes
```

### Monitor CI/CD

**Prompt:**
```
Check the latest GitHub Actions runs on my-org/my-repo
and tell me if anything failed
```

### Search code

**Prompt:**
```
Search for uses of "useEffect" in the facebook/react repo
```

### Manage releases

**Prompt:**
```
Create a new release v2.0.0 on my-org/my-repo with auto-generated release notes
```

## GitHub Enterprise

For GitHub Enterprise Server, add the `GITHUB_HOST` environment variable to the MCP config:

```json
{
  "github": {
    "command": "github-mcp-server",
    "args": ["stdio"],
    "env": {
      "GITHUB_PERSONAL_ACCESS_TOKEN": "${GITHUB_PERSONAL_ACCESS_TOKEN}",
      "GITHUB_HOST": "https://github.your-company.com"
    }
  }
}
```

## Troubleshooting

| Error | Cause | Fix |
|---|---|---|
| `401 Bad credentials` | Token not set or invalid | Check `GITHUB_PERSONAL_ACCESS_TOKEN` is exported, then restart Claude Code |
| `403 Resource not accessible` | Token missing required permission | Update PAT scopes — e.g., `Administration: Read & Write` for creating repos |
| `github-mcp-server: command not found` | Binary not on PATH | Re-install to `/usr/local/bin/` and verify with `which github-mcp-server` |
| MCP tools not showing in Claude | Claude Code started before config change | Restart Claude Code to reload `.mcp.json` |

## Tips

- Make sure `github-mcp-server` is on your PATH — run `which github-mcp-server` to verify.
- After changing your token or `.mcp.json`, always **restart Claude Code** for changes to take effect.
- Use fine-grained PATs with minimum required scopes for better security.
- Rotate your tokens periodically.
- All GitHub MCP tools are pre-approved in this project — no permission prompts.

## References

- [GitHub MCP Server repo](https://github.com/github/github-mcp-server)
- [Installation guide for Claude](https://github.com/github/github-mcp-server/blob/main/docs/installation-guides/install-claude.md)
