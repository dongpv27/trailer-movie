# Streaming & Cinema Logos

This directory contains logos for Vietnamese cinemas and streaming platforms.

## Current Logos (SVG with Official Brand Colors)

### Vietnamese Cinemas
- `cgv.svg` - CGV (Red: #E03C31)
- `lotte-cinema.svg` - Lotte Cinema (Blue: #0075C9)
- `galaxy-cinema.svg` - Galaxy Cinema (Orange: #F58020)
- `beta-cinemas.svg` - Beta Cinemas (Blue: #015198)
- `cinestar.svg` - Cinestar (Maroon: #9B1C31)

### Streaming Platforms
- `netflix.svg` - Netflix (Red: #E50914)
- `disney-plus.svg` - Disney+ (Blue: #01147C)
- `hbo-go.svg` - HBO GO (Purple Gradient)
- `prime-video.svg` - Prime Video (Blue: #00A8E1)
- `apple-tv.svg` - Apple TV+ (Dark Gray: #1D1D1F)

## How to Upgrade to Official Logos

### Option 1: Download from Official Sources

**Vietnamese Cinemas:**
- Contact directly via their official websites for brand assets
- CGV Vietnam: https://www.cgv.vn
- Lotte Cinema: https://www.lottecinema.vn
- Galaxy Cinema: https://galaxycine.vn
- Beta Cinemas: https://betacinemas.vn
- Cinestar: https://cinestar.com.vn

**Streaming Platforms:**
- Netflix: https://brand.netflix.com/en/assets/logos/
- Disney+: https://press.disneyplus.com/about/logos
- HBO: https://www.hbo.com
- Prime Video: https://www.amazon.com/primevideo
- Apple TV+: https://marketing.services.apple/apple-tv-identity-guidelines

### Option 2: Download from Logo Repositories

- **Wikimedia Commons**: https://commons.wikimedia.org (Search for brand name + "logo")
- **Brandfetch**: https://brandfetch.com (Enter brand URL)
- **SeekLogo**: https://seeklogo.com (Download SVG, PNG formats)
- **WorldVectorLogo**: https://worldvectorlogo.com

### File Naming Convention

Logo files must be named using the streaming platform's slug:
```
[slug].svg
```

For example:
- CGV → `cgv.svg`
- Lotte Cinema → `lotte-cinema.svg`
- Netflix → `netflix.svg`

### Recommended Specifications

- **Format**: SVG (preferred) or PNG with transparent background
- **Size**: 200-300px width, 40-60px height
- **Background**: Transparent
- **Colors**: Official brand colors

## Current Implementation

The logos are automatically loaded in the streaming-info component:
```blade
<img src="{{ asset('images/streamings/' . $streaming->slug . '.svg') }}" ...>
```

If a logo file is not found, the component falls back to emoji icons (🎬 for cinemas, 📺 for streaming).
