$(function () {
    const usersTable = $('#usercontrolTable').DataTable({
        processing: true,
        width: '100%',
        ajax: {
            url: "./includes/encode/useraccess_api.php?action=get_all_roles_permission",
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
                render: function(data) {
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
            url: "./includes/encode/useraccess_api.php?action=get_all_roles_permission",
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
            }
        ]
    })

    const permissionTable = $('#permissionTable').DataTable({
        processing: true,
        width: '100%',
        ajax: {
            url: "./includes/encode/useraccess_api.php?action=get_all_roles_permission",
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
            }
        ]
    })

    // $("#").po
    // new_role

});