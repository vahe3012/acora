<form id="create-form" style="width: 100%;" action="{{ $action }}" method="post">
    @csrf
    @if(isset($method))
        @method($method)
    @endif
    <div class="container-fluid">
        <div class="card card-default">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-8">
                        <div class="form-group col-9">
                            <label class="col-form-label" for="title_am">@error('title_am')<i
                                    class="far fa-times-circle"></i>@enderror Վերնագիր (հայերեն)</label>
                            <input type="text"
                                   class="form-control form-control-sm @error('title_am') is-invalid @enderror"
                                   id="title_am" name="title_am" value="{{ old('title_am') ?: (isset($digitalImage) ? $digitalImage->title_am : '') }}">
                            @error('title_am')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="form-group col-9">
                            <label class="col-form-label" for="title_en">@error('title_en')<i
                                    class="far fa-times-circle"></i>@enderror Վերնագիր (անգլերեն)</label>
                            <input type="text"
                                   class="form-control form-control-sm @error('title_en') is-invalid @enderror"
                                   id="title_en" name="title_en" value="{{ old('title_en') ?: (isset($digitalImage) ? $digitalImage->title_en : '') }}">
                            @error('title_en')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="row">
                            <div class="col-6">
                                <div class="card card-default">
                                    <div class="card-header" data-card-widget="collapse">
                                        <div class="card-title">
                                            Նկար
                                        </div>
                                    </div>
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-12 p-0">
                                                <media-uploader
                                                    prop-input-name="attachment_id"
                                                    prop-size="full"
                                                    @error('attachment_id') class="is-invalid" @enderror
                                                    :prop-selected-attachments="{{ json_encode(old('attachment_id') ? \App\Models\Attachment::where('id', old('attachment_id'))->get() : (isset($digitalImage) ? [$digitalImage->attachment] : []))}}"
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
