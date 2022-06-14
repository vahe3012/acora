<div class="modal fade" id="descrModal" tabindex="-1" role="dialog" aria-labelledby="descrModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="descrModalLabel">Նկարագրություն</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" style="min-height: 0;">

                <div class="form-group">
                    <label class="col-form-label" for="description_am">Նկարագրություն (հայերեն)</label>
                    <div class="input-group-sm">
                        <textarea id="description_am" class="form-control"
                                  name="description_am" rows="10"></textarea>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-form-label" for="description_en">Նկարագրություն (անգլերեն)</label>
                    <div class="input-group-sm">
                        <textarea id="description_en" class="form-control"
                                  name="description_en" rows="10"></textarea>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Փակել</button>
                <button type="button" class="btn btn-primary" onclick="saveDescription()">Պահպանել</button>
            </div>
        </div>
    </div>
</div>

@push('scripts')
    <script>
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        const getDescription = () => {
            $.get('{{ route('admin.settings.show', ['setting' => $setting]) }}')
                .done(res => {
                    if (res.result) {
                        $('#description_am').val(res.result.description_am)
                        $('#description_en').val(res.result.description_en)
                    }
                })
        }

        const saveDescription = () => {
            let data = {
                description_am: validateInput($('#description_am')),
                description_en: validateInput($('#description_en'))
            }

            if (data.description_am && data.description_en) {
                $.post('{{ route('admin.settings.store') }}', {'{{ $setting }}': data})
                    .done(res => {
                        if (res.success) {
                            $('#descrModal').modal('hide')
                        }
                    })
            }

            return false
        }

        const validateInput = input => {
            if (!input.val()) {
                input.addClass('is-invalid')
                input.parents('.input-group-sm').append('<span class="invalid-feedback">The Field is required!</span>')
                return false
            } else {
                input.removeClass('is-invalid')
                input.parents('.input-group-sm').find('.invalid-feedback').remove()
                return input.val();
            }
        }

        $(() => {
            getDescription();
        })
    </script>
@endpush
