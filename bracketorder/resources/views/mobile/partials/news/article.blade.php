<div class="col s12 no-padding border-radius">
    <img src="{{ $story['image_url'] }}" alt="{{ $story['source_name'] }}">
    
    <div class="news-details-sidenav">
        <h5>{{ $story['title'] }}</h5>

        <div class="col s10 position-bottom initial-float">
            <small class="news-details-white-text uppercase">{{ $story['source_name'] }}</small> <span class="content-description">{{ $story['time_passed'] }}</span>
        </div>
        <div class="col s2 initial-float initial-float-i">
            {{-- <a href="/"><i data-target="slide-out-news" class="sidenav-trigger material-icons news-details-i right">more_horiz</i></a> --}}
            <i class="material-icons news-details-i bookmark-trigger">bookmark_border</i>
        </div>
    </div>
    <div class="col s12" id="menu-news-row-story">

        <h4><b>{{ $story['full_title'] }}</b></h4>

        <h6>{!! "<b>" . $story['author'] . "</b> | " .  date('l, F d, Y', strtotime($story['date'])) !!}</h6>

        <p class="big-first">{!! nl2br($story['text'], false) !!}</p>
    </div>
</div>