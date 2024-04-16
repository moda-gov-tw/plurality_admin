<x-base-layout>
    @if (session('news_create_message') === 'success')

    <script type="text/javascript">alert("{{ __('content-management.create_news_success') }}");</script>

    @elseif (session('news_create_message') === 'failed')

    <script type="text/javascript">alert("{{ __('content-management.create_news_failed') }}");</script>

    @elseif (session('news_edit_message') === 'success')

    <script type="text/javascript">alert("{{ __('content-management.edit_news_success') }}");</script>

    @elseif (session('news_edit_message') === 'failed')

    <script type="text/javascript">alert("{{ __('content-management.edit_news_failed') }}");</script>
    
    @endif
    
    <!--begin::Modal Container-->
    
    <!--end::Modal Container-->
    <div class="d-flex flex-column flex-row-fluid">
        <div class="card card-flush mb-2">
            <div class="card-header">
                <h3 class="card-title">&nbsp;</h3>
                <div class="card-toolbar">
                    <a class="btn btn-sm btn-success" href="{{route('content-management.create-news')}}">
                        {{__('content-management.create_news')}}
                    </a>
                </div>
            </div>
            <div class="card-body">
                <div class="d-flex flex-column flex-row-fluid">
                    
                    <div class="row">
                        <!--begin::Table-->
                        <table class="table table-head-custom align-middle" id="news_list_table"></table>
                        <!--end::Table-->
                    </div>
                </div>
            </div>
        </div>
    </div>




</x-base-layout>
