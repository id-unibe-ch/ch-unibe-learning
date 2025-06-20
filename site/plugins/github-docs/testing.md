# Testing the GitHub Documentation Plugin

## Quick Test Setup

To test this plugin quickly, you can use a public repository with documentation.

### Example Test Repository
- **Repository URL**: `https://github.com/mermaid-js/mermaid`
- **Branch**: `develop`
- **Documentation Path**: `docs`

This repository contains extensive documentation with Mermaid diagrams (perfect for testing).

### Alternative Test Repositories

1. **Kirby CMS Documentation**
   - URL: `https://github.com/getkirby/getkirby.com`
   - Path: `content/docs`
   - Good for testing Kirby-specific content

2. **Vue.js Documentation**
   - URL: `https://github.com/vuejs/docs`
   - Path: `src`
   - Contains complex markdown structures

3. **Simple Test Repository**
   - URL: `https://github.com/microsoft/vscode`
   - Path: `docs`
   - Well-structured documentation

## Test Checklist

After setting up the plugin:

- [ ] Plugin appears in admin panel templates
- [ ] Can create "GitHub Documentation" page
- [ ] Repository URL field accepts GitHub URLs
- [ ] Documentation files are listed on the page
- [ ] Individual documentation pages load correctly
- [ ] Markdown content renders properly
- [ ] Images from GitHub display correctly
- [ ] Mermaid diagrams render (if enabled)
- [ ] Navigation between pages works
- [ ] Error handling works for invalid repositories

## Test Commands

You can also test the GitHub API connection manually:

```bash
# Test GitHub API access (replace with your repo details)
curl -H "Accept: application/vnd.github.v3+json" \
  https://api.github.com/repos/mermaid-js/mermaid/contents/docs

# Test specific file access  
curl -H "Accept: application/vnd.github.v3+json" \
  https://api.github.com/repos/mermaid-js/mermaid/contents/docs/README.md
```

## Debugging

Enable debug mode in your Kirby config:

```php
// site/config/config.php
return [
    'debug' => true
];
```

Then check for errors in:
- Browser developer console
- Kirby error logs
- PHP error logs

## Performance Testing

- Test with large repositories (100+ documentation files)
- Test GitHub API rate limiting (60 requests/hour without token)
- Test caching functionality
- Test with private repositories (requires API token)
