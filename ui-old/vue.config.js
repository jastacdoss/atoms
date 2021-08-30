// vue.config.js

module.exports = {
    css: {
      sourceMap: true,
    },
    lintOnSave: true,
    // output built static files to Laravel's public dir.
    // note the "build" script in package.json needs to be modified as well.
    outputDir: '../public',

    // Change build paths for production
    indexPath: process.env.NODE_ENV === 'production' ?
        '../resources/views/index.blade.php' :
        'index.html',
    // publicPath: '/',
    devServer: {
        proxy: {
            '/api': {
                // target: 'http://www.bidatc.com',
                target: 'http://atoms.test',
                ws: true,
                changeOrigin: true
            },
        },
    }
};
