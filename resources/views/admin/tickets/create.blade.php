@extends('layouts.admin')
@section('content')

    <div class="card">
        <div class="card-header">
            {{ trans('global.create') }} {{ trans('cruds.ticket.title_singular') }}
        </div>

        <div class="card-body">
            <form method="POST" action="{{ route("admin.tickets.store") }}" enctype="multipart/form-data">
                @csrf

                @if (!is_null($project))
                    <input type="hidden" name="project_id" value="{{ !is_null($project->id) ? $project->id : null }}">
                @else
                    <div class="form-group">
                        <label class="required" for="project_id">{{ trans('cruds.ticket.fields.project') }}</label>
                        <select class="form-control select2 {{ $errors->has('project') ? 'is-invalid' : '' }}"
                                name="project_id" id="project_id" required>
                            @foreach($projects as $id => $entry)
                                <option
                                    value="{{ $entry->id }}" {{ old('project_id') == $entry->id ? 'selected' : '' }}>{{ $entry->name }}</option>
                            @endforeach
                        </select>
                        @if($errors->has('project'))
                            <span class="text-danger">{{ $errors->first('project') }}</span>
                        @endif
                        <span class="help-block">{{ trans('cruds.ticket.fields.project_helper') }}</span>
                    </div>
                @endif

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="required" for="name">{{ trans('cruds.ticket.fields.name') }}</label>
                            <input class="form-control {{ $errors->has('name') ? 'is-invalid' : '' }}" type="text"
                                   name="name" id="name" value="{{ old('name', '') }}" required>
                            @if($errors->has('name'))
                                <span class="text-danger">{{ $errors->first('name') }}</span>
                            @endif
                            <span class="help-block">{{ trans('cruds.ticket.fields.name_helper') }}</span>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="assigne_id">{{ trans('cruds.ticket.fields.assigne') }}</label>
                            <select class="form-control select2 {{ $errors->has('assigne') ? 'is-invalid' : '' }}"
                                    name="assigne_id" id="assigne_id">
                                @if (!is_null($project))
                                    @foreach($assignes as $key => $member)
                                        <optgroup label="{{$member['text']}}">
                                            @foreach($member['children'] as $data)
                                                <option
                                                    value="{{ $data['id'] }}" {{ old('assigne_id') == $data['id'] ? 'selected' : '' }}>{{ $data['nik'].' - '.$data['name'].' ('.$data['job_position_text'].')' }}</option>
                                            @endforeach
                                        </optgroup>
                                    @endforeach
                                @endif
                            </select>
                            @if($errors->has('assigne'))
                                <span class="text-danger">{{ $errors->first('assigne') }}</span>
                            @endif
                            <span class="help-block">{{ trans('cruds.ticket.fields.assigne_helper') }}</span>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-2">
                        <div class="form-group">
                            <label for="status_id">{{ trans('cruds.ticket.fields.status') }}</label>
                            <select class="form-control select2 {{ $errors->has('status') ? 'is-invalid' : '' }}"
                                    name="status_id" id="status_id">
                                @foreach($statuses as $id => $entry)
                                    <option
                                        value="{{ $id }}" {{ old('status_id') == $id ? 'selected' : '' }}>{{ $entry }}</option>
                                @endforeach
                            </select>
                            @if($errors->has('status'))
                                <span class="text-danger">{{ $errors->first('status') }}</span>
                            @endif
                            <span class="help-block">{{ trans('cruds.ticket.fields.status_helper') }}</span>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            <label for="type_id">{{ trans('cruds.ticket.fields.type') }}</label>
                            <select class="form-control select2 {{ $errors->has('type') ? 'is-invalid' : '' }}"
                                    name="type_id" id="type_id">
                                @foreach($types as $id => $entry)
                                    <option
                                        value="{{ $id }}" {{ old('type_id') == $id ? 'selected' : '' }}>{{ $entry }}</option>
                                @endforeach
                            </select>
                            @if($errors->has('type'))
                                <span class="text-danger">{{ $errors->first('type') }}</span>
                            @endif
                            <span class="help-block">{{ trans('cruds.ticket.fields.type_helper') }}</span>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            <label for="priority_id">{{ trans('cruds.ticket.fields.priority') }}</label>
                            <select class="form-control select2 {{ $errors->has('priority') ? 'is-invalid' : '' }}"
                                    name="priority_id" id="priority_id">
                                @foreach($priorities as $id => $entry)
                                    <option
                                        value="{{ $id }}" {{ old('priority_id') == $id ? 'selected' : '' }}>{{ $entry }}</option>
                                @endforeach
                            </select>
                            @if($errors->has('priority'))
                                <span class="text-danger">{{ $errors->first('priority') }}</span>
                            @endif
                            <span class="help-block">{{ trans('cruds.ticket.fields.priority_helper') }}</span>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="label">{{ trans('cruds.ticket.fields.label') }}</label>
                            <input class="form-control {{ $errors->has('label') ? 'is-invalid' : '' }}" type="text"
                                   name="label" id="label" value="{{ old('label', '') }}">
                            @if($errors->has('label'))
                                <span class="text-danger">{{ $errors->first('label') }}</span>
                            @endif
                            <span class="help-block">{{ trans('cruds.ticket.fields.label_helper') }}</span>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="point">{{ trans('cruds.ticket.fields.point') }}</label>
                            <input class="form-control {{ $errors->has('point') ? 'is-invalid' : '' }}" type="number"
                                   name="point" id="point" value="{{ old('point', '0') }}" step="1">
                            @if($errors->has('point'))
                                <span class="text-danger">{{ $errors->first('point') }}</span>
                            @endif
                            <span class="help-block">{{ trans('cruds.ticket.fields.point_helper') }}</span>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="content">{{ trans('cruds.ticket.fields.content') }}</label>
                            <textarea class="form-control ckeditor {{ $errors->has('content') ? 'is-invalid' : '' }}"
                                      name="content" id="content">{!! old('content') !!}</textarea>
                            @if($errors->has('content'))
                                <span class="text-danger">{{ $errors->first('content') }}</span>
                            @endif
                            <span class="help-block">{{ trans('cruds.ticket.fields.content_helper') }}</span>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="attachment">{{ trans('cruds.ticket.fields.attachment') }}</label>
                            <div class="needsclick dropzone {{ $errors->has('attachment') ? 'is-invalid' : '' }}"
                                 id="attachment-dropzone">
                            </div>
                            @if($errors->has('attachment'))
                                <span class="text-danger">{{ $errors->first('attachment') }}</span>
                            @endif
                            <span class="help-block">{{ trans('cruds.ticket.fields.attachment_helper') }}</span>
                        </div>
                    </div>
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
                                        xhr.open('POST', '{{ route('admin.tickets.storeCKEditorImages') }}', true);
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
                                        data.append('crud_id', '{{ $ticket->id ?? 0 }}');
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
        });
    </script>

    <script>
        var uploadedAttachmentMap = {}
        Dropzone.options.attachmentDropzone = {
            url: '{{ route('admin.tickets.storeMedia') }}',
            maxFilesize: 10, // MB
            addRemoveLinks: true,
            headers: {
                'X-CSRF-TOKEN': "{{ csrf_token() }}"
            },
            params: {
                size: 10
            },
            success: function (file, response) {
                $('form').append('<input type="hidden" name="attachment[]" value="' + response.name + '">')
                uploadedAttachmentMap[file.name] = response.name
            },
            removedfile: function (file) {
                file.previewElement.remove()
                var name = ''
                if (typeof file.file_name !== 'undefined') {
                    name = file.file_name
                } else {
                    name = uploadedAttachmentMap[file.name]
                }
                $('form').find('input[name="attachment[]"][value="' + name + '"]').remove()
            },
            init: function () {
                @if(isset($ticket) && $ticket->attachment)
                var files =
                    {!! json_encode($ticket->attachment) !!}
                    for(var i in files) {
                        var file = files[i]
                        this.options.addedfile.call(this, file)
                        file.previewElement.classList.add('dz-complete')
                        $('form').append('<input type="hidden" name="attachment[]" value="' + file.file_name + '">')
                    }
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
@endsection