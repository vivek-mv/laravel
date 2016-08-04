$(document).ready(function () {

    //When add button is clicked show him the UI for setting the permissions
    $(document).on('click','#add',function () {
        $('#showUI').empty();
        $('#addUserUI').show();
    });
});