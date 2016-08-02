var checkboxResponseObj;
/**
 * Get the role,resource and permissions data
 * @param void
 * @retrun void
 */
function display() {
    //send ajax request to get the role, resource and permissions data
    $.ajax({
        url: 'dashboard/getPermissions',
        data: {
            code: 1,
            ajax: 1
        },
        type: "POST",
        success: function (response) {
            if ( response.error_code == '403') {
                showMessage('<h3 style="color: red">Sorry you are not authorised to edit permissions</h3>');
            }else {
                displayRRP(response);
                selectCheckbox(response.rrp[0]);
                checkboxResponseObj = response.rrp;
            }

        }
    });
}


/**
 * Selects the checkbox based on role and resource
 * @param object
 * @retrun void
 */
function selectCheckbox(rrpObj) {

    var getRoleId = $('#displayRole').val();
    var getResourceId = $('#displayResources').val();
    $.each($('.checkbox'),function () {
        $(this).prop('checked', false);
    });
    $.each($('.checkbox'),function () {
        var checkbox = this;
        var getPermissionId = this.value;
        $.each(rrpObj,function () {
            if ( (this.role_id == getRoleId)  && (this.resource_id == getResourceId) && (this.permission_id == getPermissionId) ) {
                $(checkbox).prop('checked', true);
            }
        });

    });
}

/**
 * Send the role,resource and permissions data
 * @param void
 * @retrun void
 */
function sendPermissions(checkboxObj,isChecked) {
    var getRoleId = $('#displayRole').val();
    var getResourceId = $('#displayResources').val();
    var getPermissionId = checkboxObj.value;
    var action = 'delete';
    if ( isChecked ) {
        action = 'add';
    }

    //send ajax request to set the role, resource and permissions data
    $.ajax({
        url: 'dashboard/setPermissions',
        data: {
            code: 2,
            action:action,
            roleId:getRoleId,
            resourceId:getResourceId,
            permissionId:getPermissionId,
            ajax: 1
        },
        dataType : 'json',
        type: "POST",
        success: function (response) {
            if ( response.error_code == '403' ) {

                showMessage('<h3 style="color: red">Sorry you are not authorised to edit permissions</h3>');

            }else if ( response.success == '1' ) {

                $('#showUI').empty();
                display();
                showMessage('<h3 style="color: darkgrey">Permissions Changed Successfully</h3>');

            } else if ( response.success == '0' ) {
                $('#showUI').empty();

                display();
                showMessage('<h3 style="color: red">Operation Failed</h3>');
            }
        }
    });
}

/**
 * Display the role,resource and permissions data
 * @param json
 * @retrun void
 */
function displayRRP(response) {


    $('#showUI').append('<div class="panel panel-default" style="width: 70%;"><div class="panel-heading" style="text-align: center;">ADMIN PANEL</div><div class="panel-body dashboard"></div></div>');
    $('.dashboard').append('<div id="formdiv" class="form-inline"></div>');
    $('#formdiv').append(' Role : <select id="displayRole" class="form-control"></select>');
    //Display roles
    $.each(response.role[0], function(role) {
        $('#displayRole').append($('<option>', {
            value: response.role[0][role].id,
            text : response.role[0][role].name
        }));
    });

    //Display resources
    $('#formdiv').append(' Resource : <select id="displayResources" class="form-control"></select>');
    $.each(response.resource[0], function(res) {
        $('#displayResources').append($('<option>', {

            value: response.resource[0][res].id,
            text : response.resource[0][res].name
        }));
    });

    //Display permissions
    $('#formdiv').append(' Permissions : <div id="checkboxdiv" class="form-control"></div>');
    $.each(response.permission[0], function(per) {
        $('#checkboxdiv').append('&nbsp;&nbsp;&nbsp;');
        $('<input />', { type: 'checkbox', id:per, class:'checkbox', value: response.permission[0][per].id }).appendTo('#checkboxdiv');
        $('<label />', { 'for': per, text: response.permission[0][per].name }).appendTo('#checkboxdiv');
    });


}

function showMessage(msg) {
    $('#showMessage').html(msg);
    $('#showMessage').delay(200).fadeIn().delay(1000).fadeOut();
}

$(document).ready(function () {

    //When add button is clicked show him the UI for setting the permissions
    $(document).on('click','#edit',function () {
        $('#addUserUI').hide();
        $('#showUI').empty();
        display();
    });

    //Bind event for checkbox
    $(document).on('click','.checkbox',function () {
        sendPermissions(this,this.checked);
    });

    //Bind event when any select dropdown is change
    $(document).on('change','select', function() {
        selectCheckbox(checkboxResponseObj[0]);
    });
});