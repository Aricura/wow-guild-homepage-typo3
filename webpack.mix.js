let mix = require('laravel-mix');

mix
	// compile typescript
	.ts('assets/main.ts', 'dist/')

	// compile sass
	.sass('assets/main.scss', 'dist/')

	// set the website's root path relative to the project's root dir
	.setPublicPath('/')

	// customize the font output dir (created by sass compilation) relative to the root path
	.options({
		fileLoaderDirs: {
			fonts: 'dist/fonts'
		}
	});
