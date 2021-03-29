$(document).ready(function() {
    $("#success-alert").attr('hidden');
    $("#error-alert").hide();
    $('#reviewErrorMin').hide();
    $('#reviewErrorMax').hide();
    $('#cropSuccess').hide();


    let $star_rating = $('.star-rating .fas');

    let SetRatingStar = function() {
        return $star_rating.each(function() {
            if (parseInt($star_rating.siblings('input.rating-value').val()) >= parseInt($(this).data('rating'))) {
                return $(this).removeClass('text-secondary').addClass('text-warning');
            } else {
                return $(this).removeClass('text-warning').addClass('text-secondary');
            }
        });
    };

    $star_rating.on('click', function() {
        $star_rating.siblings('input.rating-value').val($(this).data('rating'));
        return SetRatingStar();
    });

    SetRatingStar();


    //  Variables
    let  reviewVal = false;

    // Validation
    $('#review').on('keyup', function() {
        let currentChar = this.value.length;
        $('#currentChar').text(currentChar);

        if (this.value.length > 200) {
            $('#reviewErrorMax').show();
            $('#charCount').removeClass('text-success').addClass('text-danger');
            reviewVal = false;
        } else{
            $('#reviewErrorMax').hide();
            $('#charCount').removeClass('text-danger').addClass('text-success');
            reviewVal = true;
        }
        if (this.value.length < 20) {
            $('#reviewErrorMin').show();
            $('#charCount').removeClass('text-success').addClass('text-danger');
            reviewVal = false;
        } else{
            $('#reviewErrorMin').hide();
            $('#charCount').removeClass('text-danger').addClass('text-success');
            reviewVal = true;
        }
    });

    // Validation on submit
    $('#submitButton').on('click', function submitForm(e) {

        let captchaResponse = grecaptcha.getResponse();
        e.preventDefault();

        recaptchaData = new FormData;
        recaptchaData.append('captchaResponse', captchaResponse);

        if (captchaResponse.length > 0) {
            axios.post('reCaptcha.php', recaptchaData)
                .then(resp => {
                    let isCaptcha = resp.data;
                    if (reviewVal && isCaptcha) {
                        $('#ModalLoginForm').modal('hide');
                        $('#checkinForm').submit();
                        grecaptcha.reset();
                        reviewVal = false;
                        $('#ModalLoginForm form :input').val("");
                        $('#rating').val("1");
                        $('#currentChar').text(0);
                        $('#charCount').removeClass('text-success').addClass('text-danger');
                        SetRatingStar();
                    }

                    if (!reviewVal) {
                        $("#error-alert").fadeTo(2000, 500).slideUp(500, function () {
                            $("#error-alert").slideUp(500);
                        })
                        if ($('#review').val().length < 20) {
                            $('#reviewErrorMin').show();
                        }
                        if ($('#review').val().length > 200) {
                            $('#reviewErrorMax').show();
                        }
                    }
                });
        } else {
            $("#error-alert").fadeTo(2000, 500).slideUp(500, function () {
                $("#error-alert").slideUp(500);
            })
        }
    })



    // Post the form to PHP and update check-ins section with new submission
    $('#checkinForm').on('submit', function (e) {

            // Force Ajax header
            axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

            // Setup for axios
            const rating = $('#rating').val();
            const review = $('#review').val();
            const product_id = $('#product_id').val();
            e.preventDefault();
            let data = new FormData();
            data.append('rating', rating);
            data.append('review', review);
            data.append('product_id', product_id);

            // Data to PHP and display alert
            axios.post('checkin_script.php', data)
                .then(function (response) {
                    console.log(response);
                    $("#success-alert").removeAttr('hidden').fadeTo(2000, 500).slideUp(500, function () {
                        $("#success-alert").slideUp(500);
                    })
                    SetRatingStar();
                    // Get the updated HTML from PHP
                    $('#checkins').load(document.URL +  ' #checkins');
                })
                .catch(function (error) {
                    console.log(error);
                })


    }
    )

    $('.search').on('keyup', function (e){
        if (e.keyCode === 13) {
            e.preventDefault();
            $('.searchBtn').click();
        }
    })

    $('.searchBtn').on('click', function() {
        window.location.href = "search.php?search=" + $('.search').val();
    })
})


