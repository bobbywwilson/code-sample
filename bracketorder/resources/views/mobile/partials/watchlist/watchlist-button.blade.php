
<form class="col s12" id="watchlist-form" onsubmit="event.preventDefault();">
    @csrf
    <input type="text" id="user_id" name="user_id" class="hide" value="{{ Auth::user()->id }}">
    <label for="user_id" class="hide"></label>
    @if (!isset($fundamentals['General']['Type']))
        <input type="text" id="sector" name="sector" class="hide" value="{{ $fundamentals[0]["Name"] }}">
    @else
        @if ($fundamentals['General']['Type'] == "Common Stock")
            <input type="text" id="sector" name="sector" class="hide" value="{{ $fundamentals["General"]["Sector"] }}">
        @elseif ($fundamentals['General']['Type'] == "ETF")
            <input type="text" id="sector" name="sector" class="hide" value="{{ $fundamentals["General"]["Category"] }}">
        @endif
    @endif
    <label for="sector" class="hide"></label>
    @if (!isset($fundamentals['General']['Type']))
        <input type="text" id="watchlist_ticker_symbol" name="watchlist_ticker_symbol" class="hide" value="{{ $fundamentals[0]["Code"] . ".INDX" }}">
    @else
        <input type="text" id="watchlist_ticker_symbol" name="watchlist_ticker_symbol" class="hide" value="{{ $quote["code"] }}">
    @endif
    <label for="watchlist_ticker_symbol" class="hide"></label>

    <p class="watchlist-text">
        <a id="save-watchlist" onclick="event.preventDefault(); M.toast({html: 'Symbol added to watchlist'})">
            @if (!isset($fundamentals['General']['Type']))
                Add Symbol <b>{{ $fundamentals[0]["Code"] }}</b> to Watchlist
            @else
                Add Symbol <b>{{ $fundamentals["General"]["Code"] }}</b> to Watchlist
            @endif
            <i id="save-watchlist-i" class="far fa-plus-square z-depth-0"></i>
        </a>
    </p>
</form>