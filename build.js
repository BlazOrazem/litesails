/**
 * Lite Sails asset build.
 *
 * Bundles the vendor libraries (Bootstrap, jQuery) together with our own
 * assets/style.css and assets/scripts.js into two minified files:
 *
 *   dist/app.min.css   Bootstrap CSS + custom styles (minified & optimised)
 *   dist/app.min.js    jQuery + Bootstrap JS + custom scripts (minified)
 *   dist/fonts/        Bootstrap glyphicon fonts (so the CSS url()s resolve)
 *   dist/leaflet/      Leaflet, for the lightning map page only
 *
 * Run with:  npm install  &&  npm run build
 */
const fs = require('fs');
const path = require('path');
const CleanCSS = require('clean-css');
const { minify } = require('terser');

const root = __dirname;
const dist = path.join(root, 'dist');
const nm = path.join(root, 'node_modules');

function read(...parts) {
    return fs.readFileSync(path.join(...parts), 'utf8');
}

async function build() {
    fs.mkdirSync(dist, { recursive: true });

    /* ------------------------------ CSS ------------------------------ */
    const css = [
        read(nm, 'bootstrap', 'dist', 'css', 'bootstrap.css'),
        read(root, 'assets', 'style.css'),
    ].join('\n');

    const result = new CleanCSS({ level: 2, rebase: false }).minify(css);
    if (result.errors.length) {
        throw new Error('CSS errors: ' + result.errors.join('; '));
    }

    // Bootstrap references glyphicon fonts as url(../fonts/…). Relative to
    // dist/app.min.css that would be the site root, so repoint them at dist/fonts.
    const cssOut = result.styles.replace(/\.\.\/fonts\//g, 'fonts/');
    fs.writeFileSync(path.join(dist, 'app.min.css'), cssOut);

    // Ship the glyphicon fonts alongside the CSS.
    const fontsSrc = path.join(nm, 'bootstrap', 'dist', 'fonts');
    const fontsDst = path.join(dist, 'fonts');
    fs.mkdirSync(fontsDst, { recursive: true });
    for (const file of fs.readdirSync(fontsSrc)) {
        fs.copyFileSync(path.join(fontsSrc, file), path.join(fontsDst, file));
    }

    /* ------------------------------ JS ------------------------------- */
    // Vendor files already ship minified; only our own code needs minifying.
    const scripts = await minify(read(root, 'assets', 'scripts.js'), {
        compress: true,
        mangle: true,
    });

    const js = [
        read(nm, 'jquery', 'dist', 'jquery.min.js'),
        read(nm, 'bootstrap', 'dist', 'js', 'bootstrap.min.js'),
        scripts.code,
    ].join('\n;\n');
    fs.writeFileSync(path.join(dist, 'app.min.js'), js);

    /* ---------------------------- Leaflet ---------------------------- */
    // Only the lightning map needs Leaflet (~145 KB), so it ships as its own
    // pair of files that lightning.php loads, instead of riding in every
    // page's app.min.js. Its CSS points at images/… relatively, so the
    // images folder goes alongside.
    const leafletSrc = path.join(nm, 'leaflet', 'dist');
    const leafletDst = path.join(dist, 'leaflet');
    fs.mkdirSync(path.join(leafletDst, 'images'), { recursive: true });

    const leafletCss = new CleanCSS({ level: 2, rebase: false }).minify(read(leafletSrc, 'leaflet.css'));
    if (leafletCss.errors.length) {
        throw new Error('Leaflet CSS errors: ' + leafletCss.errors.join('; '));
    }
    fs.writeFileSync(path.join(leafletDst, 'leaflet.min.css'), leafletCss.styles);
    fs.copyFileSync(path.join(leafletSrc, 'leaflet.js'), path.join(leafletDst, 'leaflet.min.js'));
    for (const file of fs.readdirSync(path.join(leafletSrc, 'images'))) {
        fs.copyFileSync(path.join(leafletSrc, 'images', file), path.join(leafletDst, 'images', file));
    }

    const kb = (n) => (n / 1024).toFixed(1) + ' KB';
    console.log('Built dist/app.min.css (' + kb(cssOut.length) + ')');
    console.log('Built dist/app.min.js  (' + kb(js.length) + ')');
    console.log('Built dist/leaflet/    (' + kb(leafletCss.styles.length) + ' CSS)');
}

build().catch((err) => {
    console.error(err);
    process.exit(1);
});
