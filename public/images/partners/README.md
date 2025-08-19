# Partner Logos Directory

This directory contains the logo images for our trusted partners displayed on the ticket confirmation page.

## Required Logo Files

Please add the following logo image files to this directory:

### Sports & Fashion Partners
- `adidas-logo.png` - Adidas (Sports & Athletic Wear)
- `chanel-logo.png` - Chanel (Luxury Fashion & Beauty)
- `nike-logo.png` - Nike (Athletic Apparel & Equipment)

### Automotive Partners
- `toyota-logo.png` - Toyota (Official Automotive Partner)
- `mini-logo.png` - Mini (Premium Automotive)
- `honda-logo.png` - Honda (Mobility Solutions)

### Technology Partners
- `gs1-logo.png` - GS1 (Global Standards & Supply Chain)
- `blackberry-logo.png` - BlackBerry (Technology Security)

## Image Specifications

### Recommended Format
- **File Type**: PNG (preferred) or SVG
- **Background**: Transparent or white
- **Quality**: High resolution for crisp display

### Size Guidelines
- **Maximum Height**: 48px (will be auto-scaled)
- **Maximum Width**: 120px (will be auto-scaled)
- **Aspect Ratio**: Maintain original logo proportions
- **File Size**: Keep under 50KB for optimal loading

### Naming Convention
- Use lowercase letters
- Use hyphens (-) instead of spaces
- Include company name + "logo"
- Example: `company-name-logo.png`

## Usage in Code

The logos are referenced in the confirmation page using Laravel's asset helper:

```blade
<img src="{{ asset('images/partners/logo-name.png') }}" 
     alt="Company Name - Partnership Description" 
     class="max-h-12 max-w-full object-contain">
```

## Adding New Partners

To add a new partner:

1. Add the logo image to this directory
2. Update the confirmation page template
3. Add the partner link and information
4. Test the responsive layout

## Partner Websites

- Adidas: https://www.adidas.com
- Chanel: https://www.chanel.com
- Nike: https://www.nike.com
- Toyota: https://www.toyota.com
- GS1: https://www.gs1.org
- BlackBerry: https://www.blackberry.com
- Mini: https://www.mini.com
- Honda: https://www.honda.com

## Notes

- All logos should be optimized for web display
- Ensure you have proper licensing/permission to use the logos
- Test the display on both mobile and desktop devices
- Verify accessibility with screen readers
