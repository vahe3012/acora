<form id="create-form" style="width: 100%;" action="{{ $action }}" method="post">
    @csrf
    @if(isset($method))
        @method($method)
    @endif
    <div class="container-fluid">
        <div class="card card-default">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-12">
                        <div class="row">
                            <div class="form-group col-6">
                                <label class="col-form-label" for="title_am">@error('title_am')<i
                                            class="far fa-times-circle"></i>@enderror Title AM</label>
                                <input type="text"
                                       class="form-control form-control-sm @error('title_am') is-invalid @enderror"
                                       id="title_am" name="title_am" value="{{ old('title_am') ?: (isset($program) ? $program->title_am : '') }}">
                                @error('title')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="form-group col-6">
                                <label class="col-form-label" for="title_en">@error('title_en')<i
                                            class="far fa-times-circle"></i>@enderror Title EN</label>
                                <input type="text"
                                       class="form-control form-control-sm @error('title') is-invalid @enderror"
                                       id="title_en" name="title_en" value="{{ old('title_en') ?: (isset($program) ? $program->title_en : '') }}">
                                @error('title')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="form-group col-6 mb-4">
                                <label class="col-form-label" for="description_am">Նկարագրություն (հայերեն)</label>
                                <div class="input-group-sm">
                                    <textarea id="description_am" class="form-control @error('description_am') is-invalid @enderror ckeditor"
                                              name="description_am" rows="10">{{ old('description_am') ?: (isset($program) ? $program->description_am : '') }}</textarea>
                                    @error('description_am')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group col-6 mb-4">
                                <label class="col-form-label" for="description_en">Նկարագրություն (անգլերեն)</label>
                                <div class="input-group-sm">
                                    <textarea id="description_en" class="form-control @error('description_en') is-invalid @enderror ckeditor"
                                              name="description_en" rows="10">{{ old('description_en') ?: (isset($program) ? $program->description_en : '') }}</textarea>
                                    @error('description_en')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="row pl-2">
                            <div class="col-4">
                                <div class="card card-default">
                                    <div class="card-header" data-card-widget="collapse">
                                        <div class="card-title">
                                            Ֆայլ
                                        </div>
                                    </div>
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-12 p-0">
                                                <media-uploader
                                                    prop-input-name="attachment_id"
                                                    prop-size="medium"
                                                    prop-format="pdf"
                                                    @error('attachment_id') class="is-invalid" @enderror
                                                    :prop-selected-attachments="{{ json_encode(old('attachment_id') ? \App\Models\Attachment::where('id', old('attachment_id'))->get() : (isset($program) ? [$program->attachment] : []))}}"
                                                ></media-uploader>
                                                @error('attachment_id')
                                                    <span class="invalid-feedback">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-footer">
                    <button type="submit" class="btn btn-default btn-outline-success float-right green-btn" form="create-form">Պահպանել</button>
                    <button id="reset-form" onclick="document.getElementById('create-form').reset()"
                            class="btn btn-default" type="reset">Վերակայել
                    </button>
                </div>
            </div>
        </div>
    </div>
</form>
