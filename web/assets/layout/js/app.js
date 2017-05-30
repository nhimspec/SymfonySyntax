$(document).ready(function() {
    $('a.btn-delete').on('click', function(e) {
        console.log('fdsaf');
        e.preventDefault();
        $('#deleteModal form').attr('action', $(this).data('delete'));
    });

    $('.upload_thumbnail').change(function() {
        if (this.files && this.files[0]) {
            var reader = new FileReader();

            reader.onload = function(e) {
                $('#thumbnail').attr('src', e.target.result);
            };

            reader.readAsDataURL(this.files[0]);
        }
    });
    $('#upload_avatar').on('click',function() {
        $('.upload_avatar').trigger('click');
    })
    $('.upload_avatar').change(function() {
        var file = this.files[0],
            ValidImageTypes = ['image/gif', 'image/jpeg', 'image/png'];
        var fileType = file['type'];

        if ($.inArray(fileType, ValidImageTypes) > 0) {
            var form = new FormData();
            form.append('file', this.files[0]);
            $.ajax({
                url: '/profile/edit/ajax',
                type: 'post',
                processData: false,
                contentType: false,
                cache: false,
                dataType: 'json',
                data: form,
                success: function(resp) {
                    $('div.vich-image #picture').attr('src', resp);
                },
            });
        }
    });
});