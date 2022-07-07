const mix = require('laravel-mix');
const { CleanWebpackPlugin } = require('clean-webpack-plugin');
require('dotenv').config();

const browserSyncUrl = process.env.BROWSER_SYNC_URL;
const development = process.env.NODE_ENV === 'development';

// Path for production env.
mix.setPublicPath('./');

mix.options({
  postCss: [require('autoprefixer')],
  terser: {
    extractComments: false,
  },
});

mix.webpackConfig({
  externals: {
      "jquery": "jQuery",
  }
});

if (development) {
  mix.webpackConfig({
    devtool: 'inline-source-map',
  });
  mix.sourceMaps();
}

mix.options({
  processCssUrls: false
})

mix
  .js('assets/js/app.js', 'dist/js/app.js')
  .sass('assets/css/app.scss', 'dist/css/app.css')
  .js('assets/js/admin.js', 'dist/js/admin.js')
  .sass('assets/css/admin.scss', 'dist/css/admin.css')

mix.webpackConfig({
  plugins: [
    new CleanWebpackPlugin({
      cleanOnceBeforeBuildPatterns: ['dist'],
    }),
  ],
});

mix.browserSync({
  files: [
    {
      match: ['**/*.js', '**/*.css', '**/*.php'],
      fn: function (event) {
        if (event === 'change') {
          const bs = require('browser-sync').get('bs-webpack-plugin');
          bs.reload();
        }
      },
    },
  ],
  //port: '9100',
  //proxy: 'laradock_workspace_1',
  proxy: 'bolge.localhost',
  host: 'bolge.localhost',
  open: false,
  options: {
    reload: true,
  },
});

// Disable mix-manifest.json
Mix.manifest.refresh = (_) => void 0;

// Disable OS notifications
mix.disableNotifications();