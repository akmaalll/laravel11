@extends('admin._layouts.index')

{{-- @push('Data Master')
    here show
@endpush --}}

@push($title)
    active
@endpush

@section('content')
    <!--begin::Toolbar-->
    @component('admin._card.breadcrumb')
        @slot('header')
            {{ $title }}
        @endslot
        @slot('page')
            Form
        @endslot
    @endcomponent
    <!--end::Toolbar-->

    <!--begin::Content-->
    <div id="kt_app_content" class="app-content flex-column-fluid">
        <!--begin::Content container-->
        <div id="kt_app_content_container" class="app-container container-xxl">

            <!--begin::Tables Widget 10-->
            <div class="card mb-5 mb-xl-8">

                <!--begin::Header-->
                <div class="card-header align-items-center py-5 gap-2 gap-md-5">
                    <h3 class="card-title align-items-start flex-column">
                        <span class="card-label fw-bold fs-3 mb-1">Form {{ isset($data->nidn) ? 'Edit' : 'Input' }}</span>
                    </h3>
                </div>
                <!--end::Header-->

                <!--begin::Body-->
                <div class="card-body pt-3">

                    <div class="row mt-5">
                        <!--begin:Form-->
                        <form id="kt_modal_new_target_form" class="form" action="#">
                            <input name="_method" type="hidden" id="methodId"
                                value="{{ isset($data->nidn) ? 'PUT' : 'POST' }}">
                            <input type="hidden" name="id" id="formId" value="{{ $data->nidn ?? null }}">
                            @csrf

                            <!--begin::Input group-->
                            <div class="row g-9 mb-8">
                                <div class="col-md-6 fv-row">
                                    <label class="required fs-6 fw-semibold mb-2">Nidn</label>
                                    <input type="text" class="form-control" placeholder="Nidn" name="nidn"
                                        id="nidn" value="{{ $data->nidn ?? '' }}" />
                                </div>
                                <div class="col-md-6 fv-row">
                                    <label class="required fs-6 fw-semibold mb-2">Nama</label>
                                    <input type="text" class="form-control" placeholder="Name" name="nama"
                                        id="nama" value="{{ $data->nama ?? '' }}" />
                                </div>
                            </div>

                            <div class="row g-9 mb-8">
                                <div class="col-md-6 fv-row">
                                    <label class="required fs-6 fw-semibold mb-2">Email</label>
                                    <input type="email" class="form-control" placeholder="Email" name="email"
                                        id="email" value="{{ $data->email ?? '' }}" />
                                </div>
                                <div class="col-md-6 fv-row">
                                    <label class="required fs-6 fw-semibold mb-2">Keahlian</label>

                                    <input class="form-control d-flex align-items-center" value=""
                                        placeholder="Tuliskan Keahlian" name="keahlian_ids" id="kt_tagify_users" />
                                    <input type="hidden" name="keahlian_ids_values" id="keahlian_ids_values" />

                                    {{-- <div class="mb-0">
                                        <label class="form-label">Solid background style</label>
                                        <input class="form-control form-control-solid" value="tag1, tag2, tag3"
                                            id="kt_tagify_2" />
                                    </div> --}}
                                    {{-- <select class="form-select" data-control="select2" data-hide-search="true"
                                        data-placeholder="Select a Keahlian" name="id_keahlian" id="id_keahlian">
                                        <option value="">Select user...</option>
                                        @foreach (Helper::getData('mst_keahlians') as $v)
                                            <option
                                                {{ isset($data->id_keahlian) && $data->id_keahlian == $v->id ? 'selected' : '' }}
                                                value="{{ $v->id }}">{{ $v->nama }}</option>
                                        @endforeach
                                    </select> --}}
                                </div>
                            </div>
                            <!--end::Input group-->

                            <!--begin::Actions-->
                            <div class="d-flex justify-content-end">
                                <a href="{{ route($title . '.index') }}">
                                    <button type="button" id="kt_modal_new_target_cancel" class="btn btn-secondary me-3"
                                        data-bs-dismiss="modal">Batal</button>
                                </a>
                                @if (isset($data->nidn))
                                    <button type="submit" id="kt_modal_new_target_update" class="btn btn-primary">
                                        <span class="indicator-label">Update</span>
                                        <span class="indicator-progress">Please wait...
                                            <span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
                                    </button>
                                @else
                                    <button type="submit" id="kt_modal_new_target_save" class="btn btn-primary">
                                        <span class="indicator-label">Simpan</span>
                                        <span class="indicator-progress">Please wait...
                                            <span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
                                    </button>
                                @endif
                            </div>
                            <!--end::Actions-->

                        </form>
                        <!--end:Form-->
                    </div>

                </div>
                <!--begin::Body-->
            </div>
            <!--end::Tables Widget 10-->

        </div>
        <!--end::Content container-->
    </div>
    <!--end::Content-->
