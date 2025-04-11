$(function () {
    console.log("user access js")
    const BaseURI = "./includes/encode/useraccess_api.php?action=";

    const rolesPermissionTable = $('#usercontrolTable').DataTable({
        width: '100%',
        responsive: true,
        processing: true,
        // scrollY:        "",
        // scrollCollapse: false,
        // scrollX: true,
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
                data: null,
                orderable: false,
                render: function (data) {
                    return `
                    <div class="d-flex gap-2 align-text-center">
                        <button type="button" data-id="${data.role_id}" 
                                class="edit-btn btn btn-outline-primary float-right" 
                                data-toggle="modal" data-target="#editAccess">
                                    Edit
                        </button>
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
                            <button type="button" class="delete-btn btn-reject btn my-1" data-id="${data.id}">
                              <i class="bi bi-x-circle text-danger" style="font-size:x-large;"></i>
                            </button>
                        </div>
                `;
                },
            }
        ]
    })

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

    // $("#new_permission_form").on("submit", function (e) {
    //     e.preventDefault();

    //     const formData = $(this).serialize();

    //     $.post(BaseURI + "new_permission",
    //         formData,
    //         function (response) {
    //             if (response.success) {
    //                 $("#new_permission_form")[0].reset();
    //                 permissionTable.ajax.reload();
    //                 rolesPermissionTable.ajax.reload();
    //                 $("#added").toast("show");
    //             } else {
    //                 alert("Failed to submit request: " + response.message);
    //             }
    //         }, "json");
    // })


    // $('#role_select_id').on('change', function () {
    //     const selectedRoleId = $(this).val();

    //     $('.permission-checkbox').prop('checked', false); // Uncheck all first

    //     if (selectedRoleId) {
    //         $.get(BaseURI + `get_role_permissions?role_id=${selectedRoleId}`, function (data) {
    //             const assignedPermissions = JSON.parse(data);
    //             assignedPermissions.forEach(permission => {
    //                 $(`.permission-checkbox[value="${permission.id}"]`).prop('checked', true);
    //             });
    //         });
    //     }
    // });


    // Open Modal & Load Data
    $('#AsignAccess').on('show.bs.modal', function () {
        loadRolesPerm()
    });

    // Load Roles
    function loadRolesPerm() {
        $.ajax({
            url: BaseURI + 'get_roles',
            type: 'GET',
            success: function (response) {
                let roleSelect = $('#roleSelect');
                roleSelect.empty();
                response.forEach(role => {
                    roleSelect.append(`<option value="${role.RoleID}">${role.RoleName}</option>`);
                });
            }
        });

        $.ajax({
            url: BaseURI + 'get_permissions',
            type: 'GET',
            success: function (response) {
                let permissionSelect = $('#permissionSelect');
                let temp = '<i class="fa-solid fa-circle-plus"></i>';
                permissionSelect.empty();
                response.forEach(permission => {
                    permissionSelect.append(`<option value="${permission.id}">+ ${permission.name}</option>`);
                });
            }
        });
    }

    // assign Role Permissions
    $('#savePermissionsBtn').on('click', function () {
        let roleId = $('#roleSelect').val();
        let selectedPermissions = $('#permissionSelect').val();

        $.ajax({
            url: BaseURI + 'assign_role_permissions',
            type: 'POST',
            data: {
                role_id: roleId,
                permissions: selectedPermissions
            },
            success: function (response) {
                if (response.success) {
                    rolesPermissionTable.ajax.reload();
                    $("#added").toast("show")
                } else {
                    alert("Failed to update permissions: " + response.message);
                }
            }
        });
    });

    //edit role access modal checkbox
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

    $("#EditedRolesPerm").on("click", function () {
        let roleId = $('#modalRoleId').val();
        let selectedPermissions = $('.permission-checkbox:checked').map(function () {
            return $(this).val();
        }).get(); // Always ensure it's an array

        console.log("Submitting Role ID:", roleId, "Permissions:", selectedPermissions); // Debugging

        $.ajax({
            url: BaseURI + 'update_role_permissions',
            type: 'POST',
            data: {
                role_id: roleId,
                permissions: selectedPermissions.length > 0 ? selectedPermissions : [] // Ensure it's always an array
            },
            success: function (response) {
                if (response.success) {
                    rolesPermissionTable.ajax.reload();
                    $("#edited").toast("show")
                } else {
                    alert("Failed to update permissions: " + response.message);
                }
            }
        });
    });




});