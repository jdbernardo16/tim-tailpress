# Custom Fonts

Place the following font files in this directory:

## Flatline Sans (commercial font)
- `FlatlineSans-Regular.woff2` — Weight 400
- `FlatlineSans-Medium.woff2` — Weight 500
- `FlatlineSans-SemiBold.woff2` — Weight 600
- `FlatlineSans-Bold.woff2` — Weight 700
- `FlatlineSans-MediumItalic.woff2` — Weight 500, Italic

## Garet (commercial font)
- `Garet-Book.woff2` — Weight 300

These fonts are referenced in `resources/css/app.css` via `@font-face` declarations.

Once these files are added, rebuild the CSS with:
```bash
npm run build
```

The build process will copy these font files to the `dist/` output directory.
