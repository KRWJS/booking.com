module.exports = function(grunt) {

    grunt.initConfig({
        sass: {
            main: {
                options: {
                    outputStyle: 'compressed'
                },
                files: {
                    'public/css/main.min.css': 'resources/assets/main/sass/main.scss'
                }
            },
            admin: {
                options: {
                    outputStyle: 'compressed'
                },
                files: {
                    'public/css/admin.min.css': 'resources/assets/admin/sass/admin.scss'
                }
            }

        },

        uglify: {
            options: {
                banner: '',
                compress: true,
                sourceMap: true
            },
            main: {
                files: {
                    'public/js/main.min.js': [
                        'resources/assets/main/js/vendor/jquery-3.1.0.min.js',
                        "resources/assets/main/js/vendor/bootstrap.min.js",
                        "resources/assets/main/js/vendor/jquery.matchHeight.js",
                        "resources/assets/main/js/vendor/validator.js",
                        "resources/assets/main/js/vendor/slick.min.js",
                        "resources/assets/main/js/vendor/jquery.dropdown.js",
                        "resources/assets/main/js/vendor/jquery.custom-file-input.js",
                        "resources/assets/main/js/vendor/clipboard.min.js",
                        "resources/assets/main/js/vendor/velocity.min.js",
                        "resources/assets/main/js/vendor/progressButton.js",
                        "resources/assets/main/js/vendor/classie.js",
                        "resources/assets/main/js/vendor/retina.js",
                        "resources/assets/main/js/main.js",
                        'resources/assets/main/js/social_sharing.js'
                    ]
                }
            },
            admin: {
                files: {
                    'public/js/admin.min.js': [
                        'resources/assets/admin/js/vendor/jquery-3.1.0.min.js',
                        'resources/assets/admin/js/vendor/momentjs/moment.min.js',
                        'resources/assets/admin/js/vendor/bootstrap/bootstrap.js',
                        'resources/assets/admin/js/vendor/bootstraptoggle/bootstrap-toggle.js',
                        'resources/assets/admin/js/vendor/jasnybootstrap/jasny-bootstrap.js',
                        'resources/assets/admin/js/vendor/bootstrapdatetimepicker/bootstrap-datetimepicker.min.js',
                        'resources/assets/admin/js/vendor/datatables/datatables.js',
                        'resources/assets/admin/js/vendor/jquery.scrollTo.min.js',
                        'resources/assets/admin/js/vendor/select2.min.js',
                        'resources/assets/admin/js/*.js'
                    ]
                }
            }

        },

        watch: {
            sass: {
                files: ['resources/assets/main/sass/**/*.scss'],
                tasks: ['sass']
            },
            sass_admin: {
                files: ['resources/assets/admin/sass/**/*.scss'],
                tasks: ['sass:admin']
            },
            uglify_main: {
                files: ['resources/assets/main/js/**/*.js'],
                tasks: ['uglify:main']
            },
            uglify_admin: {
                files: ['resources/assets/admin/js/*.js', 'resources/assets/admin/js/**/*.js'],
                tasks: ['uglify:admin']
            }

        }
    });

    grunt.loadNpmTasks('grunt-contrib-uglify');
    grunt.loadNpmTasks('grunt-contrib-watch');
    grunt.loadNpmTasks('grunt-sass');
    // Tasks to be executed
    grunt.registerTask('default', ['watch']);
};
