$(function () {

	bsCustomFileInput.init()
	const table = $('table').DataTable({
		serverSide: true,
		ajax: {
			url: ajaxUrl,
			dataType: 'json'
		},
		columns: [
			{   data: 'DT_RowIndex' ,
                orderable: false,
				searchable: false},
			{ data: 'name' },
			{ data: 'email' },
			{
				data: 'action',
				orderable: false,
				searchable: false
			}
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
		modal.find('[name=email]').val(data.email)
		modal.find('[name=password]').val(data.password)

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
		// let file = $('[name=file]')[0].files[0]

		// file ? data.append('file', file) : ''

		$.ajax({
			url: this.action,
			type: 'post',
			data: data,
			contentType: false,
			processData: false,
			dataType: 'json',
			success: res => {
				let msg = `<div class="alert alert-success alert-dismissible">${res.msg}<button class="close" data-dismiss="alert">&times;</button></div>`

				$('#alert').html(msg)
				$('#edit').modal('hide')
				reload()
			},
			error: err => {
				if (err.status === 422) {
					let errors = err.responseJSON.errors
					$.each(errors, function (email,error) {
                        console.log(error)
						let input = $(`[email=${email}]`)
						// let msg = error[0]
                        let msg = `<div class="alert alert-danger alert-dismissible">${error[0]}<button class="close" data-dismiss="alert">&times;</button></div>`

                        $('#alert').html(msg)
                        $('#edit').modal('hide')
                        reload()
						// input.addClass('is-invalid')
						// input.next('.invalid-feedback').html(msg)
					})
				}
			}
		})
	})

})
