
<div class="carousel news-carousel" data-flickity='{ "freeScroll": true }'>
    @if(!empty($news))
        @foreach($news as $story)
            <div class="carousel-cell">
                <img src="{{ $story['image_url'] }}" alt="{{ $story['source_name'] }}" class="story-components" data-article-id='{{ $story['article_id'] }}'>

                <div class="news-details">
                    <h5 data-target="slide-out-news" class="sidenav-trigger story-components" data-article-id='{{ $story['article_id'] }}'>{{ $story['title'] }}</h5>

                    <div class="col s10 position-bottom initial-float">
                    <small data-target="slide-out-news" class="sidenav-trigger news-details-white-text story-components uppercase" data-article-id='{{ $story['article_id'] }}'>{{ $story['source_name'] }} <span class="content-description story-components" data-article-id='{{ $story['article_id'] }}'>{{ $story['time_passed'] }}</span></small>
                    </div>
                    <div class="col s2 initial-float initial-float-i">
                        {{-- <a href="/"><i data-target="slide-out-news" class="sidenav-trigger material-icons news-details-i right">more_horiz</i></a> --}}
                        <i class="material-icons news-details-i bookmark-trigger">bookmark_border</i>
                    </div>
                </div>
            </div>
        @endforeach
    @endif
</div>

<ul id="slide-out-news" class="sidenav slide-out-news">
    <nav id="navbar-menu-news">
        <div class="row">
            <div class="col s4 left-align">
                <i class="fas fa-chevron-left sidenav-close menu-close-mobile" id="menu-close-mobile-news"></i> 
                {{-- <span class="small-text sidenav-close">Back</span> --}}
            </div>
            <div class="col s4 center-align">
                <span class="logo-image-small uppercase">Article</span>
            </div>
            <div class="col s4 right-align"></div>
        </div>
    </nav>
    <div class="row no-padding" id="menu-news-row"></div>
</ul>

<script>
    $(document).ready(function() {
        $('.news-carousel').flickity({
            // options
            contain: true,
            prevNextButtons: false,
            pageDots: false
        });

        $('.slide-out-news').sidenav({
            draggable: false,
            preventScrolling: false,
            edge: 'right',
            isFixed: false
        });

        $('.story-components').on('click', function () {
            $.ajax({
                url: '/account/dashboard/news/news-article?article_id=' + $(this).attr('data-article-id'),
                type: "GET", // not POST, laravel won't allow it
                success: function (data) {
                    $data = $(data); // the HTML content your controller has produced
                    $('#menu-news-row').html($data);
                }
            });
        });
    });
</script>