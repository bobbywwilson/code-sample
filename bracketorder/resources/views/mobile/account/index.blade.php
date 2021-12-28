
@extends('mobile.layouts._layout')

@section('content')

    <div class="container">
        {{-- <div class="row current-bracket-name-row">
            <div class="col s4"></div>
            <div class="col s4">
                <h5 class="center-align white-indicator underline current-bracket-name">AMZN US EQUITY</h5>
            </div>
            <div class="col s4"></div>
        </div> --}}
        <div class="card" id="quote-card">
            <div class="card-image">
                <div class="row">
                    <div class="col s6 no-padding-right">
                        <h5 class="white-indicator no-margin-left" id="bracket-symbol"></h5>
                    </div>
                    <div class="col s6">
                        <h6 class="silver-indicator"><i data-target="slide-out-chart" class="sidenav-trigger fal fa-analytics right settings" id="chart-open-mobile"></i></h6>
                        <h6 class="silver-indicator"><i class="fal fa-cog right settings hide"></i></h6>
                        <h6 class="silver-indicator"><i class="fal fa-plus-circle right settings"></i></h6>
                        <h6 class="silver-indicator"><i class="fal fa-list right settings"></i></h6>
                    </div>
                </div>
            </div>

            <div class="card-content" id="quote-card-content">
                <div class="row no-margin-bottom">
                    <table id="quote-table">
                        <tr>
                            <td><h5 class="white-indicator last-price no-margin" id="last-price"></h5></td>
                            <td><h6 class="no-margin"><i class="indicator-color"></i><span class="change"></span></h6></td>
                            <td><h6 class="no-margin third-padding"><i class="indicator-color"></i><span class="percent-change"></span></h6></td>
                            <td><h6 class="small-text grey-indicator small-text-line-height no-margin right-align">@ <span class="trade-time"></span></h6></td>
                        </tr>
                    </table>
                </div>
            
                <div class="row no-margin-bottom">
                    <div class="col s12 no-padding-left no-padding-right price-top-margin">
                        <h6 class="margin-bottom-15 yellow-indicator bracket-label no-margin-left">
                            Price Table
                            <span class="smaller-text grey-indicator spacer period" id="period"></span>
                            <span class="smaller-text silver-indicator start-date" id="start-date"></span>
                            <span class="smaller-text silver-indicator spacer">Period: </span>
                            <span class="smaller-text silver-indicator period-frequency" id="period-frequency"></span>
                        </h6>
                    </div>
                </div>
                <div class="row">
                    <div class="col s6 no-padding-left no-padding-right">
                        <h6 class="small-text margin-bottom-10 no-margin-left give-right-padding">
                            <i class="small-text fas fa-square yellow-indicator"></i> 
                            <span class="grey-indicator">Start</span>
                            <span class="spacer start-price float-right" id="start-price"></span>
                        </h6>
                        <h6 class="small-text margin-bottom-10 no-margin-left give-right-padding">
                            <i class="small-text fas fa-square white-indicator"></i> 
                            <span class="grey-indicator">High on</span>
                            <span class="grey-indicator high-date" id="high-date"></span>
                            <span class="spacer high-price-period float-right" id="high-price-period"></span>
                        </h6>
                        <h6 class="small-text margin-bottom-10 no-margin-left give-right-padding">
                            <i class="small-text fas fa-square white-indicator"></i> 
                            <span class="grey-indicator"> Open</span> 
                            <span class="spacer open-price float-right" id="open-price"></span>
                        </h6>
                        <h6 class="small-text margin-bottom-10 no-margin-left give-right-padding">
                            <i class="small-text fas fa-square red-indicator"></i> 
                            <span class="grey-indicator"> Low</span> 
                            <span class="spacer low-price float-right" id="low-price"></span>
                        </h6>
                    </div>
                    <div class="col s6 no-padding-left no-padding-right">
                        <h6 class="small-text margin-bottom-10 no-margin-left give-left-padding">
                            <i class="small-text fas fa-square white-indicator"></i> 
                            <span class="quote-label"> Change</span> 
                            <span class="price-change float-right" id="price-change"></span>
                        </h6>
                        <h6 class="small-text margin-bottom-10 no-margin-left give-left-padding">
                            <i class="small-text fas fa-square white-indicator"></i> 
                            <span class="grey-indicator">Low on</span>
                            <span class="grey-indicator low-date" id="low-date"></span>
                            <span class="spacer low-price-period float-right" id="low-price-period"></span>
                        </h6>
                        <h6 class="small-text margin-bottom-10 no-margin-left give-left-padding">
                            <i class="small-text fas fa-square green-indicator"></i> 
                            <span class="grey-indicator"> High</span> 
                            <span class="spacer high-price float-right" id="high-price"></span>
                        </h6>
                        <h6 class="small-text margin-bottom-10 no-margin-left give-left-padding">
                            <i class="small-text fas fa-square grey-indicator"></i> 
                            <span class="grey-indicator"> Close</span> 
                            <span class="spacer close-price float-right"></span>
                        </h6>
                    </div>
                </div>
            </div>
        </div>

        <div class="card" id="bracket-card">
            <div class="card-image">
                <div class="row">
                    <div class="col s6 no-padding-right">
                        <h5 class="white-indicator no-margin-left" id="bracket-symbol">Bracket Order</h5>
                    </div>
                    <div class="col s6">
                        <h6 class="silver-indicator"><i class="fal fa-info-circle right settings"></i></h6>
                        {{-- <h6 class="silver-indicator"><i class="fal fa-expand-alt right settings"></i></h6> --}}
                        {{-- <h6 class="silver-indicator"><i class="fal fa-analytics right settings"></i></h6> --}}
                    </div>
                </div>
            </div>

            <div class="card-content" id="bracket-card-content">
                <div class="row" id="bracketorder-quote"></div>
            </div>
        </div>

        <div class="card" id="technicals-card">
            <div class="card-image">
                <div class="row">
                    <div class="col s6 no-padding-right">
                        <h5 class="white-indicator no-margin-left" id="technicals">Technicals</h5>
                    </div>
                    <div class="col s6">
                        {{-- <h6 class="silver-indicator"><i class="fal fa-expand-alt right settings"></i></h6> --}}
                        {{-- <h6 class="silver-indicator"><i class="fal fa-analytics right settings"></i></h6> --}}
                    </div>
                </div>
            </div>

            <div class="card-content" id="technicals-card-content">
                <div class="row" id="technicals-card-quote"></div>
            </div>
        </div>
        
        <div class="sidenav slide-out-chart" id="slide-out-chart">
            <div class="card">
                <div class="card-content" id="chart-card-content">
                    <div class="row">
                        {{-- <a class="btn"><i class="fal fa-analytics"></i> <span class="button-text">Studies</span></a> --}}
                        @include('mobile.partials.chart.maximized-chart')
                        <div class="col s12 no-padding-left" id="chart"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection