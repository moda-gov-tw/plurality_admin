<thead>
    <!--begin::Table row-->
    <tr class="text-start text-gray-400 fw-bolder fs-7 text-uppercase gs-0">
        @foreach( $header as $key=>$val)
            <th class="min-w-150px">{{trans('table.'.$val)}}</th>
        @endforeach
    </tr>
    <!--end::Table row-->
</thead>