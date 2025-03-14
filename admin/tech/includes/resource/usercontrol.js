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
            dataSrc: function (json) {
                return json.map((row, index) => ({
                    index: index + 1, // Row number
                    RoleName: row.role_name.toUpperCase(),
                    Permissions: row.permissions ? row.permissions.split(', ') : null // Split permissions into array
                }));
            }
        },
        columns: [
            { 
                title: '#', 
                data: "index" 
            },
            { 
                title: 'Roles', 
                data: "RoleName" 
            },
            {
                title: 'Permissions',
                data: "Permissions",
                render: function (data) {
                    if (!data) {
                        return '<span class="text-muted">No Permissions Assigned</span>'; // If null, display this
                    }
                    return data.map(perm =>
                        `<span class="badge badge-secondary">${perm.replace(/_/g, ' ').toUpperCase()}</span>`
                    ).join(' ');
                }
            },
            {
                title: 'Actions',
                orderable: false,
                render: function () {
                    return `
                    <div class="d-flex gap-2 align-text-center">
                        <button type="button" class="edit-btn btn btn-outline-primary float-right" data-toggle="modal" data-target="#editPermissionModal">Edit</button>
                        <button type="button" class="btn btn-outline-danger float-right"">Delete</button>
                    <div>
                    `;
                }
            }
        ]
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
            url: BaseURI + "get_permissions",
            type: "POST",
            dataType: 'json',
            dataSrc: ''
        },
        column: [
            {
                title: "Permission Name",
                data: "name",
                
            },
            {
                title: "description",
                data: "description",
                render: data => data.toUpperCase()
            },
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

    function loadRolesSelectTag() {
        $.get(BaseURI + 'get_roles', function (data) {
            const roles = JSON.parse(data);

            $('#role_select_id').empty().append('<option value="" selected disabled hidden>Select Role</option>');

            roles.forEach(role => {
                $('#role_select_id').append(`<option value="${role.id}">${role.RoleName} (${role.Description})</option>`);
            });
        });
    }

    function loadPermissionSelectTag() {
        $.get(BaseURI + 'get_permissions', function (data) {
            const roles = JSON.parse(data);

            $('#permissions_tags').empty().append('<option value="" selected disabled hidden>Select Role</option>');

            roles.forEach(role => {
                $('#permissions_tags').append(`
                    <div class="d-flex justify-content-between align-text-center hover-bg-primary">
                        <label class="form-label">${role.name}:</label>
                        <input type="checkbox" value="${role.id}" class="permission-checkbox" title="${role.description}" value="${role.name}" />
                    </div>
                    `);
            });
        });
    }

    $('#role_select_id').on('change',function () {
        const selectedRoleId = $(this).val();

        $('.permission-checkbox').prop('checked', false); // Uncheck all first

        if (selectedRoleId) {
            $.get(BaseURI + `get_role_permissions?role_id=${selectedRoleId}`, function (data) {
                const assignedPermissions = JSON.parse(data);
                assignedPermissions.forEach(permission => {
                    $(`.permission-checkbox[value="${permission.id}"]`).prop('checked', true);
                });
            });
        }
    });


    $(document).on('click', '.edit-btn', function () {
        let data = rolesPermissionTable.row($(this).parents('tr')).data();
        let roleId = data.index;
        let roleName = data.RoleName;
        
        // Populate modal title and hidden input
        $('#modalRoleName').text(roleName);
        $('#modalRoleId').val(roleId);
        
        // Fetch available permissions from server
        $.ajax({
            url: BaseURI + "get_permissions", // Fetch all possible permissions
            type: "POST",
            dataType: "json",
            success: function (permissions) {
                let permissionListHtml = '';
                
                permissions.forEach(perm => {
                    let checked = (data.Permissions && data.Permissions.includes(perm.name)) ? 'checked' : '';

                    permissionListHtml += `
                        <div class="form-check">
                            <input class="form-check-input permission-checkbox" type="checkbox" value="${perm.id}" id="perm_${perm.id}" ${checked}>
                            <label class="form-check-label" for="perm_${perm.id}">
                                ${perm.name.replace(/_/g, ' ').toUpperCase()}
                            </label>
                        </div>`;
                });
    
                $('#permissionList').html(permissionListHtml);
                $('#editPermissionModal').modal('show');
            }
        });
    });
    
    $('#savePermissionsBtn').on('click', function () {
        let roleId = $('#modalRoleId').val();
        let selectedPermissions = [];
    
        $('.permission-checkbox:checked').each(function () {
            selectedPermissions.push($(this).val());
        });
    
        // Send update request
        $.ajax({
            url: 'api.php?action=update_role_permissions',
            type: 'POST',
            data: {
                role_id: roleId,
                permissions: selectedPermissions
            },
            success: function (response) {
                if (response.success) {
                    $('#editPermissionModal').modal('hide');
                    alert('Permissions updated successfully');
                } else {
                    alert("Failed to update permissions: " + response.message);
                }
            }
        });
    });

    loadRolesSelectTag()
    loadPermissionSelectTag()
});