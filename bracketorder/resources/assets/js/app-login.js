
$(document).ready(function(){
    $('.sidenav').sidenav({
        draggable: false,
        preventScrolling: true
    });
});

$(document).ready(function(){
    $('.collapsible').collapsible();
});

$(document).ready(function(){
    $('.fa-bars').click(function() {
        console.log('sidenav open');
        $('.fa-bars').addClass('hide');
        $('.fa-times').removeClass('hide');
    });

    $('#slide-out').click(function() {
        console.log('has focus');
        $('.fa-bars').addClass('hide');
        $('.fa-times').removeClass('hide');
    });

    $('.fa-times').click(function() {
        console.log('fa-times clicked');
        $('.fa-bars').removeClass('hide');
        $('.fa-times').addClass('hide');
    });
});

$(document).mouseup(function(e){
    let lose_focus = $("#slide-out");

    if (!lose_focus.is(e.target) && lose_focus.has(e.target).length === 0) {
        $('.fa-bars').removeClass('hide');
        $('.fa-times').addClass('hide');
    }
});