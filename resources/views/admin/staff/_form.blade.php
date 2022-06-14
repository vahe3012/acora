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
                                <label class="col-form-label" for="fullname_am">@error('fullname_am')<i
                                            class="far fa-times-circle"></i>@enderror Անուն ազգանուն (հայերեն)</label>
                                <input type="text"
                                       class="form-control form-control-sm @error('fullname_am') is-invalid @enderror"
                                       id="fullname_am" name="fullname_am" value="{{ old('fullname_am') ?: (isset($staff) ? $staff->fullname_am : '') }}">
                                @error('fullname_am')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="form-group col-6">
                                <label class="col-form-label" for="fullname_en">@error('fullname_en')<i
                                            class="far fa-times-circle"></i>@enderror Անուն ազգանուն (անգլերեն)</label>
                                <input type="text"
                                       class="form-control form-control-sm @error('fullname_en') is-invalid @enderror"
                                       id="fullname_en" name="fullname_en" value="{{ old('fullname_en') ?: (isset($staff) ? $staff->fullname_en : '') }}">
                                @error('fullname_en')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="form-group col-6">
                                <label class="col-form-label" for="position_am">@error('position_am')<i
                                        class="far fa-times-circle"></i>@enderror Պաշտոն (հայերեն)</label>
                                <input type="text"
                                       class="form-control form-control-sm @error('position_am') is-invalid @enderror"
                                       id="position_am" name="position_am" value="{{ old('position_am') ?: (isset($staff) ? $staff->position_am : '') }}">
                                @error('position_am')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="form-group col-6">
                                <label class="col-form-label" for="position_en">@error('position_en')<i
                                        class="far fa-times-circle"></i>@enderror Պաշտոն (անգլերեն)</label>
                                <input type="text"
                                       class="form-control form-control-sm @error('position_en') is-invalid @enderror"
                                       id="position_en" name="position_en" value="{{ old('position_en') ?: (isset($staff) ? $staff->position_en : '') }}">
                                @error('position_en')
                                <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="form-group col-6 mb-4">
                                <label class="col-form-label" for="description_am">Նկարագրություն (հայերեն)</label>
                                <div class="input-group-sm">
                                    <textarea id="description_am" class="form-control @error('description_am') is-invalid @enderror ckeditor"
                                              name="description_am" rows="10">{{ old('description_am') ?: (isset($staff) ? $staff->description_am : '') }}</textarea>
                                    @error('description_am')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group col-6 mb-4">
                                <label class="col-form-label" for="description_en">Նկարագրություն (անգլերեն)</label>
                                <div class="input-group-sm">
                                    <textarea id="description_en" class="form-control @error('description_en') is-invalid @enderror ckeditor"
                                              name="description_en" rows="10">{{ old('description_en') ?: (isset($staff) ? $staff->description_en : '') }}</textarea>
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
                                                    @error('attachment_id') class="is-invalid" @enderror
                                                    :prop-selected-attachments="{{ json_encode(old('attachment_id') ? \App\Models\Attachment::where('id', old('attachment_id'))->get() : (isset($staff) ? [$staff->attachment] : []))}}"
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
