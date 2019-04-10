$("#select-user").change(function () {
    $.post(base_url + "account/get_permissions/" + $("#select-user").val(), {}, function (permissions) {
        var html = "";

        html += "<input id='search-permission' placeholder='Keresés...' class='form-control mb-2'>"; // TODO Lang
        for (var permission_count = 0; permission_count < permissions.length; permission_count++) {
            permission = permissions[permission_count];
            // language=HTML
            html += "<div class=\"checkbox permission-container\">\n    <label class=\'permission-container\'>\n        " +
                "<input name='" + permission.permission_name + "' ' type=\"checkbox\"" + (permission.has_permission ? " checked" : "") + "> \n    " +
                permission.permission_nice_name + "</label></div>";


        }

        html += "<button type=button id='submitPermissionEdit' class='btn btn-primary d-block mt-2'>Mentés</button>"; // TODO LANG


        $("#permissions-container").html(html);

        $("#search-permission").on("keyup", function () {
            var value = $(this).val().toLowerCase();
            console.log($(this).text().toLowerCase());
            $(".permission-container").filter(function () {
                $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
            });
        });

        $("#submitPermissionEdit").click(function () {
            $.post(base_url + "account/save_permissions/"+$("#select-user").val(), {"permissions": $("#edit-permissions-form").serializeArray()})
                .done(function (data) {
                    if(data.error !== undefined){
                        alert(data.error);
                    }
                    else {
                        alert("Sikeres mentés!"); // TODO lang
                    }
                })
                .fail(function () {
                    alert("Sikertelen mentés! Ellenőrizd az internetkapcsolatot!"); // TODO LANG
                })

        })

    })
        .fail(function () {
            alert("Sikertelen lekérdezés! Ellenőrizd az internetkapcsolatot!") // TODO lang
        });
});