
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
    $('.market-data').click(function() {
        console.log('show');
        if($('#market-data-open').hasClass('active')) {
            $('.market-data-chevron-up').addClass('hide');
            $('.market-data-chevron-down').removeClass('hide');
        }

        if($('#market-data-open').hasClass('')) {
            $('.market-data-chevron-up').removeClass('hide');
            $('.market-data-chevron-down').addClass('hide');
        }
    });

    $('.news-sections').click(function() {
        console.log('show');
        if($('#news-sections-open').hasClass('active')) {
            $('.news-sections-chevron-up').addClass('hide');
            $('.news-sections-chevron-down').removeClass('hide');
        }

        if ($('#news-sections-open').hasClass('')) {
            $('.news-sections-chevron-up').removeClass('hide');
            $('.news-sections-chevron-down').addClass('hide');
        }
    });
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

$(document).ready(function(){
    $('#business-news-table').DataTable({
        "pageLength": 3,
        "searching": false,
        "columnDefs": [
            {
                "targets": [0],
                "orderData": [0]
            }
        ],
        "order": [[ 0, "dsc" ]]
    });

    $('#technology-news-table').DataTable({
        "pageLength": 3,
        "searching": false,
        "columnDefs": [
            {
                "targets": [0],
                "orderData": [0]
            }
        ],
        "order": [[ 0, "dsc" ]]
    });

    $('#top-news-table').DataTable({
        "pageLength": 3,
        "searching": false,
        "columnDefs": [
            {
                "targets": [0],
                "orderData": [0]
            }
        ],
        "order": [[ 0, "dsc" ]]
    });

    $('#us-news-table').DataTable({
        "pageLength": 3,
        "searching": false,
        "columnDefs": [
            {
                "targets": [0],
                "orderData": [0]
            }
        ],
        "order": [[ 3, "dsc" ]]
    });

    $('#world-news-table').DataTable({
        "pageLength": 3,
        "searching": false,
        "columnDefs": [
            {
                "targets": [0],
                "orderData": [0]
            }
        ],
        "order": [[ 0, "dsc" ]]
    });
});