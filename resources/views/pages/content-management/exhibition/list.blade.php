<x-base-layout>
    @if (session('exhibition_create_message') === 'success')

    <script type="text/javascript">alert("{{ __('content-management.create_exhibition_success') }}");</script>

    @elseif (session('exhibition_create_message') === 'failed')

    <script type="text/javascript">alert("{{ __('content-management.create_exhibition_failed') }}");</script>

    @elseif (session('exhibition_edit_message') === 'success')

    <script type="text/javascript">alert("{{ __('content-management.edit_exhibition_success') }}");</script>

    @elseif (session('exhibition_edit_message') === 'failed')

    <script type="text/javascript">alert("{{ __('content-management.edit_exhibition_failed') }}");</script>
    
    @endif
    
    <!--begin::Modal Container-->
    
    <!--end::Modal Container-->
    <div class="d-flex flex-column flex-row-fluid">
        <div class="card card-flush mb-2">
            <div class="card-header">
                <h3 class="card-title">&nbsp;</h3>
                <div class="card-toolbar">
                    <a class="btn btn-sm btn-success" href="{{route('content-management.create-exhibition')}}">
                        {{__('content-management.create_exhibition')}}
                    </a>
                </div>
            </div>
            <div class="card-body">
                <div class="d-flex flex-column flex-row-fluid">
                    
                    <div class="row">
                        <!--begin::Table-->
                        <table class="table table-head-custom align-middle" id="exhibition_list_table"></table>
                        <!--end::Table-->
                    </div>
                </div>
            </div>
        </div>
    </div>




</x-base-layout>
