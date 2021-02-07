@extends('admin.layouts.admin')

@section('content')

{!! Breadcrumbs::renderIfExists() !!}

<div class="page-title-well">
    <h2><i class="fa fa-file-text-o"></i> Applications overview</h2>
    <p class="subtitle">The category determines where on the website the page is displayed</p>
</div>

@include('admin.partials.notifications')

<div class="table">
    <table class="table table-bordered table-striped table-hover" id="pages-table">
        <thead>
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Email</th>
            <th>Mobile</th>
            <th>Create at</th>
            <th>Read</th>
            <th>Status</th>
            <th><i class="fa fa-cogs" aria-hidden="true"></i></th>
        </tr>
        </thead>
    </table>
</div>

@endsection

@push('scripts')
<script>
    $(function() {
        $('#pages-table').DataTable({
            processing: true,
            serverSide: true,
            ajax: '{!! route('comasy.application.data') !!}',
            order: [ [1, 'asc'] ],
            columns: [
                { data: 'id', name: 'id' },
                { data: 'name', name: 'name' },
                { data: 'email', name: 'email' },
                { data: 'mobile', name: 'mobile' },
                { data: 'create_at', name: 'create_at' },
                { data: 'is_read', name: 'is_read' },
                { data: 'status', name: 'status', searchable: false },
                { data: 'actions', name: 'actions', searchable: false, sortable: false }
            ]
        });
    });
</script>
@endpush
