function capitalize(str) {

    const arr = str.split(' ')

    for (let i = 0; i < arr.length; i++) {
        arr[i] = arr[i].charAt(0).toUpperCase() + arr[i].slice(1)
    }

    return arr.join(' ')

}

const Table = function (params) {
    const instance = this
    const options = {
        ...{
            actions: true,
            bulkActions: ['delete'],
            filters: [],
        },
        ...params
    }

    instance.init = () => {

        if(!options.order){
            options.order = []
        }

        const tableContainer = $('body #table-init')
        tableContainer.html(`<table class="table table-striped table-bordered dataTable no-footer datatable w-100"
                                              role="grid" aria-describedby="datatable_info">
                                            <thead><tr role="row">
<!--                                            Select all-na-->
<!--                                            <th><input type='checkbox' id='select-all'></th>-->

                                                ${renderColumnHeaders()}
                                            </tr></thead></table>`)

        const table = $('.datatable').DataTable({
            //disable aoutoordering on 1st column
            aaSorting: [],
            "createdRow": function( row, data, dataIndex ) {
                $(row).addClass('sortable-row').attr('data-id', data.id);
            },
            order: options.order,
            columnDefs: [{"orderable": false, "targets": options.columnDefs}],
            "dom": '<"top row"<"#action-container.col-2"><"#filter-container.col-8"><"col-2"f>>rt<"bottom row"<"col-9"i><"col-3"p>><"clear">',
            processing: true,
            search: {return: true},
            serverSide: true,
            ajax: {
                url: `/admin/${options.name}/draw`,
                data: function (data) {
                    data.filters = {}
                    const filters = Array.from($('body select.filter-select'))

                    for (let i = 0; i < filters.length; i++) {
                        data.filters[filters[i].getAttribute('name')] = filters[i].value
                    }
                }
            },
            columns: columnOptions(),
        });

        const body = $('body')

        //Bulk actioni hamara ogtagorcvum
        // body.find('#action-container').html(renderTableContent())
        body.find('#filter-container').html(renderFilters())

        // body.on("change", "#select-all", function () {
        //     $('.select-row').prop('checked', $(this).is(':checked'))
        // });

        body.on('change', 'select.filter-select', function () {
            table.draw();
        });

        // body.on("click", "#bulk-apply", function () {
        //     const selected = $("body .select-row:checked").map(function () {
        //         return $(this).val()
        //     }).get()
        //     const action = $('body #bulk-action').val()
        //     console.log('selected: ', selected)
        //     console.log('action: ', action)
        //     if (selected.length && action) {
        //         axios.post(`/admin/${options.name}/bulk-actions`, {
        //             selected,
        //             action
        //         }).then(({data}) => {
        //             $('.datatable').DataTable().ajax.reload()
        //         })
        //     }
        // });

        body.on('click', '.delete-confirm-btn', function () {
            $(`body .${$(this).attr('data-popup')}`).removeClass('d-none')
        })

        body.on('click', '.delete-popup-close', function () {
            $('body .delete-popup').addClass('d-none')
        })

        //Search with Enter button
        $('.dataTables_wrapper input[type="search"]').unbind().bind('keyup', function (e) {
            if (e.keyCode === 13) {
                table.search(this.value).draw();
            }
        });


    }

    function renderColumnHeaders() {
        let content = ''

        for (let i = 0; i < options.columns.length; i++) {
            const column = options.columns[i]
            content += `<th>${column.title || capitalize(column.data.replace('_', ' '))}</th>`
        }

        if (options.actions) {
            content += `<th>Գործողություններ</th>`
        }

        return content
    }

 //    function renderTableContent() {
 //
 //        let actions = ''
 //
 //        for (let i = 0; i < options.bulkActions.length; i++) {
 //            const action = options.bulkActions[i]
 //            actions += `<option value="${action}">${capitalize(action.replace('_', ' '))}</option>`
 //        }
 //
 //        return `<select id="bulk-action" class="form-control">
 //                                                    <option>Bulk actions</option>
 //                                                    ${actions}
 //                                                </select><button data-toggle="modal" data-target="#bulk-confirm" class="btn bulk-apply">Apply</button>
 // <div class="modal" id="bulk-confirm"><div class="modal-dialog"><div class="modal-content">
 //                    <div class="modal-body"><p>Are you sure to apply action?</p></div>
 //                    <div class="modal-footer justify-content-between"><button type="button" class="btn btn-default" data-dismiss="modal">No</button>
 //                        <button type="button" id="bulk-apply" data-dismiss="modal" class="btn btn-danger">Apply</button></div></div></div></div>`
 //    }

    // function orderOptions() {
    //
    //     let targets = options.columnDefs.map(key => [${key}])
    //     let order = [{"orderable": false, "targets": targets}],
    //
    //     return order
    //
    // }


    function renderFilters() {

        let filters = '<div class="row" style="margin-left: 10px">'

        for (let i = 0; i < options.filters.length; i++) {
            const filter = options.filters[i]
            const filterOptions = Object.keys(filter.options).map(key => `<option value="${key}">${filter.options[key]}</option>`)

            filters += `<div class="col-2"><select name="${filter.name}" class="form-control filter-select">
                                                    <option value selected="selected">Filter by ${capitalize(filter.name.replace('_', ' '))}</option>
                                                    ${filterOptions}
                                                </select></div>`
        }

        filters += '</div>'

        return filters
    }

    function columnOptions() {
        let result = [
            // {
            // ete uzum em select all-@ ashxati

            //     data: 'id', render: function (data) {
            //         return `<input type="checkbox" class="select-row" value="${data}">`
            //     }
            // }
        ]

        for (let i = 0; i < options.columns.length; i++) {
            const column = options.columns[i]

            let field

            if (column.data) {
                field = column.data

            } else if (column.render) {
                field = 'id'
            } else {
                field = column.title.replace(' ', '_').toLowerCase()
            }

            const row = {
                data: field,
            }

            if (column.render) {
                row.render = column.render

            } else {
                switch (column.type) {
                    case 'date': {
                        row.render = function (data, type, row) {
                            return moment(data).format("DD/MM/YYYY HH:mm")
                        }
                        break;
                    }
                    case 'image': {
                        row.render = function (data, type, row) {
                            return data ? `<img loading="lazy"  width="110" src="${data.urls && data.urls.xs}">` : 'no image'
                        }
                        break;
                    }
                    case 'pdf': {
                        row.render = function (data, type, row) {
                            return data ? `<a target="_blank" href="${data.urls && data.urls.original}">
                                            <svg width="32" height="32" viewBox="0 0 32 32" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <path d="M17.508 4.41406H12.1377C9.71024 4.41406 8.49651 4.41406 7.7424 5.16818C6.98828 5.92229 6.98828 7.13603 6.98828 9.56349V22.4371C6.98828 24.8645 6.98828 26.0782 7.7424 26.8324C8.49651 27.5865 9.71024 27.5865 12.1377 27.5865H19.8618C22.2893 27.5865 23.503 27.5865 24.2572 26.8324C25.0113 26.0782 25.0113 24.8645 25.0113 22.4371V11.9173C25.0113 11.3911 25.0113 11.128 24.9133 10.8914C24.8153 10.6549 24.6292 10.4688 24.2572 10.0967L19.3286 5.16818C18.9565 4.79609 18.7705 4.61005 18.5339 4.51206C18.2973 4.41406 18.0342 4.41406 17.508 4.41406Z" stroke="#001489" stroke-width="2"/>
                                                <path d="M12.1377 17.2871L19.8618 17.2871" stroke="#FF9E1B" stroke-width="2" stroke-linecap="round"/>
                                                <path d="M12.1377 22.4365L17.2871 22.4365" stroke="#FF9E1B" stroke-width="2" stroke-linecap="round"/>
                                                <path d="M17.2871 4.41406V9.56349C17.2871 10.7772 17.2871 11.3841 17.6642 11.7611C18.0412 12.1382 18.6481 12.1382 19.8618 12.1382H25.0112" stroke="#001489" stroke-width="2"/>
                                            </svg>
                                           </a>` : 'no file'
                        }
                        break;
                    }
                    case 'price': {
                        row.render = function (data, type, row) {
                            return priceFormatter(data)
                        }
                        break;
                    }
                    case 'boolean': {
                        row.render = function (data, type, row) {
                            return data ? '<p style="text-align: center"><i style="color: green;" class="fas fa-check-circle"></i></p>' : ''
                        }
                        break;
                    }
                }
            }

            result.push(row)
        }


        if (options.actions) {
            result.push({
                data: 'id', render: function (data) {
                    return `<a class="btn btn-info" href="/admin/${options.name}/${data}/edit"><i class="fas fa-edit"></i></a>
                    <button class="btn btn-raised btn-icon btn-danger delete-confirm-btn" data-popup="delete-confirm-${data}">
                        <i class="fa fa-trash" aria-hidden="true"></i>
                    </button>
                    <div class="text-center delete-popup delete-confirm-${data} d-none">
                        <div class="mb-1">Are you sure?</div>
                        <div class="d-flex justify-content-center">
                            <form action="/admin/${options.name}/${data}" class="delete-form" method="POST">
                               <input type="hidden" name="_token" value="${document.getElementsByName('csrf-token')[0].getAttribute('content')}">
                                <input type="hidden" name="_method" value="DELETE">
                            <button type="submit" class="btn btn-raised btn-danger mr-1 delete_form">
                                Yes
                            </button>
                        </form>
                        <button class="btn btn-raised btn-secondary mr-1 delete-popup-close" type="button">
                            No
                        </button>
                    </div>
                    </div>`
                }
            })
        }

        return result
    }


    instance.init()
}
