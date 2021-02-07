(function($) {
    $(document).ready(function () {
        // ajax setup
        $.ajaxSetup({
            headers: {
                'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content') // CSRF token for ajax forms
            }
        });
    });

    /**
     * Shared functions
     * -------------------------
     */
    // (Search and seek and) Destroy a Ckeditor instance
    function destroyCkeditor($elem)
    {
        if ($elem.length > 0) {
            $elem.ckeditorGet().destroy();
        }
    }

    /**
     * CMS Button and form actions
     * -------------------------
     */
    (function() {
        // Delete form submit by link
        $('.btn-delete').on('click', function(e){
            e.preventDefault();
            $("form[data-confirm]").submit();
        });

        // Confirm deleting resources
        $("form[data-confirm]").submit(function() {
            if (!confirm($(this).attr("data-confirm"))) {
                return false;
            }
        });

        // back end form submit
        $(".form-admin").submit(function() {
            // Disable submit button on submitting back end form
            var $btn = $(this).find('.btn-save');

            if ($btn.data('alt')) {
                $btn.val($btn.data('alt'));
            }
            else {
                $btn.val('Saving....');
            }

            $btn.attr('disabled', 'disabled');
        });

        // cms login form submit
        $('.js-login-form').submit(function() {
            // Disable submit button on submitting back end form
            var $btn = $(this).find('.js-login-btn');

            $btn.html('Logging in....');
            $btn.attr('disabled', 'disabled');
        });

    })();

    /**
     * Character counters
     * -------------------------
     */
    (function() {

        // Character counter for input fields
        function countCharacters($elem, maxlength)
        {
            var len = $elem.val().length;
            if (len > maxlength) {
                $elem.val($elem.val().substring(0, maxlength));
            } else {
                $elem.parent().find('.char-count').html(maxlength - len);
            }
        }

        // Init character counts
        $('.character-counter').each(function(index, elem) {
            countCharacters($(this), $(this).attr('maxlength'));
        });

        // Bind character counter to element keyup & paste events
        $(document).on('keyup paste', '.character-counter', function() {
            countCharacters($(this), $(this).attr('maxlength'));
        });

    })();

    /**
     * Keyword counters
     * -------------------------
     */
    (function() {

        // Keyword counter (separated by comma's)
        function countKeywords($elem, max)
        {
            var keywords = $elem.val().split(','),
                count = keywords.length;

            if ($elem.val() == '') count = 0;

            if (count > max) {
                keywords.pop();
                $elem.val(keywords.join(','));
            } else {
                $elem.parent().find('.keyword-count').html(max - count);
            }
        }

        // Init keyword counts
        $('.js-keyword-counter').each(function(index, elem) {
            countKeywords($(this), $(this).data('max-keywords'));
        });

        // Bind keyword counter to element keyup & paste events
        $('.js-keyword-counter').on('keyup paste', function(e) {
            countKeywords($(this), $(this).data('max-keywords'));
        });

    })();


    /**
     * URL field edit warning
     * -------------------------
     */
    (function() {

        // Give a warning when a URL is edited
        $('.url-warning').on('keydown paste', function(e) {
            if ($(this).val() === '') $(this).removeClass('url-warning');
            if ($(this).hasClass('url-warning')) {
                e.preventDefault();
                alert("Warning: changing a page's URL might be harmful for its SEO.");
                $(this).removeClass('url-warning');
                return false;
            }

        });

    })();



    /**
     * Init CKeditor
     * -------------------------
     */
    (function() {

        // Init CKeditor via jquery. (this works better than using the ckeditor class,
        // because it allows the editor instance to be select by jquery)
        $(document).ready(function() {
            if ($.isFunction($.fn.ckeditor)) {
                CKEDITOR.config.allowedContent = true;
                $('.init-ckeditor').ckeditor();
            }
        });

    })();


    /**
     * Init Select2
     * -------------------------
     */
    (function() {
        $.fn.select2.defaults.set('theme', 'bootstrap');

        $('.js-select2').select2();

    })();


    /**
     * Date time picker
     * -------------------------
     */
    (function() {

        // Init boostrap date time picker
        if ($.isFunction($.fn.datetimepicker) && $('.js-dtpicker').length > 0) {
            $('.js-dtpicker').datetimepicker({
                format: 'YYYY-MM-DD HH:mm:ss'
            });
        }

    })();


    /**
     * SEO options
     * -------------------------
     */
    (function() {

        // Init SEO preview
        if($('.page-title').val() && $('.page-title').val().length > 0) {
            var $pageTitle = $('.page-title');
            $pageTitle.closest('.seo-options').find('.gp-title').html($pageTitle.val());
        }

        if($('.meta-desc').val() && $('.meta-desc').val().length > 0) {
            var $metaDesc = $('.meta-desc');
            $metaDesc.closest('.seo-options').find('.gp-desc').html($metaDesc.val());
        }

        // SEO preview
        $('.page-title').on('keyup', function() {
            $(this).closest('.seo-options').find('.gp-title').html($(this).val());
        });

        $('.meta-desc').on('keyup', function() {
            $(this).closest('.seo-options').find('.gp-desc').html($(this).val());
        });

    })();


    /**
     * CMS front end image validation
     * -------------------------
     */
    (function() {

        var imageValidationTypes = [ 'png', 'jpg', 'jpeg', 'gif' ];
        var imageValidation = {
            header_image: {
                minWidth: 1600,
                minHeight: 650,
                maxSize: 1024,
                fileTypes: imageValidationTypes
            },
            header_image_small: {
                minWidth: 1400,
                minHeight: 550,
                maxSize: 1024,
                fileTypes: imageValidationTypes
            },
            listing_image: {
                minWidth: 600,
                minHeight: 400,
                maxSize: 500,
                fileTypes: imageValidationTypes
            },
            avatar_image: {
                minWidth: 600,
                minHeight: 400,
                maxSize: 500,
                fileTypes: imageValidationTypes
            },
            block_single_image: {
                minWidth: 1600,
                minHeight: 650,
                maxSize: 1024,
                fileTypes: imageValidationTypes
            },
            block_video_image: {
                minWidth: 800,
                minHeight: 600,
                maxSize: 1024,
                fileTypes: imageValidationTypes
            }
        };

        // front end validation for images by using HTML5 file API
        function validateImage(file, imageValidationRules, $wrapper) {

            var reader = new FileReader();
            var image  = new Image();
            var errors = [];
            reader.readAsDataURL(file);
            reader.onload = function(_file) {
                image.src    = _file.target.result;              // url.createObjectURL(file);
                image.onload = function() {
                    var width = this.width,
                        height = this.height,
                        type = file.type,                           // ext only: // file.type.split('/')[1],
                        name = file.name,
                        size = ~~(file.size/1024); // size in KB

                    if (imageValidationRules.minWidth && imageValidationRules.minWidth > width) {
                        errors.push('The image width needs to be above ' + imageValidationRules.minWidth + 'px. (Currently ' + width + 'px)');
                    }
                    if (imageValidationRules.maxWidth && imageValidationRules.maxWidth < width) {
                        errors.push('The image width needs to be below ' + imageValidationRules.maxWidth + 'px. (Currently ' + width + 'px)');
                    }
                    if (imageValidationRules.minHeight && imageValidationRules.minHeight > height) {
                        errors.push('The image height needs to be above ' + imageValidationRules.minHeight + 'px. (Currently ' + height + 'px)');
                    }
                    if (imageValidationRules.maxHeight && imageValidationRules.maxHeight < height) {
                        errors.push('The image height needs to be below ' + imageValidationRules.maxHeight + 'px. (Currently ' + height + 'px)');
                    }
                    if (imageValidationRules.minSize && imageValidationRules.minSize > size) {
                        errors.push('The image size needs to be above ' + imageValidationRules.minSize + 'KB. (Currently ' + size + 'KB)');
                    }
                    if (imageValidationRules.maxSize && imageValidationRules.maxSize < size) {
                        errors.push('The image size needs to be below ' + imageValidationRules.maxSize + 'KB. (Currently ' + size + 'KB)');
                    }
                    if (imageValidationRules.fileTypes && imageValidationRules.fileTypes.indexOf(type.split('/')[1]) <= -1) {
                        errors.push('The image file type needs to be one of ' + imageValidationRules.fileTypes.join() + '. (Currently ' + type + ')');
                    }

                    displayImageValidationErrors($wrapper, errors);

                    if (errors.length <= 0 && $wrapper.find('.js-image-input').length > 0) {
                        $wrapper.find('.js-image-input').val(name);
                    }

//                console.log(type);
                };
                image.onerror= function() {
                    errors.push('Invalid file type: '  + file.type + '. Only images are allowed.');
                    displayImageValidationErrors($wrapper, errors);
                };
            };

        }

        // display error messages for the image validation
        function displayImageValidationErrors($wrapper, errors) {
            var errorsLength = errors.length;
            if (errorsLength <= 0) {
                if ($wrapper.next('.image-validation-errors')) $wrapper.next('.image-validation-errors').remove();
                $wrapper.removeClass('fileinput-error');
                return false;
            }

            // add a container for error messages
            if ($wrapper.next('.image-validation-errors').length <= 0) $wrapper.after('<ul class="image-validation-errors bg-danger text-danger"></ul>');
            var $errorContainer = $wrapper.next('.image-validation-errors');
            // remove previous errors
            $errorContainer.html('');
            // add an extra class to display errors differently with grouped images
            if($wrapper.hasClass('fileinput-grouped')) $errorContainer.addClass('image-validation-errors--boxed');

            // replace preview image by error
            //$wrapper.find('.fileinput-preview').html('<div class="text-danger bg-danger">Error</div>');
            $wrapper.addClass('fileinput-error');
            // clear file input
            //var $fileInput = $wrapper.find('input[type="file"]');
            //$fileInput.replaceWith($fileInput.val('').clone(true));
            $wrapper.fileinput('clear');

            // print errors
            for (var i = 0; i < errorsLength; i++) {
                $errorContainer.append('<li>' + errors[i] + '</li>');
            }
        }


        $(document).on("change.bs.fileinput", ".fileinput", function(e) {
            e.stopPropagation();
            var image = $(this).find('input[type="file"]').get(0).files[0];
            var imageValidationRules = $(this).find('input[type="file"]').data('image-validation');

//            console.log(imageValidationRules);
//            console.log(imageValidation[imageValidationRules]);
//
//            console.log(this);

            validateImage(image, imageValidation[imageValidationRules], $(this));
            return false;
        });

/*        $(document).on('click', '[data-dismiss="fileinput"]', function(e) {
            //var $fileInput = $(this).closest('.fileinput');
            //if ($fileInput.next('.image-validation-errors')) $fileInput.next('.image-validation-errors').remove();
        });*/

        $(document).on("clear.bs.fileinput", ".fileinput", function(e) {
            $(this).find('.js-image-input').val(null);
        });
    })();

    /**
     * Testimonials
     * -------------------------
     */
    (function() {

        function addTestimonial($button)
        {
            if ( typeof addTestimonial.index == 'undefined' ) {
                // It has not... perform the initialization
                addTestimonial.index = -2;
            }

            var $container = $button.closest('.js-testimonials');
            var $testimonial = $container.find('.js-testimonial.skeleton').clone();

            $testimonial.find('input, textarea, select').attr('disabled', false);
            $testimonial.html($testimonial.html().replace(/__testimonial_index__/g, addTestimonial.index));
            addTestimonial.index--;
            $testimonial.removeClass('hidden skeleton');

            $container.find('.js-testimonials-container').append($testimonial);

            $testimonial.find('.need-ckeditor').addClass('init-ckeditor').ckeditor();

            $testimonial.find('js-need-select2').select2();

            repositionTestimonials();
        }

        function repositionTestimonials()
        {
            $('.js-testimonials:not(.skeleton)').each(function() {
                var $container = $(this).find('.js-testimonials-container');
                var l = $container.find('.js-testimonial').length - 1;

                // disabled the add slide button when the maximum allowed amount of slides is reached
                if (l + 1 >= $(this).data('maxlength')) $(this).find('.js-testimonials-add').attr('disabled', true);
                else                                    $(this).find('.js-testimonials-add').attr('disabled', false);

                $container.find('.js-testimonial').each(function(i)
                {
                    $(this).find('.js-testimonial-weight').val(i);

                    if (i === 0) $(this).find('.js-testimonial-up').hide();
                    else       $(this).find('.js-testimonial-up').show();

                    if (i === l) $(this).find('.js-testimonial-down').hide();
                    else       $(this).find('.js-testimonial-down').show();

                    // hide the remove button if there is only 1 testimonial
                    if (l === 0) $(this).find('.js-testimonial-remove').hide();
                    else        $(this).find('.js-testimonial-remove').show();
                });
            });
        }

        function moveTestimonial(direction, $elem)
        {
            destroyCkeditor($elem.find('.init-ckeditor'));

            // Copy the values of input fields, otherwise we will loose freshly typed values in the cloning process
            $elem.find('input, textarea, select').each(function(){
                if ($(this).attr('type') != 'file') {
                    $(this).val($elem.find('[name="' + $(this).attr('name') + '"]').val());
                }
            });

            if (direction == 'up')   $elem.prev().before($elem);
            if (direction == 'down') $elem.next().after($elem);

            $elem.find('.init-ckeditor').ckeditor();

            repositionTestimonials();
        }


        $(document).on('click', '.js-testimonials-add', function(e) {
            if (!$(this).is('[disabled=disabled]')) addTestimonial($(this));
            return e.preventDefault();
        });

        $(document).on('click', '.js-testimonial-up', function(e) {
            moveTestimonial('up', $(this).closest('.js-testimonial'));
            return e.preventDefault();
        });

        $(document).on('click', '.js-testimonial-down', function(e) {
            moveTestimonial('down', $(this).closest('.js-testimonial'));
            return e.preventDefault();
        });

        $(document).on('click', '.js-testimonial-remove', function(e) {
            $(this).closest('.js-testimonial').remove();
            repositionTestimonials();
            return e.preventDefault();
        });

        repositionTestimonials();
    })();


    /**
     * Slides positioning
     * -------------------------
     */
    (function() {

        function addSlide($button)
        {
            if ( typeof addSlide.index == 'undefined' ) {
                // It has not... perform the initialization
                addSlide.index = -2;
            }

            var $container = $button.closest('.js-slider');
            var $slide = $container.find('.js-slide.skeleton').clone();

            $slide.find('input, textarea, select').attr('disabled', false);
            $slide.html($slide.html().replace(/__slide_index__/g, addSlide.index));
            addSlide.index--;
            $slide.removeClass('hidden skeleton');

            $container.find('.js-slides-container').append($slide);

            repositionSlides();
        }

        function repositionSlides()
        {
            $('.js-slider:not(.skeleton)').each(function() {
                var $container = $(this).find('.js-slides-container');
                var l = $container.find('.js-slide').length - 1;

                // disabled the add slide button when the maximum allowed amount of slides is reached
                if (l + 1 >= $(this).data('maxlength')) $(this).find('.js-slides-add').attr('disabled', true);
                else                                    $(this).find('.js-slides-add').attr('disabled', false);

                $container.find('.js-slide').each(function(i)
                {
                    $(this).find('.js-slide-weight').val(i);

                    if (i === 0) $(this).find('.js-slide-up').hide();
                    else       $(this).find('.js-slide-up').show();

                    if (i === l) $(this).find('.js-slide-down').hide();
                    else       $(this).find('.js-slide-down').show();

                    // hide the remove button if there is only 1 slide
                    if (l === 0) $(this).find('.js-slide-remove').hide();
                    else        $(this).find('.js-slide-remove').show();
                });
            });
        }

        function moveSlide(direction, $elem)
        {
            if(direction == 'up')   $elem.prev().before($elem);
            if(direction == 'down') $elem.next().after($elem);

            repositionSlides();
        }


        $(document).on('click', '.js-slides-add', function(e) {
            if (!$(this).is('[disabled=disabled]')) addSlide($(this));
            return e.preventDefault();
        });

        $(document).on('click', '.js-slide-up', function(e) {
            moveSlide('up', $(this).closest('.js-slide'));
            return e.preventDefault();
        });

        $(document).on('click', '.js-slide-down', function(e) {
            moveSlide('down', $(this).closest('.js-slide'));
            return e.preventDefault();
        });

        $(document).on('click', '.js-slide-remove', function(e) {
            $(this).closest('.js-slide').remove();
            repositionSlides();
            return e.preventDefault();
        });

        repositionSlides();
    })();


    /**
     * CMS CTA block
     * -------------------------
     */
    (function() {



    })();


    /**
     * CMS blocks positioning
     * -------------------------
     */
    (function() {


        function addBlock()
        {
            if ( typeof addBlock.index == 'undefined' ) {
                // It has not... perform the initialization
                addBlock.index = -1;
            }

            var type = $('.block-add').find('.block-add-select').val();
            if (type == '-1') return false;

            var $block = $(document).find('.block-type-' + type + '.skeleton').clone();
            $block.find('input, textarea, select').each(function() {
                if(!$(this).hasClass('inner-skeleton')) $(this).attr('disabled', false);
            });
            $block.html($block.html().replace(/__index__/g, addBlock.index));
            addBlock.index--;
            $block.removeClass('hidden skeleton');

            $('.blocks-container').append($block);

            $block.find('.need-ckeditor').addClass('init-ckeditor').ckeditor();

            repositionBlocks();

            if(type == 'cta') {
                repositionCTAs();
            }
        }

        function moveBlock(direction, $elem)
        {
            destroyCkeditor($elem.find('.init-ckeditor'));

            // Copy the values of input fields, otherwise we will loose freshly typed values in the cloning process
            $elem.find('input, textarea, select').each(function(){
                if ($(this).attr('type') != 'file') {
                    $(this).val($elem.find('[name="' + $(this).attr('name') + '"]').val());
                }
            });

            if(direction == 'up')   $elem.prev().before($elem);
            if(direction == 'down') $elem.next().after($elem);

            $elem.find('.init-ckeditor').ckeditor();

            repositionBlocks();
        }

        function repositionBlocks()
        {
            var l = ($('.blocks-container > .block-wrap').length - 1);

            $('.blocks-container > .block-wrap').each(function(i)
            {
                $(this).find('.block-weight').val(i);

                if (i === 0) $(this).find('.block-up-link').hide();
                else        $(this).find('.block-up-link').show();

                if (i === l) $(this).find('.block-down-link').hide();
                else        $(this).find('.block-down-link').show();
            });
        }

        $(document).on('click', '.block-up-link', function(e) {
            moveBlock('up', $(this).closest('.block-wrap'));
            return e.preventDefault();
        });

        $(document).on('click', '.block-down-link', function(e) {
            moveBlock('down', $(this).closest('.block-wrap'));
            return e.preventDefault();
        });

        $(document).on('click', '.block-remove-link', function(e) {
            destroyCkeditor($(this).closest('.block-wrap').find('.init-ckeditor'));
            $(this).closest('.block-wrap').remove();
            repositionBlocks();
            return e.preventDefault();
        });

        $(document).on('click', '.block-add-link', function(e) {
            addBlock();
            return e.preventDefault();
        });

        repositionBlocks();


        // CTA block positioning
        // --------------------------

        function addCTA($button)
        {
            if ( typeof addCTA.index == 'undefined' ) {
                // It has not... perform the initialization
                addCTA.index = -2;
            }

            var $container = $button.closest('.block-type-cta');
            var $cta = $container.find('.js-cta.skeleton').clone();

            $cta.find('input, textarea, select').attr('disabled', false);
            $cta.html($cta.html().replace(/__cta-index__/g, addCTA.index));
            addCTA.index--;
            $cta.removeClass('hidden skeleton');

            $container.find('.js-ctas-container').append($cta);

            repositionCTAs();
        }

        function repositionCTAs()
        {
            $('.block-type-cta:not(.skeleton)').each(function() {
                var $container = $(this).find('.js-ctas-container');
                var l = $container.find('.js-cta').length - 1;

                // disabled the add cta button when the maximum allowed amount of ctas is reached
                if (l + 1 >= $(this).data('maxlength')) $(this).find('.js-ctas-add').attr('disabled', true);
                else                                    $(this).find('.js-ctas-add').attr('disabled', false);

                $container.find('.js-cta').each(function(i)
                {
                    $(this).find('.js-cta-weight').val(i);

                    if (i === 0) $(this).find('.js-cta-up').hide();
                    else       $(this).find('.js-cta-up').show();

                    if (i === l) $(this).find('.js-cta-down').hide();
                    else       $(this).find('.js-cta-down').show();

                    // hide the remove button if there is only 1 cta
                    if (l === 0) $(this).find('.js-cta-remove').hide();
                    else        $(this).find('.js-cta-remove').show();
                });
            });
        }

        function moveCTA(direction, $elem)
        {
            if(direction == 'up')   $elem.prev().before($elem);
            if(direction == 'down') $elem.next().after($elem);

            repositionCTAs();
        }


        $(document).on('click', '.js-ctas-add', function(e) {
            if (!$(this).is('[disabled=disabled]')) addCTA($(this));
            return e.preventDefault();
        });

        $(document).on('click', '.js-cta-up', function(e) {
            moveCTA('up', $(this).closest('.js-cta'));
            return e.preventDefault();
        });

        $(document).on('click', '.js-cta-down', function(e) {
            moveCTA('down', $(this).closest('.js-cta'));
            return e.preventDefault();
        });

        $(document).on('click', '.js-cta-remove', function(e) {
            $(this).closest('.js-cta').remove();
            repositionCTAs();
            return e.preventDefault();
        });

        repositionCTAs();

        // disable the CTA link field for admissions or contact link types
        // those work with a modal class, not a link
        $(document).on('change', '.js-cta-type', function() {
            var $container = $(this).closest('.js-cta');

            if ($(this).val() == 'contact' || $(this).val() == 'admissions') {
                $container.find('.js-cta-link').attr('disabled', 'disabled');
            }
            else {
                $container.find('.js-cta-link').removeAttr('disabled');
            }
        });

    })();

}(jQuery));