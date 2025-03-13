$(function () {
    console.log("user access js")
    const BaseURI = "./includes/encode/useraccess_api.php?action=";

    const rolesPermissionTable = $('#usercontrolTable').DataTable({
        processing: true,
        width: '100%',
        ajax: {
            url: BaseURI + "get_all_roles_permission",
            type: "POST",
            dataType: 'json',
            dataSrc: ''
        },
        columns: [{
            title: '#',
            render: (a, b, c, d) => {
                return d.row + 1;
            }
        },
        {
            title: 'Roles',
            data: "RoleName",
            render: data => {
                return data.toUpperCase();
            }
        },
        {
            title: 'Permissions',
            data: "PermissionName",
            render: data => {
                const result = data.replace(/_/g, ' ')
                    .replace(/\b\w/g, char => char.toUpperCase())
                return result;
            }

        },
        {
            title: '',
            orderable: false,
            render: function (data) {
                return `
                    <button class="edit-btn btn btn-outline-primary">Edit</button>
                    `;
            }
        }
        ],
    });

    const rolesTable = $('#rolesTable').DataTable({
        processing: true,
        width: '100%',
        ajax: {
            url: BaseURI + "get_roles",
            type: "POST",
            dataType: 'json',
            dataSrc: ''
        },
        column: [
            {
                title: "Role Name",
                data: "RoleName"
            },
            {
                title: "description",
                data: "Description"
            },
            {
                title: "Action",
                data: null,
                ordering: true,
                render: function (data) {
                    return `
                        <div class="btn-group">
                            <button type="button" class="btn-approve btn my-1" data-id="${data.id}">
                            <i class="bi bi-check-circle text-success" style="font-size:x-large;"></i>
                            </button>
                            <button type="button" class="btn-reject btn my-1" data-id="${data.id}">
                              <i class="bi bi-x-circle text-danger" style="font-size:x-large;"></i>
                            </button>
                        </div>
                `;
                },
            }
        ]
    })

    $(document).on("click", ".update", function () {
        const id = $(this).data("id");
        $.post(
            `./includes/encode/resources_api.php?action=get_allocated_resources_by_ID`,
            { id: id },
            function (resource) {
                if (resource) {
                    $("#EditResourcesModal").modal("show");
                    $("#edit_name").val(resource.name);
                    $("#edit_name").val(resource.name);
                    $("#submit-btn").data("id", id); // Attach the resource ID to the submit button
                } else {
                    alert("Resource not found");
                }
            },
            "json"
        ).fail(function () {
            alert("Something went wrong");
        });
    });

    const permissionTable = $('#permissionTable').DataTable({
        processing: true,
        width: '100%',
        ajax: {
            url: "./includes/encode/useraccess_api.php?action=get_permissions",
            type: "POST",
            dataType: 'json',
            dataSrc: ''
        },
        column: [
            {
                title: "Permission Name",
                data: "name"
            },
            {
                title: "description",
                data: "description"
            },
            {
                title: "Action",
            }
        ]
    })

    $("#new_role_form").on("submit", function (e) {
        e.preventDefault();

        const formData = $(this).serialize();

        $.post(BaseURI + "new_role",
            formData,
            function (response) {
                if (response.success) {
                    $("#new_role_form")[0].reset();
                    rolesTable.ajax.reload();
                    rolesPermissionTable.ajax.reload();
                    $("#added").toast("show");
                } else {
                    alert("Failed to submit request: " + response.message);
                }
            }, "json");
    })


    $("#new_permission_form").on("submit", function (e) {
        e.preventDefault();

        const formData = $(this).serialize();

        $.post(BaseURI + "new_permission",
            formData,
            function (response) {
                if (response.success) {
                    $("#new_permission_form")[0].reset();
                    permissionTable.ajax.reload();
                    rolesPermissionTable.ajax.reload();
                    $("#added").toast("show");
                } else {
                    alert("Failed to submit request: " + response.message);
                }
            }, "json");
    })



});