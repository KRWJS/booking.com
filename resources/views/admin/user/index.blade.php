@extends('admin.layouts.admin')

@section('content')

{!! Breadcrumbs::renderIfExists() !!}

<div class="page-title-well">
    <h2><i class="fa fa-users"></i> Users overview <a href="{{ route('comasy.user.create') }}" class="btn btn-success pull-right"><i class="fa fa-user-plus"></i> New user</a></h2>
    <p class="subtitle">Below users have access to the CMS</p>
</div>

@include('admin.partials.notifications')

<div class="table-responsive">
    <table class="table table-bordered table-striped table-hover" id="users-table">
        <thead>
        <tr>
            <th>Name</th>
            <th>Email</th>
            <th>Activated</th>
            <th>Last login</th>
            <th><i class="fa fa-cogs" aria-hidden="true"></i></th>
        </tr>
        </thead>
    </table>
</div>

@endsection

@push('scripts')
<script>
    $(function() {
        $('#users-table').DataTable({
            processing: true,
            serverSide: true,
            ajax: '{!! route('comasy.user.data') !!}',
            order: [ [3, 'desc'] ],
            columns: [
                { data: 'name', name: 'name' },
                { data: 'email', name: 'email' },
                { data: 'activated', name: 'activated', searchable: false },
                { data: 'last_login', name: 'last_login', searchable: false },
                { data: 'actions', name: 'actions', searchable: false, sortable: false }
            ]
        });
    });
</script>
@endpush