@endsection

@push('jsScriptForm')
    <script type="text/javascript">
        // Define form element
        const form = document.getElementById('kt_modal_new_target_form');

        // Init form validation rules. For more info check the FormValidation plugin's official documentation:https://formvalidation.io/
        var validator = FormValidation.formValidation(
            form, {
                fields: {
                    'name': {
                        validators: {
                            notEmpty: {
                                message: 'Nama is required'
                            }
                        }
                    },
                    'code': {
                        validators: {
                            notEmpty: {
                                message: 'Kode is required'
                            }
                        }
                    },
                },

                plugins: {
                    trigger: new FormValidation.plugins.Trigger(),
                    bootstrap: new FormValidation.plugins.Bootstrap5({
                        rowSelector: '.fv-row',
                        eleInvalidClass: '',
                        eleValidClass: ''
                    })
                },

            }
        );

        var inputElm = document.querySelector('#kt_tagify_users');

        const usersList = [
            @foreach (Helper::getData('mst_keahlians') as $keahlian)
                {
                    id: '{{ $keahlian->id }}',
                    value: '{{ $keahlian->nama }}'
                },
            @endforeach
        ];

        function tagTemplate(tagData) {
            return `
        <tag title="${(tagData.value)}"
                contenteditable='false'
                spellcheck='false'
                tabIndex="-1"
                class="${this.settings.classNames.tag} ${tagData.class ? tagData.class : ""}"
                ${this.getAttributes(tagData)}>
            <x title='' class='tagify__tag__removeBtn' role='button' aria-label='remove tag'></x>
            <div class="d-flex align-items-center">
                <span class='tagify__tag-text'>${tagData.value}</span>
            </div>
        </tag>
    `
        }

        function suggestionItemTemplate(tagData) {
            return `
        <div ${this.getAttributes(tagData)}
            class='tagify__dropdown__item d-flex align-items-center ${tagData.class ? tagData.class : ""}'
            tabindex="0"
            role="option">

            <div class="d-flex flex-column">
                <span>${tagData.value}</span>
            </div>
        </div>
    `
        }

        // initialize Tagify on the above input node reference
        var tagify = new Tagify(inputElm, {
            tagTextProp: 'value', // very important since a custom template is used with this property as text. allows typing a "value" or a "name" to match input with whitelist
            enforceWhitelist: true,
            skipInvalid: true, // do not remporarily add invalid tags
            dropdown: {
                closeOnSelect: false,
                enabled: 0,
                classname: 'users-list',
                searchKeys: ['value'] // very important to set by which keys to search for suggesttions when typing
            },
            templates: {
                tag: tagTemplate,
                dropdownItem: suggestionItemTemplate
            },
            whitelist: usersList,
            originalInputValueFormat: valuesArr => valuesArr.map(item => item.id).join(',')
        })

        tagify.on('change', function(e) {
            document.getElementById('keahlian_ids_values').value = e.detail.value;
        });

        tagify.on('dropdown:show dropdown:updated', onDropdownShow)
        tagify.on('dropdown:select', onSelectSuggestion)

        var addAllSuggestionsElm;

        function onDropdownShow(e) {
            var dropdownContentElm = e.detail.tagify.DOM.dropdown.content;

            if (tagify.suggestedListItems.length > 1) {
                addAllSuggestionsElm = getAddAllSuggestionsElm();

                console.log(addAllSuggestionsElm)
                // insert "addAllSuggestionsElm" as the first element in the suggestions list
                dropdownContentElm.insertBefore(addAllSuggestionsElm, dropdownContentElm.firstChild)
            }
        }


        function onSelectSuggestion(e) {
            if (e.detail.elm == addAllSuggestionsElm)
                tagify.dropdown.selectAll.call(tagify);
        }

        // create a "add all" custom suggestion element every time the dropdown changes
        function getAddAllSuggestionsElm() {
            // suggestions items should be based on "dropdownItem" template
            return tagify.parseTemplate('dropdownItem', [{
                class: "addAll",
                value: "Add all",
            }])
        }

        // // proses save data
        // const submitButton = document.getElementById('kt_modal_new_target_save');
        // submitButton.addEventListener('click', function(e) {
        //     // Prevent default button action
        //     e.preventDefault();

        //     // Validate form before submit
        //     if (validator) {
        //         validator.validate().then(function(status) {
        //             if (status == 'Valid') {
        //                 // Show loading indication
        //                 submitButton.setAttribute('data-kt-indicator', 'on');
        //                 submitButton.disabled = true;
        //                 let formData = new FormData(kt_modal_new_target_form);

        //                 $.ajax({
        //                     headers: {
        //                         'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr(
        //                             'content')
        //                     },
        //                     data: formData,
        //                     url: "{{ route($title . '.store') }}",
        //                     type: "POST",
        //                     dataType: 'json',
        //                     processData: false,
        //                     contentType: false,
        //                     success: function(data) {
        //                         submitButton.removeAttribute('data-kt-indicator');
        //                         submitButton.disabled = false;
        //                         toastr.success("Successful save data!");
        //                         setTimeout(() => {
        //                             window.location.replace(
        //                                 "{{ route($title . '.index') }}"
        //                             );
        //                         }, 750);
        //                     },
        //                     error: function(data) {
        //                         submitButton.removeAttribute('data-kt-indicator');
        //                         submitButton.disabled = false;
        //                         console.log('Error:', data);
        //                         toastr.error("Failed to save data!");
        //                     }
        //                 });
        //             }
        //         });
        //     }
        // });
    </script>

    @if (isset($data->nidn))
        <script type="text/javascript">
            $(document).ready(function() {

                // proses update data
                const submitButtonUpdate = document.getElementById('kt_modal_new_target_update');
                submitButtonUpdate.addEventListener('click', function(e) {
                    // Prevent default button action
                    e.preventDefault();
                    const keahlianValues = document.getElementById('keahlian_ids_values').value;
                    // Validate form before submit
                    if (validator) {
                        validator.validate().then(function(status) {
                            if (status == 'Valid') {
                                // Show loading indication
                                submitButtonUpdate.setAttribute('data-kt-indicator', 'on');
                                submitButtonUpdate.disabled = true;
                                let formData = new FormData(kt_modal_new_target_form);
                                formData.append('keahlian_ids_values', keahlianValues);

                                let id = $('#formId').val();
                                $.ajax({
                                    headers: {
                                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr(
                                            'content')
                                    },
                                    data: formData,
                                    url: '{{ url("admin/$title") }}/' + id,
                                    type: "POST",
                                    dataType: 'json',
                                    processData: false,
                                    contentType: false,
                                    success: function(data) {
                                        console.log('data');
                                        if (data == 'konfirmasi password salah') {
                                            toastr.error("Konfirmasi password salah!");
                                            submitButtonUpdate.removeAttribute(
                                                'data-kt-indicator');
                                            submitButtonUpdate.disabled = false;
                                        } else {
                                            toastr.success("Successful update data!");
                                            setTimeout(() => {
                                                window.location.replace(
                                                    "{{ route($title . '.index') }}"
                                                );
                                            }, 750);
                                        }

                                    },
                                    error: function(data) {
                                        submitButtonUpdate.removeAttribute(
                                            'data-kt-indicator');
                                        submitButtonUpdate.disabled = false;
                                        toastr.error("Failed to update data!");
                                    }
                                });
                            }
                        });
                    }
                });

            });
        </script>
    @else
        @include('admin._card._createAjax')
    @endif

@endpush
