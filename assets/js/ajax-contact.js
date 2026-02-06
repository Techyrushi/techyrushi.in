/**
*
* -----------------------------------------------------------------------------
*
* Template : Techyrushi - IT Solutions & Technology 
* Author : rs-theme
* Author URI : http://www.rstheme.com/
*
* -----------------------------------------------------------------------------
*
**/

(function($) {
    'use strict';
    
    // Listen for submit on any form with class 'ajax-form'
    $('.ajax-form').on('submit', function(e) {
        // Stop the browser from submitting the form.
        e.preventDefault();
        
        var form = $(this);
        // Find message container inside the form or fallback to global ID
        var formMessages = form.find('.form-message').length > 0 ? form.find('.form-message') : $('#form-messages');
        
        // Get the submit button
        var submitBtn = form.find('button[type="submit"]');
        var originalBtnText = submitBtn.html();

        // Disable button and show spinner
        submitBtn.prop('disabled', true);
        submitBtn.html('<i class="fa fa-spinner fa-spin"></i> Sending...');

        // Serialize the form data.
        var formData = form.serialize();

        // Submit the form using AJAX.
        $.ajax({
            type: 'POST',
            url: form.attr('action'),
            data: formData,
            dataType: 'json'
        })
        .done(function(response) {
            // Re-enable button
            submitBtn.prop('disabled', false);
            submitBtn.html(originalBtnText);

            if (response.status === 'success') {
                // Update message div if it exists
                if (formMessages.length > 0) {
                    formMessages.removeClass('error');
                    formMessages.addClass('success');
                    formMessages.text(response.message);
                }

                // SweetAlert Success
                Swal.fire({
                    icon: 'success',
                    title: 'Success!',
                    text: response.message,
                    confirmButtonColor: '#0056b3',
                    customClass: {
                        confirmButton: 'main-btn'
                    },
                    didOpen: () => {
                        // Apply custom black style
                        const confirmBtn = Swal.getConfirmButton();
                        if (confirmBtn) {
                            confirmBtn.style.background = '#000000';
                            confirmBtn.style.color = '#ffffff';
                            confirmBtn.style.border = '2px solid #000000';
                            confirmBtn.style.padding = '12px 35px';
                            confirmBtn.style.borderRadius = '5px';
                            confirmBtn.style.fontSize = '16px';
                            confirmBtn.style.fontWeight = 'bold';
                            confirmBtn.style.boxShadow = '0 5px 15px rgba(0, 0, 0, 0.2)';
                            confirmBtn.style.textTransform = 'uppercase';
                        }
                    }
                });

                // Clear the form.
                form[0].reset();
                
                // Reset Recaptcha if exists
                if(typeof grecaptcha !== 'undefined' && grecaptcha.reset) {
                    try {
                        grecaptcha.reset();
                    } catch(err) {
                        // Ignore if no captcha widget in this form
                    }
                }

            } else {
                // Error handling
                if (formMessages.length > 0) {
                    formMessages.removeClass('success');
                    formMessages.addClass('error');
                    formMessages.text(response.message);
                }

                // SweetAlert Error
                Swal.fire({
                    icon: 'error',
                    title: 'Error!',
                    text: response.message,
                    confirmButtonColor: '#d33',
                    didOpen: () => {
                        const confirmBtn = Swal.getConfirmButton();
                        if (confirmBtn) {
                            confirmBtn.style.background = '#000000';
                            confirmBtn.style.color = '#ffffff';
                            confirmBtn.style.border = '2px solid #000000';
                            confirmBtn.style.padding = '12px 35px';
                            confirmBtn.style.borderRadius = '5px';
                            confirmBtn.style.fontSize = '16px';
                            confirmBtn.style.fontWeight = 'bold';
                            confirmBtn.style.boxShadow = '0 5px 15px rgba(0, 0, 0, 0.2)';
                            confirmBtn.style.textTransform = 'uppercase';
                        }
                    }
                });
            }
        })
        .fail(function(data) {
            // Re-enable button
            submitBtn.prop('disabled', false);
            submitBtn.html(originalBtnText);

            var errorMsg = 'Oops! An error occured and your message could not be sent.';
            
            if (data.responseText !== '') {
                try {
                    var json = JSON.parse(data.responseText);
                    errorMsg = json.message || errorMsg;
                } catch(e) {
                    // errorMsg = data.responseText; 
                }
            }

            if (formMessages.length > 0) {
                formMessages.removeClass('success');
                formMessages.addClass('error');
                formMessages.text(errorMsg);
            }

            // SweetAlert Error
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: errorMsg,
                confirmButtonColor: '#d33',
                didOpen: () => {
                    const confirmBtn = Swal.getConfirmButton();
                    if (confirmBtn) {
                        confirmBtn.style.background = '#000000';
                        confirmBtn.style.color = '#ffffff';
                        confirmBtn.style.border = '2px solid #000000';
                        confirmBtn.style.padding = '12px 35px';
                        confirmBtn.style.borderRadius = '5px';
                        confirmBtn.style.fontSize = '16px';
                        confirmBtn.style.fontWeight = 'bold';
                        confirmBtn.style.boxShadow = '0 5px 15px rgba(0, 0, 0, 0.2)';
                        confirmBtn.style.textTransform = 'uppercase';
                    }
                }
            });
        });
    });

})(jQuery);