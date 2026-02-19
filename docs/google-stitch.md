# Google Stitch

AI-powered UI design tool that generates, edits, and iterates on screen designs from text prompts — all through MCP.

## Overview

Google Stitch lets you describe a UI in plain English and get back a fully styled HTML screen using Tailwind CSS and Material Symbols. You can create projects, generate screens, edit them, and produce design variants — without ever leaving your editor.

## Setup

### 1. Get an API key

Obtain a Google Stitch API key from [Google AI Studio](https://aistudio.google.com/).

### 2. Set environment variable

```bash
export GOOGLE_STITCH_API_KEY="your-stitch-api-key"
```

### 3. MCP config (already included in `.mcp.json`)

```json
{
  "stitch": {
    "command": "npx",
    "args": [
      "mcp-remote",
      "https://stitch.googleapis.com/mcp",
      "--header",
      "X-Goog-Api-Key: ${GOOGLE_STITCH_API_KEY}"
    ]
  }
}
```

## Tools

| Tool | Description |
|---|---|
| `list_projects` | List all your Stitch projects |
| `create_project` | Create a new project container |
| `get_project` | Get details of a specific project |
| `list_screens` | List all screens within a project |
| `get_screen` | Get screen details including HTML download URL |
| `generate_screen_from_text` | Generate a new screen from a text prompt |
| `edit_screens` | Edit existing screens using a text prompt |
| `generate_variants` | Generate design variants of existing screens |

## Workflow

```
create_project ──> generate_screen_from_text ──> get_screen ──> download HTML
                                                     │
                                                     ├──> edit_screens (iterate)
                                                     └──> generate_variants (explore)
```

### Step-by-step

1. **Create a project** — a container for your screens
2. **Generate a screen** — describe the UI you want in plain text
3. **Get the screen** — retrieve details and the `htmlCode.downloadUrl`
4. **Download the HTML** — use `curl -sL <url>` to save it locally
5. **Iterate** — edit screens or generate variants to refine the design

## Examples

### Generate a login page

**Prompt:**
```
Create a Stitch project called "MyApp" and generate a modern login screen
with email, password, social login buttons, and a dark theme
```

**Behind the scenes:**
```
1. mcp__stitch__create_project(title: "MyApp")
   → project ID: 8837261049372615328

2. mcp__stitch__generate_screen_from_text(
     projectId: "8837261049372615328",
     prompt: "Modern login screen with email and password fields,
              social login buttons for Google and GitHub, dark theme",
     deviceType: "DESKTOP"
   )
   → screen generated

3. mcp__stitch__get_screen(name: "projects/.../screens/...")
   → returns htmlCode.downloadUrl

4. curl -sL <downloadUrl> > login.html
```

### Edit an existing screen

**Prompt:**
```
Change the login screen background to a gradient and make the form card rounded
```

**Behind the scenes:**
```
1. mcp__stitch__list_screens(projectId: "...")
   → find the login screen ID

2. mcp__stitch__edit_screens(
     projectId: "...",
     selectedScreenIds: ["..."],
     prompt: "Change background to a blue-purple gradient,
              make the form card more rounded with shadow"
   )
```

### Generate design variants

**Prompt:**
```
Give me 3 color scheme variants of the pricing page
```

**Behind the scenes:**
```
mcp__stitch__generate_variants(
  projectId: "...",
  selectedScreenIds: ["..."],
  prompt: "Generate color scheme variants",
  variantOptions: {
    variantCount: 3,
    aspects: ["COLOR_SCHEME"],
    creativeRange: "EXPLORE"
  }
)
```

### Variant options reference

| Option | Values | Default |
|---|---|---|
| `variantCount` | 1–5 | 3 |
| `creativeRange` | `REFINE`, `EXPLORE`, `REIMAGINE` | `EXPLORE` |
| `aspects` | `LAYOUT`, `COLOR_SCHEME`, `IMAGES`, `TEXT_FONT`, `TEXT_CONTENT` | all |

### Device types

| Value | Use case |
|---|---|
| `DESKTOP` | Standard web layout |
| `MOBILE` | Phone-sized screens |
| `TABLET` | Tablet layouts |
| `AGNOSTIC` | Responsive / device-independent |

## Output format

Stitch generates full HTML documents with:

- **Tailwind CSS** via CDN
- **Google Material Symbols Outlined** for icons
- **Inter** font family
- Inline styles where needed

The HTML is self-contained and can be opened directly in a browser.

## Tips

- Generation can take up to a minute — don't retry if it seems slow.
- Be specific in your prompts — mention colors, layout, content, and style.
- Use `edit_screens` for targeted changes, `generate_variants` for exploration.
- Always use `curl -sL` (not `WebFetch`) to download HTML, since `WebFetch` summarizes content.
- If a generation call fails with a connection error, the screen may still have been created — try `get_screen` to check.
