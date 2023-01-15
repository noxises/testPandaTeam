$(document).ready(() => {
    if (localStorage.Response) {
        let response = localStorage.Response;
        let status = localStorage.Status;
        $('#message').show().removeClass('alert-success alert-danger').addClass(`alert-${status}`).html(response);
        localStorage.clear();
    }
    

    $('#delete').click(function (e) {
        e.preventDefault();
        let item = {};
        item[0] = $(this).attr('name');
        if (confirm('You really want to delete this pool?')) {
            $.ajax({
                url: '/pools/delete',
                cache: false,
                processData: true,
                data: item,
                type: 'post',
                success: function (php_script_response) {
                    window.location.replace('/');
                    localStorage.setItem("Response", php_script_response.message)
                    localStorage.setItem("Status", php_script_response.status)
                },
            });
        } else {
            window.location.reload();

        }

    });
   
   

    $('#editForm').submit(function (e) {
        e.preventDefault();
        var form = $(this);

        $.ajax({
            url: '/pools/save',
            cache: false,
            processData: true,
            data: form.serialize(),
            type: 'post',
            success: function (php_script_response) {
                if (php_script_response.status === 'danger') {
                    $('#message').show().removeClass('alert-success alert-danger').addClass(`alert-${php_script_response.status}`).html(php_script_response.message);
                } else {
                    localStorage.setItem("Response", php_script_response.message)
                    localStorage.setItem("Status", php_script_response.status)
                    window.location.replace('/pools/edit/'+php_script_response.id);
                }

            }
        });

    });

    $('#registration_form').submit(function (e) {
        e.preventDefault();
        let inputs = {};
        $(this).find(':input').each(function () {
            inputs[$(this).attr("name")] = $(this).val();
        });
        $.ajax({
            url: '/registration/create',
            cache: false,
            processData: true,
            data: inputs,
            type: 'post',
            success: function (php_script_response) {
                if (php_script_response.status === 'danger') {
                    $('#message').show().removeClass('alert-success alert-danger').addClass(`alert-${php_script_response.status}`).html(php_script_response.message);
                } else {
                    window.location.replace('/');
                    localStorage.setItem("Response", php_script_response.message)
                    localStorage.setItem("Status", php_script_response.status)
                }

            }
        });

    });


    $('#login_form').submit(function (e) {
        e.preventDefault();
        let inputs = {};
        $(this).find(':input').each(function () {
            inputs[$(this).attr("name")] = $(this).val();
        });

        $.ajax({
            url: '/login/authorization',
            cache: false,
            processData: true,
            data: inputs,
            type: 'post',
            success: function (php_script_response) {
                if (php_script_response.status === 'danger') {
                    $('#message').show().removeClass('alert-success alert-danger').addClass(`alert-${php_script_response.status}`).html(php_script_response.message);
                } else {
                    window.location.replace('/account');
                    localStorage.setItem("Response", php_script_response.message)
                    localStorage.setItem("Status", php_script_response.status)
                }

            }
        });

    });


    $('#logout').click(function (e) {
        e.preventDefault();
        $.ajax({
            url: '/logout',
            success: function (php_script_response) {
                window.location.replace('/');
                localStorage.setItem("Response", php_script_response.message)
                localStorage.setItem("Status", php_script_response.status)
            }
        });
    });


});




$('#delete_selected').click(function (e) {
    e.preventDefault();
    let items = {};
    $.each($("input[name='answers[]']:checked"), function (index) {
        items[index] = $(this).val();
    });
    if (confirm('You really want to delete this answers?')) {
        $.ajax({
            url: '/pools/answers/delete',
            cache: false,
            processData: true,
            data: items,
            type: 'post',
            success: function (php_script_response) {
                localStorage.setItem("Response", php_script_response.message)
                localStorage.setItem("Status", php_script_response.status)
                window.location.reload();
            },
        });
    } else {
        window.location.reload();
    }
});