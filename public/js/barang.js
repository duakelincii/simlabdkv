$(function () {

	const table = $('table').DataTable({
		serverSide: true,
		ajax: {
			url: ajaxUrl,
			dataType: 'json'
		},
		columns: [
			{ data: 'DT_RowIndex' },
			{ data: 'code' },
			{ data: 'name' },
			{ data: 'satuan' },
			{ data: 'year' },
			{ data: 'stock' },
            { data: 'gambar',
                render: gambar => `<img src="${gambar}" alt="image" width="50%">`
            },
			{
                visible: admin === '1' ? true : false,
				data: 'action',
				orderable: false,
				searchable: false
			},
		],
        "oLanguage": {
            "sSearch": "Cari :",
            "sLengthMenu": "Lihat _MENU_ Data",
            "oPaginate": {
                "sNext": '<i class="fa fa-forward"></i>',
                "sPrevious": '<i class="fa fa-backward"></i>',
             },
            "sInfo": "Memunculkan _START_ Dari _END_ Data",
        }
	})

	const reload = () => table.ajax.reload()

	$('tbody').on('click', '.edit', function () {
		let data = table.row($(this).parents('tr')).data()
		let modal = $('#edit')

		let action = updateUrl.replace(':id', data.id)

		modal.find('form').attr('action', action)
		modal.find('[name=code]').val(data.code)
		modal.find('[name=name]').val(data.name)
		modal.find('[name=satuan]').val(data.satuan)
		modal.find('[name=year]').val(data.year)
		modal.find('[name=category_id]').append(`<option value='${data.category.id}' selected>${data.category.name}</option>`)
        modal.find('#gambar').html(data.gambar)
		modal.find('input').removeClass('is-invalid')

		modal.modal('show')
	})

	$('tbody').on('click', '.delete', function () {
		if (confirm('Delete?')) {
			let data = table.row($(this).parents('tr')).data()

			let url = deleteUrl.replace(':id', data.id)

			$.ajax({
				url: url,
				method: 'post',
				data: {
					'_method': 'delete',
					'_token': csrf
				},
				dataType: 'json',
				success: res => {
					let msg = `<div class="alert alert-success alert-dismissible">${res.msg}<button class="close" data-dismiss="alert">&times;</button></div>`

					$('#alert').html(msg)
					reload()
				}
			})
		}
	})

	$('#edit form').submit(function (e) {
		e.preventDefault()

        let data = new FormData(this)
		let file = $('[name=gambar]')[0].files[0]

		file ? data.append('gambar', file) : ''

		$.ajax({
			url: this.action,
            contentType: false,
            processData: false,
			type: 'post',
			data: data,
			dataType: 'json',
			success: res => {
				let msg = `<div class="alert alert-success alert-dismissible">${res.msg}<button class="close" data-dismiss="alert">&times;</button></div>`

				$('#alert').html(msg)
				$('#edit').modal('hide')
				reload()
			},
			error: err => {
				if (err.status === 422) {
					console.log(err)
					let errors = err.responseJSON.errors
					$.each(errors, function (name, error) {
						let input = $(`[name=${name}]`)
						let msg = error[0]

						input.addClass('is-invalid')
						input.next('.invalid-feedback').html(msg)
					})
				}
			}
		})
	})

	$('[name=category_id]').select2({
		placeholder: 'Category',
		ajax: {
			url: getCategoryUrl,
			type: 'post',
			data: params => ({
				_token: csrf,
				name: params.term
			}),
			dataType: 'json',
			processResults: res => ({
				results: res
			}),
			cache: true
		}
	})

})
