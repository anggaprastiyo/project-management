@extends('layouts.admin')
@section('content')

    <div class="card">
        <div class="card-header">
            {{ trans('global.create') }} {{ trans('cruds.project.title_singular') }}
        </div>

        <div class="card-body">
            <form method="POST" action="{{ route("admin.projects.store") }}" enctype="multipart/form-data">
                @csrf
                <div class="form-group">
                    <label for="cover_image">{{ trans('cruds.project.fields.cover_image') }}</label>
                    <div class="needsclick dropzone {{ $errors->has('cover_image') ? 'is-invalid' : '' }}"
                         id="cover_image-dropzone">
                    </div>
                    @if($errors->has('cover_image'))
                        <span class="text-danger">{{ $errors->first('cover_image') }}</span>
                    @endif
                    <span class="help-block">{{ trans('cruds.project.fields.cover_image_helper') }}</span>
                </div>
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>{{ trans('cruds.project.fields.team') }}</label>
                            <select class="form-control {{ $errors->has('team') ? 'is-invalid' : '' }}" name="team"
                                    id="team">
                                <option value disabled {{ old('team', null) === null ? 'selected' : '' }}>{{ trans('global.pleaseSelect') }}</option>
                                @foreach(App\Models\Project::TEAM_SELECT as $key => $label)
                                    <option value="{{ $key }}" {{ old('team', 'internal') === (string) $key ? 'selected' : '' }}>{{ $label }}</option>
                                @endforeach
                            </select>
                            @if($errors->has('team'))
                                <span class="text-danger">{{ $errors->first('team') }}</span>
                            @endif
                            <span class="help-block">{{ trans('cruds.project.fields.team_helper') }}</span>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label class="required" for="name">{{ trans('cruds.project.fields.name') }}</label>
                            <input class="form-control {{ $errors->has('name') ? 'is-invalid' : '' }}" type="text"
                                   name="name" oninput="projectName(this)"
                                   id="name" value="{{ old('name', '') }}" required>
                            @if($errors->has('name'))
                                <span class="text-danger">{{ $errors->first('name') }}</span>
                            @endif
                            <span class="help-block">{{ trans('cruds.project.fields.name_helper') }}</span>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label class="required"
                                   for="ticket_prefix">{{ trans('cruds.project.fields.ticket_prefix') }}</label>
                            <input class="form-control {{ $errors->has('ticket_prefix') ? 'is-invalid' : '' }}"
                                   type="text" maxlength="3" oninput="ticketPrefix(this)"
                                   name="ticket_prefix" id="ticket_prefix" value="{{ old('ticket_prefix', '') }}"
                                   required>
                            @if($errors->has('ticket_prefix'))
                                <span class="text-danger">{{ $errors->first('ticket_prefix') }}</span>
                            @endif
                            <span class="help-block">{{ trans('cruds.project.fields.ticket_prefix_helper') }}</span>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label class="required"
                                   for="project_owner_id">{{ trans('cruds.project.fields.project_owner') }}</label>
                            <select class="form-control select2 {{ $errors->has('project_owner') ? 'is-invalid' : '' }}"
                                    name="project_owner_id" id="project_owner_id" required>
                                @foreach($project_owners as $id => $entry)
                                    <option
                                        value="{{ $id }}" {{ old('project_owner_id') == $id ? 'selected' : '' }}>{{ $entry }}</option>
                                @endforeach
                            </select>
                            @if($errors->has('project_owner'))
                                <span class="text-danger">{{ $errors->first('project_owner') }}</span>
                            @endif
                            <span class="help-block">{{ trans('cruds.project.fields.project_owner_helper') }}</span>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label class="required"
                                   for="project_status_id">{{ trans('cruds.project.fields.project_status') }}</label>
                            <select
                                class="form-control select2 {{ $errors->has('project_status') ? 'is-invalid' : '' }}"
                                name="project_status_id" id="project_status_id" required>
                                @foreach($project_statuses as $id => $entry)
                                    <option
                                        value="{{ $id }}" {{ old('project_status_id') == $id ? 'selected' : '' }}>{{ $entry }}</option>
                                @endforeach
                            </select>
                            @if($errors->has('project_status'))
                                <span class="text-danger">{{ $errors->first('project_status') }}</span>
                            @endif
                            <span class="help-block">{{ trans('cruds.project.fields.project_status_helper') }}</span>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label class="required">{{ trans('cruds.project.fields.type') }}</label>
                            <select class="form-control {{ $errors->has('type') ? 'is-invalid' : '' }}" name="type"
                                    id="type"
                                    required>
                                <option value
                                        disabled {{ old('type', null) === null ? 'selected' : '' }}>{{ trans('global.pleaseSelect') }}</option>
                                @foreach(App\Models\Project::TYPE_SELECT as $key => $label)
                                    <option
                                        value="{{ $key }}" {{ old('type', 'kanban') === (string) $key ? 'selected' : '' }}>{{ $label }}</option>
                                @endforeach
                            </select>
                            @if($errors->has('type'))
                                <span class="text-danger">{{ $errors->first('type') }}</span>
                            @endif
                            <span class="help-block">{{ trans('cruds.project.fields.type_helper') }}</span>
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <label class="required" for="members">{{ trans('cruds.project.fields.member') }}</label>
                    <div style="padding-bottom: 4px">
                        <span class="btn btn-info btn-xs select-all"
                              style="border-radius: 0">{{ trans('global.select_all') }}</span>
                        <span class="btn btn-info btn-xs deselect-all"
                              style="border-radius: 0">{{ trans('global.deselect_all') }}</span>
                    </div>
                    <select disabled class="form-control select2 {{ $errors->has('members') ? 'is-invalid' : '' }}" name="members[]" id="members" multiple required></select>
                    @if($errors->has('members'))
                        <span class="text-danger">{{ $errors->first('members') }}</span>
                    @endif
                    <span class="help-block">{{ trans('cruds.project.fields.member_helper') }}</span>
                </div>

                <div class="form-group">
                    <label for="description">{{ trans('cruds.project.fields.description') }}</label>
                    <textarea class="form-control ckeditor {{ $errors->has('description') ? 'is-invalid' : '' }}"
                              name="description" id="description">{!! old('description') !!}</textarea>
                    @if($errors->has('description'))
                        <span class="text-danger">{{ $errors->first('description') }}</span>
                    @endif
                    <span class="help-block">{{ trans('cruds.project.fields.description_helper') }}</span>
                </div>

                <div class="form-group">
                    <label>{{ trans('cruds.project.fields.status_type') }}</label>
                    <select class="form-control {{ $errors->has('status_type') ? 'is-invalid' : '' }}"
                            name="status_type" id="status_type">
                        <option value
                                disabled {{ old('status_type', null) === null ? 'selected' : '' }}>{{ trans('global.pleaseSelect') }}</option>
                        @foreach(App\Models\Project::STATUS_TYPE_SELECT as $key => $label)
                            <option
                                value="{{ $key }}" {{ old('status_type', 'default') === (string) $key ? 'selected' : '' }}>{{ $label }}</option>
                        @endforeach
                    </select>
                    @if($errors->has('status_type'))
                        <span class="text-danger">{{ $errors->first('status_type') }}</span>
                    @endif
                    <span class="help-block">{{ trans('cruds.project.fields.status_type_helper') }}</span>
                </div>

                <div class="form-group">
                    <button class="btn btn-danger" type="submit">
                        {{ trans('global.save') }}
                    </button>
                </div>
            </form>
        </div>
    </div>

