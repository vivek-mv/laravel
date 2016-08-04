
$(document).ready(function(){

    //Register event to display the stackoverflow info
    $(document).on('click', '.showStackInfo', function () {
        displayStackInfo(this.children[0].value);
    });

});

/**
 * Display the Stackoverflow account info
 * @param stackUserId
 */
function displayStackInfo(stackUserId) {
    if ( stackUserId == '' ) {

        $('#stackNoAccount').css('display','inline');
        $('.modal-body').css('display','none');
    } else {

        $('#stackNoAccount').css('display','none');
        $('#stackInvalidAccount').css('display','none');
        $('.modal-body').css('display','inline');
        $('#loaderImg').css('display','inline');
        $('.panel').hide();
        $.ajax({
            url: 'https://api.stackexchange.com/users/' + stackUserId + '?site=stackoverflow',
            dataType : 'json',
            success: function (response) {
                if ( response.items == '' || response.error_id   ) {

                    $('#loaderImg').css('display','none');
                    $('#stackInvalidAccount').css('display','inline');
                } else {

                    $('#display-name').html(response.items[0].display_name);
                    $('#profile_pic').attr('src',response.items[0].profile_image);
                    $('#age').html(response.items[0].age);
                    $('#reputation').html(response.items[0].reputation);
                    $('#b_badges').html(response.items[0].badge_counts.bronze);
                    $('#s_badges').html(response.items[0].badge_counts.silver);
                    $('#g_badges').html(response.items[0].badge_counts.gold);
                    $('#location').html(response.items[0].location);
                    $('#link').attr('href',response.items[0].link);
                    $('#loaderImg').css('display','none');
                    $('.panel').show();
                }
            },
            statusCode: {
                400: function() {console.log('hi');
                    $('#loaderImg').css('display','none');
                    $('#stackInvalidAccount').css('display','inline');
                }
            }
        });
    }
}

















