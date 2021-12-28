<div class="card" id="side-menu-items-card">
    <div class="card-content" id="side-menu-items-card-content">
        <div class="row no-margin-bottom">
            <div class="col s12 no-padding-left no-padding-right">
                <h6 class="margin-bottom-15 yellow-indicator bracket-label">Menu</h6>
            </div>
        </div>
        <div class="row" id="menu-icon-row">
            <div class="col s12 no-padding-left no-padding-right">
                <ul>
                    <li><h5 class="silver-indicator"><i class="fal fa-analytics silver-indicator"></i> Chart Settings <span><i class="fal fa-angle-right black-contrast-text right"></i></span></h5></li>
                    <li><h5 class="silver-indicator"><i class="fal fa-layer-group silver-indicator"></i> Watchlist <span><i class="fal fa-angle-right black-contrast-text right"></i></span></h5></li>
                    <li><h5 class="silver-indicator"><i class="fal fa-address-card silver-indicator"></i> Profile <span><i class="fal fa-angle-right black-contrast-text right"></i></span></h5></li>
                    <li><h5 class="silver-indicator"><i class="fal fa-brain silver-indicator"></i> Methodology <span><i class="fal fa-angle-right black-contrast-text right"></i></span></h5></li>
                    <li><h5 class="silver-indicator"><i class="fal fa-chess-queen-alt silver-indicator"></i> Trade Strategy <span><i class="fal fa-angle-right black-contrast-text right"></i></span></h5></li>
                    <li><h5 class="silver-indicator"><i class="fal fa-handshake-alt silver-indicator"></i> About <span><i class="fal fa-angle-right black-contrast-text right"></i></span></h5></li>
                    <li><h5 class="silver-indicator"><i class="fal fa-envelope-open-text silver-indicator"></i> Contact <span><i class="fal fa-angle-right black-contrast-text right"></i></span></h5></li>
                    <li>
                        <h5 class="silver-indicator"><i class="fal fa-envelope-open-text silver-indicator"></i>
                            <a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" class=""> Logout <span><i class="fal fa-angle-right black-contrast-text right"></i></span></a>
                            <form id="logout-form" action="{{ route('logout') }}" method="POST">@csrf</form>
                        </h5>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>