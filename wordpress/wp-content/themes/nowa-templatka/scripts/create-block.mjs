// Usage: npm run create-block -- <slug> "<Title>" [--inner]
//   --inner  block can contain other blocks (InnerBlocks)
import { existsSync, mkdirSync, readFileSync, writeFileSync } from 'node:fs';
import { dirname, resolve } from 'node:path';
import { fileURLToPath } from 'node:url';

const root = resolve(dirname(fileURLToPath(import.meta.url)), '..');
const args = process.argv.slice(2);
const flags = args.filter((a) => a.startsWith('--'));
const [slug, title] = args.filter((a) => !a.startsWith('--'));
const inner = flags.includes('--inner');

if (!slug || !/^[a-z][a-z0-9]*(-[a-z0-9]+)*$/.test(slug)) {
  console.error('Usage: npm run create-block -- <slug> "<Title>" [--inner]\nSlug must be lowercase kebab-case.');
  process.exit(1);
}

const dir = resolve(root, 'views/blocks', slug);
if (existsSync(dir)) {
  console.error(`Block "${slug}" already exists: ${dir}`);
  process.exit(1);
}

const label = title || slug.replace(/-/g, ' ').replace(/^./, (c) => c.toUpperCase());
const snake = slug.replace(/-/g, '_');
const cls = `wp-block-acf-${slug}`;

const write = (file, content) => writeFileSync(resolve(dir, file), content);
mkdirSync(dir, { recursive: true });

write(
  'block.json',
  JSON.stringify(
    {
      $schema: 'https://schemas.wp.org/trunk/block.json',
      apiVersion: 3,
      name: `acf/${slug}`,
      title: label,
      category: 'nowa-templatka',
      icon: 'layout',
      acf: { mode: 'preview', renderTemplate: 'render.php' },
      supports: {
        align: ['wide', 'full'],
        anchor: true,
        ...(inner ? { jsx: true } : {}),
      },
    },
    null,
    2,
  ) + '\n',
);

write(
  'render.php',
  `<?php
/**
 * ${label} block.
 *
 * @var array $block Block settings and attributes.
 */

defined( 'ABSPATH' ) || exit;

$title = get_field( 'title' );
?>
<section <?php echo get_block_wrapper_attributes(); ?>>
	<?php if ( $title ) : ?>
		<h2 class="${cls}__title"><?php echo esc_html( $title ); ?></h2>
	<?php endif; ?>
${inner ? '\t<InnerBlocks />\n' : ''}</section>
`,
);

write('_' + slug + '.scss', `.${cls} {\n  // ${label} styles\n}\n`);

write(
  slug + '.js',
  `// Loaded only when the block is present on the page.\nexport default function init(element) {\n  // element: .${cls}\n}\n`,
);

write(
  `group_${snake}.json`,
  JSON.stringify(
    {
      key: `group_${snake}`,
      title: `Block: ${label}`,
      fields: [
        {
          key: `field_${snake}_title`,
          label: 'Title',
          name: 'title',
          type: 'text',
        },
      ],
      location: [[{ param: 'block', operator: '==', value: `acf/${slug}` }]],
      menu_order: 0,
      position: 'normal',
      style: 'default',
      label_placement: 'top',
      instruction_placement: 'label',
      active: true,
      modified: Math.floor(Date.now() / 1000),
    },
    null,
    2,
  ) + '\n',
);

// Register the block stylesheet in the shared blocks index.
const index = resolve(root, 'assets/scss/blocks.scss');
const use = `@use '../../views/blocks/${slug}/${slug}';\n`;
const current = existsSync(index) ? readFileSync(index, 'utf8') : '// Block styles. Lines are added by npm run create-block.\n';
writeFileSync(index, current + use);

console.log(`Created views/blocks/${slug}/ (${inner ? 'with InnerBlocks' : 'standalone'}). Run: npm run build`);
