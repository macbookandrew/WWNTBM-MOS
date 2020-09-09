module.exports = function (grunt) {
  grunt.initConfig({
    // Watch task config
    watch: {
        styles: {
            files: "SCSS/*.scss",
            tasks: ['sass', 'postcss'],
        },
        javascript: {
            files: ["js/*.js", "!js/*.min.js"],
            tasks: ['uglify'],
        },
    },
    sass: {
        dev: {
            files: {
                "wwntbm-mos.css" : "SCSS/WWNTBM-MOS.scss"
            }
        }
    },
    postcss: {
        options: {
            map: {
                inline: false,
            },

            processors: [
                require('pixrem')(), // add fallbacks for rem units
                require('autoprefixer-core')({browsers: 'last 2 versions'}), // add vendor prefixes
            ]
        },
        dist: {
            src: 'wwntbm-mos.css',
        }
    },
    uglify: {
        options: {
            sourceMap: true
        },
        custom: {
            files: {
                'js/responsive-videos.min.js': ['js/responsive-videos.js'],
            },
        },
    },
    browserSync: {
        dev: {
            bsFiles: {
                src : ['wwntbm-mos.css', '*.php', '**/*.js', '!node_modules'],
            },
            options: {
                watchTask: true,
                open: "external",
                host: "andrews-macbook-pro.local",
                proxy: "https://wwntbm.wordpress.dev",
                https: {
                    key: "/Users/andrew/github/dotfiles/local-dev.key",
                    cert: "/Users/andrew/github/dotfiles/local-dev.crt",
                }

            },
        },
    },
  });

    grunt.loadNpmTasks('grunt-contrib-sass');
    grunt.loadNpmTasks('grunt-postcss');
    grunt.loadNpmTasks('grunt-contrib-uglify');
    grunt.loadNpmTasks('grunt-contrib-watch');
    grunt.loadNpmTasks('grunt-browser-sync');
    grunt.registerTask('default', [
        'browserSync',
        'watch',
    ]);
};
