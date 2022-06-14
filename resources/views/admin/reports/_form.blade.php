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
                                            class="far fa-times-circle"></i>@enderror Վերնագիր (հայերեն)</label>
                                <input type="text"
                                       class="form-control form-control-sm @error('title_am') is-invalid @enderror"
                                       id="title_am" name="title_am" value="{{ old('title_am') ?: (isset($report) ? $report->title_am : '') }}">
                                @error('title')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="form-group col-6">
                                <label class="col-form-label" for="title_en">@error('title_en')<i
                                            class="far fa-times-circle"></i>@enderror Վերնագիր (անգլերեն)</label>
                                <input type="text"
                                       class="form-control form-control-sm @error('title') is-invalid @enderror"
                                       id="title_en" name="title_en" value="{{ old('title_en') ?: (isset($report) ? $report->title_en : '') }}">
                                @error('title')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="form-group col-6 mb-4">
                                <label class="col-form-label" for="description_am">Նկարագրություն (հայերեն)</label>
                                <div class="input-group-sm">
                                <textarea id="description_am" class="form-control @error('description_am') is-invalid @enderror ckeditor"
                                          name="description_am" rows="10">{{ old('description_am') ?: (isset($report) ? $report->description_am : '') }}</textarea>
                                    @error('description_am')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group col-6 mb-4">
                                <label class="col-form-label" for="description_en">Նկարագրություն (անգլերեն)</label>
                                <div class="input-group-sm">
                                    <textarea id="description_en" class="form-control @error('description_en') is-invalid @enderror ckeditor"
                                              name="description_en" rows="10">{{ old('description_en') ?: (isset($report) ? $report->description_en : '') }}</textarea>
                                    @error('description_en')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <a href="javascript:;" style="font-size: 35px;" class="add-folder"><strong>+</strong></a>
                        <div class="row files">
                            @if(isset($report) && $report->attachments)
                                @foreach($report->attachments as $index => $attachment)
                                    @include('admin.reports._file-folder', ['index' => $index, 'attachment' => $attachment])
                                @endforeach
                            @else
                                @include('admin.reports._file-folder', ['index' => 0])
                            @endif
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

@section('scripts')
    <script>
        $(() => {
            $('.add-folder').click(() => {

                let lastIndex = $('.file-folder').last().data('index')
                let nextIndex = parseInt(lastIndex) + 1
                let nextFileFolder = `<div class="col-md-3 col-sm-4 border border-5 mb-3 ml-2 p-2 file-folder" data-index="${nextIndex}">
                    <div class="form-group">
                        <label for="attachments[${nextIndex}][folder]">Ֆայլի անուն</label>
                        <input type="text" class="form-control" id="attachments[${nextIndex}][folder]" name="attachments[${nextIndex}][folder]">
                    </div>
                    <div class="form-group d-inline-block files-am">
                        <label for="attachments[${nextIndex}][files_am]" class="mr-3">Ֆայլեր (հայերեն)</label>
                        <div class="input-group">

                        </div>
                    </div>
                    <div class="form-group d-inline-block files-en">
                        <label for="attachments[${nextIndex}][files_en]" class="mr-3">Ֆայլեր (անգլերեն)</label>
                        <div class="input-group">

                        </div>
                    </div>
                </div>`

                $('.files').append(nextFileFolder)

                let mediaUploaderAM = `<media-uploader
                    prop-input-name="attachments[${nextIndex}][files_am]"
                    prop-button="Ընտրեք Ֆայլեր"
                    :prop-multiple="true"
                    prop-format="pdf"
                    :prop-selected-attachments="@json([])"
                ></media-uploader>`


                mediaUploaderAM = Vue.compile(mediaUploaderAM)
                new Vue({
                    render: mediaUploaderAM.render,
                    staticRenderFns: mediaUploaderAM.staticRenderFns
                }).$mount('.file-folder:last-of-type .files-am .input-group')


                let mediaUploaderEN = `<media-uploader
                    prop-input-name="attachments[${nextIndex}][files_en]"
                    prop-button="Ընտրեք Ֆայլեր"
                    :prop-multiple="true"
                    prop-format="pdf"
                    :prop-selected-attachments="@json([])"
                ></media-uploader>`


                mediaUploaderEN = Vue.compile(mediaUploaderEN)
                new Vue({
                    render: mediaUploaderEN.render,
                    staticRenderFns: mediaUploaderEN.staticRenderFns
                }).$mount('.file-folder:last-of-type .files-en .input-group')
            })
        })
    </script>
@endsection
