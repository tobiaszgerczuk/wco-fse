// Generates theme.json and assets/scss/base/_tokens.scss from assets/tokens.json.
import { readFileSync, writeFileSync } from 'node:fs';
import { dirname, resolve } from 'node:path';
import { fileURLToPath } from 'node:url';

const root = resolve(dirname(fileURLToPath(import.meta.url)), '..');
const tokens = JSON.parse(readFileSync(resolve(root, 'assets/tokens.json'), 'utf8'));

const toPreset = (group, extra = (slug, item) => ({})) =>
  Object.entries(group).map(([slug, item]) => ({ slug, name: item.name, ...extra(slug, item) }));

const themeJson = {
  $schema: 'https://schemas.wp.org/trunk/theme.json',
  version: 3,
  settings: {
    appearanceTools: true,
    useRootPaddingAwareAlignments: true,
    color: {
      palette: toPreset(tokens.colors, (_, i) => ({ color: i.value })),
      defaultPalette: false,
      defaultGradients: false,
      defaultDuotone: false,
    },
    typography: {
      fluid: false,
      defaultFontSizes: false,
      fontFamilies: toPreset(tokens.fonts, (slug, i) => ({ fontFamily: i.value })),
      fontSizes: toPreset(tokens.fontSizes, (_, i) => ({ size: i.value })),
    },
    spacing: {
      defaultSpacingSizes: false,
      spacingSizes: toPreset(tokens.spacing, (_, i) => ({ size: i.value })),
      units: ['px', 'rem', '%', 'vw', 'vh'],
    },
    layout: {
      contentSize: tokens.layout.content,
      wideSize: tokens.layout.wide,
    },
    custom: { breakpoints: tokens.breakpoints },
  },
  styles: {
    color: {
      background: 'var(--wp--preset--color--white)',
      text: 'var(--wp--preset--color--dark)',
    },
    typography: {
      fontFamily: 'var(--wp--preset--font-family--body)',
      fontSize: 'var(--wp--preset--font-size--base)',
      lineHeight: '1.6',
    },
    spacing: {
      padding: {
        left: 'var(--wp--preset--spacing--sm)',
        right: 'var(--wp--preset--spacing--sm)',
      },
      blockGap: 'var(--wp--preset--spacing--sm)',
    },
    elements: {
      link: { color: { text: 'var(--wp--preset--color--primary)' } },
      heading: {
        typography: { fontFamily: 'var(--wp--preset--font-family--heading)', lineHeight: '1.2' },
      },
    },
  },
  templateParts: [
    { name: 'header', title: 'Header', area: 'header' },
    { name: 'footer', title: 'Footer', area: 'footer' },
  ],
};

writeFileSync(resolve(root, 'theme.json'), JSON.stringify(themeJson, null, 2) + '\n');

const scss = [
  '// Generated from assets/tokens.json by scripts/generate-theme-json.mjs. Do not edit.',
  '',
  '$breakpoints: (',
  ...Object.entries(tokens.breakpoints).map(([k, v]) => `  '${k}': ${v},`),
  ');',
  '',
  `$container-content: ${tokens.layout.content};`,
  `$container-wide: ${tokens.layout.wide};`,
  '',
].join('\n');

writeFileSync(resolve(root, 'assets/scss/base/_tokens.scss'), scss);
console.log('Generated theme.json and _tokens.scss');
