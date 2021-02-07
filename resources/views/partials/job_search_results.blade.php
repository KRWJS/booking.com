@if($hasResults)

@foreach($results as $idx => $result)
<a class="btn btn-booking-lg--white u-equalHMV" href="{{route('jobs-detail',['id'=>$result['_id']])}}" role="button">
	<!-- <h4 class="ribbon ribbon--green">@lang('messages.jobs.new')</h4> -->
	@if(DB::table('jobs')->where('id',$result['_id'])->first()->apply_count > 10) <h4 class="ribbon ribbon--red">@lang('messages.jobs.hot')</h4> @endif

	<span>{{ $result['_source']['title'] }}</span>
	{{ $result['_source']['department'] }}
	<ul class="list-inline u-mt-15">
		@if($result['_source']['flag'] != '')
		<li>
			<img src="/images/flag-icons/{{$result['_source']['flag']}}.svg" class="flag flag--{{$result['_source']['country']}}"/>
		</li>
		@endif
		<li>
		{!! trans('messages.cities.'.$result['_source']['city']) !!}
		</li>
	</ul>
</a>
@endforeach

@else

<div class="no_results">
	<p>{!! trans('messages.jobs.noresults', ['search_query' => $searchQuery]) !!}</p>
</div>

@endif
