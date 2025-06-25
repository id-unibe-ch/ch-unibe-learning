# Project Progress Block for Kirby CMS

A custom block plugin for Kirby CMS that displays project information with Material Design 3 compliant progress indicators.

## Features

- **Project Information**: Display project name, owner, and description
- **Progress Tracking**: Visual progress indicators (0-100%) with linear and circular options
- **Status Management**: Track project status (Planning, Active, On Hold, Completed, Cancelled)
- **Priority Levels**: Visual priority indicators (Low, Medium, High, Critical)
- **Material Design 3**: Follows Material Design 3 specifications for progress indicators
- **Responsive Design**: Works on all screen sizes
- **Accessibility**: ARIA labels and keyboard navigation support
- **Dark Mode**: Automatic dark mode support

## Usage

1. Add the block to your Kirby page in the Panel
2. Fill in the required fields:
   - **Project Name**: The name of your project
   - **Project Owner**: Person or team responsible
   - **Progress**: Completion percentage (0-100)
3. Customize optional settings:
   - **Progress Type**: Choose between linear bar or circular ring
   - **Show Percentage**: Toggle percentage text display
   - **Description**: Add project details
   - **Status**: Set current project status
   - **Priority**: Set priority level
   - **Due Date**: Add project deadline

## Progress Indicator Types

### Linear Progress Bar
- Clean horizontal progress bar
- Follows Material Design 3 specifications
- Smooth animations and transitions
- Color-coded based on project status

### Circular Progress Ring
- Circular progress indicator
- Percentage display in center (optional)
- SVG-based for crisp rendering
- Animated progress updates

## Status Colors

- **Planning**: Gray (#6c757d)
- **Active**: Blue (#007bff)
- **On Hold**: Yellow (#ffc107)
- **Completed**: Green (#28a745)
- **Cancelled**: Red (#dc3545)

## Priority Indicators

Visual left border indicators:
- **Low**: Green border
- **Medium**: Yellow border
- **High**: Orange border
- **Critical**: Red border

## Installation

1. Copy the `block-project` folder to your `site/plugins/` directory
2. Include the CSS file in your template or add it to your build process
3. The block will be available in the Kirby Panel under "Project Progress"

## Styling

The block includes comprehensive CSS with:
- Material Design 3 compliant styling
- Smooth animations and transitions
- Responsive design patterns
- Dark mode support
- Accessibility features

## Browser Support

- Modern browsers with CSS Grid and Flexbox support
- SVG support for circular progress indicators
- CSS custom properties for theming

## Customization

You can customize the appearance by modifying the CSS variables or overriding the styles in your theme. The block is designed to be flexible and easily themed to match your site's design.
