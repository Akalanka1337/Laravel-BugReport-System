<script>
    var noTableData = '{{trans('global.noTableData')}}';
    var tableInfo = '{{trans('global.tableInfo')}}';
    var dragDropTableInfo = '{{trans('global.dragDropTableInfo')}}';
    var lengthMenu = {!!config("admiko_config.length_menu_table_JS")!!};
    var csrf_token = "{{ csrf_token() }}";
    var mapStartZoom = {{config('admiko_config.map_start_zoom')}};
    var mapStarLatitude = {{config('admiko_config.map_star_latitude')}};
    var mapStarLongitude = {{config('admiko_config.map_star_longitude')}};
    /*Admiko Global Search*/
    var AdmikoGlobalSearchUrl = '{{route("dashboard.admiko_global_search")}}';
    var searchTypeMore = '{{trans('global.search_type_more')}}';
    var searchNoResults = '{{trans('global.search_no_results')}}';
    var searchError = '{{trans('global.search_error')}}';
</script>
<script src="{{ asset('assets/admiko/vendors/bootstrap/js/bootstrap.bundle.min.js') }}"></script>

<script src="{{ asset('assets/admiko/vendors/jquery/jquery-3.4.1.min.js') }}"></script>
<script src="{{ asset('assets/admiko/vendors/jquery-ui-1.12.1/jquery-ui.min.js') }}"></script>
<script src="{{ asset('assets/admiko/vendors/datepicker/moment.min.js') }}"></script>
<script src="{{ asset('assets/admiko/vendors/datepicker/tempusdominus-bootstrap-4.min.js') }}"></script>
<script src="{{ asset('assets/admiko/vendors/select2/js/select2.full.js') }}"></script>
<script src="{{ asset('assets/admiko/vendors/tinymce/tinymce.min.js') }}"></script>
<script src="{{ asset('assets/admiko/vendors/datatables/datatables.min.js') }}"></script>
<script src="{{ asset('assets/admiko/js/default.js') }}"></script>
@if(config('admiko_config.google_map_api_key'))
    <script src="//maps.googleapis.com/maps/api/js?key={{config('admiko_config.google_map_api_key')}}&callback=startGoogleMaps" async defer></script>
@endIf
@if(config('admiko_config.bing_map_api_key'))
    <script>
        var bingKey = "{{config('admiko_config.bing_map_api_key')}}";
    </script>
    <script type='text/javascript' src='//www.bing.com/api/maps/mapcontrol?callback=startBingMaps' async defer></script>
@endIf
@yield('footerCode')
