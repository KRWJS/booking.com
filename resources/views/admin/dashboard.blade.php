@extends('admin.layouts.admin')

@section('content')

{!! Breadcrumbs::renderIfExists() !!}

    <div class="page-title-well">
        <h2><i class="fa fa-dashboard"></i> CMS dashboard</h2>
    </div>

    @include('admin.partials.notifications')

<!--     <h2><i class="fa fa-envelope"></i> Enquiries</h2>
    <ul>
        <li><a href="#">View contact enquiries</a></li>
        <li><a href="#">View admissions</a></li>
    </ul>
    <hr>
    <h2><i class="fa fa-briefcase"></i> Vacancies</h2>
    <ul>
        <li><a href="#">Fetch vacancies from BigRedSky (may take several minutes)</a></li>
        <li><a href="#">Clean vacancies (removes vacancies that no longer appear in the BigRedSky feed from the CMS)</a></li>
    </ul>
    <hr>
 -->
    <h2><i class="fa fa-exclamation-triangle"></i> Maintenance operations</h2>
    <ul>
        <li><a href="/search/re-index">Rebuild search index</a></li>
    </ul>
    <hr>

@endsection
