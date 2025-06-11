# Material Design 3 Card Block for Kirby CMS

A custom Kirby CMS block that implements Google's Material Design 3 card component with full specification compliance.

## Features

### Card Types
- **Filled Cards**: Use fill for emphasis and surface contrast
- **Elevated Cards**: Use elevation for emphasis and surface separation  
- **Outlined Cards**: Use a stroke for emphasis and surface separation

### Elevation Levels (for Elevated Cards)
- Level 0 (Flat) - No shadow
- Level 1 - Subtle shadow
- Level 2 - Default shadow
- Level 3 - Medium shadow
- Level 4 - Strong shadow
- Level 5 - Maximum shadow

### Layout Options
- Optional header image (top or side positioning)
- Headline text with rich formatting
- Subhead supporting text
- Optional body text content
- Action buttons (primary and secondary)
- Clickable card option

### Material Design 3 Compliance
- Official Material 3 design tokens
- Proper elevation shadows
- Material typography scale
- State layer interactions
- Responsive breakpoints
- Dark theme support
- Accessibility focus indicators

## Usage

1. Add the block to your Kirby installation in the `site/plugins/` directory
2. Include the CSS file in your theme
3. The block will appear as "Material Card" in the block selector

## CSS Integration

Add the CSS file to your theme's build process or include it directly:

```html
<link rel="stylesheet" href="/site/plugins/block-material-card/index.css">
```

## Customization

The component uses CSS custom properties (variables) for easy theming. Override the Material Design tokens in your CSS:

```css
:root {
  --md-sys-color-primary: #your-primary-color;
  --md-sys-color-surface: #your-surface-color;
  /* etc... */
}
```

## Browser Support

- Modern browsers with CSS Grid and Custom Properties support
- Graceful degradation for older browsers
- Responsive design for mobile devices

## Accessibility

- Proper semantic HTML structure
- Keyboard navigation support
- Focus indicators
- Screen reader friendly
- WCAG 2.1 compliant

## Material Design Resources

- [Material Design 3 Cards](https://m3.material.io/components/cards/overview)
- [Material Design Tokens](https://m3.material.io/foundations/design-tokens/overview)
- [Material Theming](https://m3.material.io/styles/color/the-color-system/key-colors-tones)
