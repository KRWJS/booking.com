@extends('admin.layouts.admin')

@section('content')

{!! Breadcrumbs::renderIfExists() !!}

<div class="page-title-well">
    <h2><i class="fa fa-file-text-o"></i> Pages overview</h2>
    <p class="subtitle">The category determines where on the website the jobs is displayed</p>
</div>

@include('admin.partials.notifications')

<div class="table">
    <table class="table table-bordered table-striped table-hover" id="pages-table">
        <thead>
        <tr>
            <th>Job Id</th>
            <th>Title</th>
            <th>Department</th>
            <th>Country</th>
            <th>City</th>
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
            ajax: '{!! route('comasy.jobs.data') !!}',
            order: [ [1, 'asc'] ],
            columns: [
                { data: 'job_id', name: 'job_id' },
                { data: 'title', name: 'title' },
                { data: 'department', name: 'department' },
                { data: 'country', name: 'country' },
                { data: 'city', name: 'city' },
                { data: 'status', name: 'status', searchable: false },
                { data: 'actions', name: 'actions', searchable: false, sortable: false }
            ]
        });
    });
</script>
@endpush
