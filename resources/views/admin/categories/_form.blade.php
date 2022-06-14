<form id="create-form" style="width: 100%;" action="{{ $action }}" method="post">
    @csrf
    @if(isset($method))
        @method($method)
    @endif
    <div class="container-fluid">
        <div class="card card-default">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-9">
                        <div class="form-group row pl-3 pr-3">
                            <label class="col-form-label" for="inputError">@error('title_am')<i
                                    class="far fa-times-circle"></i>@enderror Վերնագիր (հայերեն)</label>
                            <input type="text" name="title_am"
                                   value="{{ old('title_am') ?: (isset($category) ? $category->title_am : '') }}"
                                   class="form-control form-control-sm @error('title_am') is-invalid @enderror">
                            @error('title_am')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group row pl-3 pr-3">
                            <label class="col-form-label" for="inputError">@error('title_en')<i
                                    class="far fa-times-circle"></i>@enderror Վերնագիր (անգլերեն)</label>
                            <input type="text" name="title_en"
                                   onkeyup="document.getElementById('slug_input').value= this.value.split(' ').join('-').toLowerCase()"
                                   value="{{ old('title_en') ?: (isset($category) ? $category->title_en : '') }}"
                                   class="form-control form-control-sm @error('title_en') is-invalid @enderror">
                            @error('title_en')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group row pl-3 pr-3">
                            <label class="col-form-label" for="inputError">@error('slug')<i
                                    class="far fa-times-circle"></i>@enderror Slug </label>
                            <input type="text" name="slug" id="slug_input"
                                   value="{{ old('slug') ?: (isset($category) ? $category->slug : '') }}"
                                   class="form-control form-control-sm @error('slug') is-invalid @enderror">
                            @error('slug')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>

            <div class="card-footer">
                <button type="submit" class="btn btn-default btn-outline-success green-btn float-right"
                        form="create-form">Պահպանել
                </button>
                <button id="reset-form" onclick="document.getElementById('create-form').reset()"
                        class="btn btn-default btn-outline-danger green-btn" type="reset">Վերակայել
                </button>
            </div>
        </div>
    </div>
</form>
