import '../scss/main.scss';

// Block scripts load lazily, only when the block is on the page.
// views/blocks/<slug>/<slug>.js exports default init(element).
const blocks = require.context('../../views/blocks', true, /^\.\/([^/]+)\/\1\.js$/, 'lazy');

blocks.keys().forEach((key) => {
  const slug = key.split('/')[1];
  const elements = document.querySelectorAll(`.wp-block-acf-${slug}`);
  if (!elements.length) return;
  blocks(key).then(({ default: init }) => elements.forEach((el) => init(el)));
});
