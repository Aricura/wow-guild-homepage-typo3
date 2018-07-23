let mix = require('laravel-mix');

mix
	// set the website's root path relative to the project's root dir
	.setPublicPath(path.resolve('./'))

	// compile typescript
	.ts('assets/main.ts', 'dist/')

	// compile sass
	.sass('assets/main.scss', 'dist/')

	// customize the font output dir (created by sass compilation) relative to the root path
	.options({
		fileLoaderDirs: {
			fonts: 'dist/fonts'
		}
	})

	// using asset versioning for *.js and *.css files and fonts
	.version();