@endsection

@section('scripts')
    <script>
        Dropzone.options.coverImageDropzone = {
            url: '{{ route('admin.projects.storeMedia') }}',
            maxFilesize: 5, // MB
            acceptedFiles: '.jpeg,.jpg,.png,.gif',
            maxFiles: 1,
            addRemoveLinks: true,
            headers: {
                'X-CSRF-TOKEN': "{{ csrf_token() }}"
            },
            params: {
                size: 5,
                width: 4096,
                height: 4096
            },
            success: function (file, response) {
                $('form').find('input[name="cover_image"]').remove()
                $('form').append('<input type="hidden" name="cover_image" value="' + response.name + '">')
            },
            removedfile: function (file) {
                file.previewElement.remove()
                if (file.status !== 'error') {
                    $('form').find('input[name="cover_image"]').remove()
                    this.options.maxFiles = this.options.maxFiles + 1
                }
            },
            init: function () {
                @if(isset($project) && $project->cover_image)
                var file = {!! json_encode($project->cover_image) !!}
                this.options.addedfile.call(this, file)
                this.options.thumbnail.call(this, file, file.preview ?? file.preview_url)
                file.previewElement.classList.add('dz-complete')
                $('form').append('<input type="hidden" name="cover_image" value="' + file.file_name + '">')
                this.options.maxFiles = this.options.maxFiles - 1
                @endif
            },
            error: function (file, response) {
                if ($.type(response) === 'string') {
                    var message = response //dropzone sends it's own error messages in string
                } else {
                    var message = response.errors.file
                }
                file.previewElement.classList.add('dz-error')
                _ref = file.previewElement.querySelectorAll('[data-dz-errormessage]')
                _results = []
                for (_i = 0, _len = _ref.length; _i < _len; _i++) {
                    node = _ref[_i]
                    _results.push(node.textContent = message)
                }

                return _results
            }
        }

    </script>
    <script>
        $(document).ready(function () {
            function SimpleUploadAdapter(editor) {
                editor.plugins.get('FileRepository').createUploadAdapter = function (loader) {
                    return {
                        upload: function () {
                            return loader.file
                                .then(function (file) {
                                    return new Promise(function (resolve, reject) {
                                        // Init request
                                        var xhr = new XMLHttpRequest();
                                        xhr.open('POST', '{{ route('admin.projects.storeCKEditorImages') }}', true);
                                        xhr.setRequestHeader('x-csrf-token', window._token);
                                        xhr.setRequestHeader('Accept', 'application/json');
                                        xhr.responseType = 'json';

                                        // Init listeners
                                        var genericErrorText = `Couldn't upload file: ${file.name}.`;
                                        xhr.addEventListener('error', function () {
                                            reject(genericErrorText)
                                        });
                                        xhr.addEventListener('abort', function () {
                                            reject()
                                        });
                                        xhr.addEventListener('load', function () {
                                            var response = xhr.response;

                                            if (!response || xhr.status !== 201) {
                                                return reject(response && response.message ? `${genericErrorText}\n${xhr.status} ${response.message}` : `${genericErrorText}\n ${xhr.status} ${xhr.statusText}`);
                                            }

                                            $('form').append('<input type="hidden" name="ck-media[]" value="' + response.id + '">');

                                            resolve({default: response.url});
                                        });

                                        if (xhr.upload) {
                                            xhr.upload.addEventListener('progress', function (e) {
                                                if (e.lengthComputable) {
                                                    loader.uploadTotal = e.total;
                                                    loader.uploaded = e.loaded;
                                                }
                                            });
                                        }

                                        // Send request
                                        var data = new FormData();
                                        data.append('upload', file);
                                        data.append('crud_id', '{{ $project->id ?? 0 }}');
                                        xhr.send(data);
                                    });
                                })
                        }
                    };
                }
            }

            var allEditors = document.querySelectorAll('.ckeditor');
            for (var i = 0; i < allEditors.length; ++i) {
                ClassicEditor.create(
                    allEditors[i], {
                        extraPlugins: [SimpleUploadAdapter]
                    }
                );
            }

            getMember('internal')
        });

        $('#team').on('change', function() {
            var selectedTeam = $(this).val();
            getMember(selectedTeam)
        });

        function getMember(type) {
            $('#members').prop('disabled', true);
            $.ajax({
                headers: {'x-csrf-token': _token},
                url: '{{ route('admin.get-member') }}',
                data: { type: type },
                type: 'POST',
                success: function(response) {
                    $('#members').empty();
                    $.each(response, function(index, members) {
                        let optionValue = '<optgroup value="'+ members.text +'" label="'+ members.text +'">';
                        $.each(members.children, function(index, member) {
                            optionValue += '<option value="' + member.id + '">' + member.nik + ' - ' + member.name + ' (' + member.job_position_text + ')</option>'
                        })
                        optionValue += '</optgroup>'
                        $('#members').append(optionValue);
                    });
                    $('#members').prop('disabled', false);
                }
            });
        }

        function ticketPrefix(element) {
            // capitalize
            element.value = element.value.toUpperCase();
        }

        function projectName(element) z{
            // capitalize
            element.value = element.value.toUpperCase();
        }
    </script>

@endsection