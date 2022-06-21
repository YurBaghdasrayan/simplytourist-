<div class="side-menu sidebar-inverse">

</div>
<script>
    (function () {
        var appContainer = document.querySelector('.app-container'),
            sidebar = appContainer.querySelector('.side-menu'),
            navbar = appContainer.querySelector('nav.navbar.navbar-top'),
            loader = document.getElementById('voyager-loader'),
            hamburgerMenu = document.querySelector('.hamburger'),
            sidebarTransition = sidebar.style.transition,
            navbarTransition = navbar.style.transition,
            containerTransition = appContainer.style.transition;

        sidebar.style.WebkitTransition = sidebar.style.MozTransition = sidebar.style.transition =
            appContainer.style.WebkitTransition = appContainer.style.MozTransition = appContainer.style.transition =
                navbar.style.WebkitTransition = navbar.style.MozTransition = navbar.style.transition = 'none';

        if (window.innerWidth > 768 && window.localStorage && window.localStorage['voyager.stickySidebar'] == 'true') {
            appContainer.className += ' expanded no-animation';
            loader.style.left = (sidebar.clientWidth / 2) + 'px';
            hamburgerMenu.className += ' is-active no-animation';
        }

        navbar.style.WebkitTransition = navbar.style.MozTransition = navbar.style.transition = navbarTransition;
        sidebar.style.WebkitTransition = sidebar.style.MozTransition = sidebar.style.transition = sidebarTransition;
        appContainer.style.WebkitTransition = appContainer.style.MozTransition = appContainer.style.transition = containerTransition;
    })();
</script>
<!-- Main Content -->
<div class="container-fluid">
    <div class="side-body padding-top">
        <div id="voyager-notifications"></div>

    @php
        $dataTypeRows = $dataType->{(isset($dataTypeContent->id) ? 'editRows' :'addRows' )};
    @endphp

    @foreach($dataTypeRows as $row)
        <!-- GET THE DISPLAY OPTIONS -->
            @php
                $options = $row->details;
                $display_options = isset($options->display) ? $options->display : NULL;
            @endphp
            @if ($options && isset($options->formfields_custom))
                @include('voyager::formfields.custom.' . $options->formfields_custom)
            @else
                <div class="form-group @if($row->type == 'hidden') hidden @endif @if(isset($display_options->width)){{ 'col-md-' . $display_options->width }}@else{{ '' }}@endif" @if(isset($display_options->id)){{ "id=$display_options->id" }}@endif>
                    {{ $row->slugify }}
                    <label for="name">{{ $row->display_name }}</label>
                    @include('voyager::multilingual.input-hidden-bread-edit-add')
                    @if($row->type == 'relationship')
                        @include('voyager::formfields.relationship')
                    @else
                        {!! app('voyager')->formField($row, $dataType, $dataTypeContent) !!}
                    @endif

                    @foreach (app('voyager')->afterFormFields($row, $dataType, $dataTypeContent) as $after)
                        {!! $after->handle($row, $dataType, $dataTypeContent) !!}
                    @endforeach
                </div>
            @endif
        @endforeach
    </div>
</div>
<script>
    let vm = this;
</script>
<script src="/admin/voyager-assets?path=js%2Fapp.js"></script>
<script type="text/javascript" src="http://localhost:8000/admin/voyager-assets?path=js%2Fapp.js"></script>

<style>
    .dd-placeholder {
        flex: 1;
        width: 100%;
        min-width: 200px;
        max-width: 250px;
    }

    .select2-container .select2-selection--single {
        height: 40px;
    }
</style>
