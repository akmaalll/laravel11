<script>
    $(document).ready(function() {
        // Set CSRF token for all AJAX requests
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        // Define step routes
        const stepRoutes = {
            1: '{{ route('pengajuan.step1') }}',
            2: '{{ route('pengajuan.step2') }}',
            3: '{{ route('pengajuan.step3') }}',
        };

        // Handle draft submission
        $('body').on('click', '.kt_formvalidation_step_draf', function() {
            handleFormSubmission('Draft');
        });

        // Handle submit button - SIMPLIFIED to prevent duplicate calls
        $('body').on('click', '.kt_formvalidation_step_submit', function(e) {
            e.preventDefault();
            const judul = document.getElementById('judul').value;
            localStorage.setItem('judul_pengajuan', judul);
            const predictedTopic = localStorage.getItem('predicted_topic');
            const sts = $(this).data('id');
            const formData = new FormData(document.getElementById('kt_formvalidation_step'));

            if ($('#step').val() == '3' && sts == 'Submit') {
                formData.append('statusSubmit', 'Submit');
            }

            handleFormSubmission('Submit', formData);
        });

        function handleFormSubmission(status, formData = null) {
            const submitButton = status === 'Draft' ?
                $('#kt_formvalidation_step_draf') : $('#kt_formvalidation_step_submit');

            submitButton.prop('disabled', true);
            submitButton.find('.indicator-label').hide();
            submitButton.find('.indicator-progress').show();

            // Use passed formData or create new one
            formData = formData || new FormData(document.getElementById('kt_formvalidation_step'));
            formData.append('statusSubmit', status);

            $.ajax({
                url: '{{ route('pengajuan.store') }}',
                type: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                success: function(response) {
                    if (response.success) {
                        if (response.redirect) {
                            window.location.href = response.redirect;
                            toastr.error(response.message);
                        } else {
                            handleSuccessResponse(response, status);
                        }
                    } else {
                        toastr.error(response.message || 'Operation failed');
                    }
                },
                error: function(xhr, status, error) {
                    if (xhr.responseJSON) {
                        // console.log(xhr.responseJSON);
                        if (xhr.responseJSON.message) {
                            errorMessage = xhr.responseJSON.message;
                        }

                        // Tampilkan validation errors jika ada
                        if (xhr.responseJSON.errors) {
                            showValidationErrors(xhr.responseJSON.errors);
                            return;
                        }
                    }

                    showErrorMessage(errorMessage);
                    toastr.error('Terjadi kesalahan saat memproses permintaan');
                },
                complete: function() {
                    submitButton.prop('disabled', false);
                    submitButton.find('.indicator-label').show();
                    submitButton.find('.indicator-progress').hide();
                }
            });
        }

        function showErrorMessage(message) {
            // Swal.fire({
            //     icon: 'error',
            //     title: 'Error!',
            //     text: message
            // });

            // Atau menggunakan toast notification
            toastr.error(message);
        }

        function showValidationErrors(errors) {
            let errorList = '';

            $.each(errors, function(field, messages) {
                $.each(messages, function(index, message) {
                    errorList += `<li>${message}</li>`;
                });
            });

            Swal.fire({
                icon: 'error',
                title: 'FIELD WAJIB DI ISI',
                html: `<ul style="text-align: left;">${errorList}</ul>`
            });
        }

        function handleSuccessResponse(response, status) {
            if (status === 'Draft') {
                toastr.success('Draft berhasil disimpan');
                window.location.href = "{{ route('pengajuan.index') }}";
                return;
            } else if (status === 'Submit') {
                const currentStep = parseInt($('#step').val());
                const nextStep = currentStep + 1;
                console.log(nextStep)

                if (nextStep == 2) {
                    // toastr.success('Pengajuan berhasil diselesaikan');
                    window.location.href = stepRoutes[2];
                } else if (nextStep == 3) {
                    // toastr.success(stepRoutes[3]);
                    window.location.href = stepRoutes[3];
                } else if (nextStep == 4) {
                    toastr.success('Pengajuan berhasil diselesaikan');
                    window.location.href = '{{ route('pengajuan.index') }}';
                }
                return;
            }
        }

        // Initialize step indicator
        updateStepIndicator(parseInt($('#step').val()));

        function updateStepIndicator(currentStep) {
            $('.step-item').removeClass('current').removeClass('completed');
            $('.step-item').each(function(index) {
                const stepNumber = index + 1;
                if (stepNumber < currentStep) {
                    $(this).addClass('completed');
                } else if (stepNumber === currentStep) {
                    $(this).addClass('current');
                }
            });
        }
    });
</script>
