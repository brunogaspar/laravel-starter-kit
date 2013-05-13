@extends('backend/layouts/default')

{{-- Page title --}}
@section('title')
User Management ::
@parent
@stop

{{-- Page content --}}
@section('content')
<div class="page-header">
	<h3>
		User Management

		<div class="pull-right">
			<a href="{{ route('create/user') }}" class="btn btn-small btn-info"><i class="icon-plus-sign icon-white"></i> Create</a>
		</div>
	</h3>
</div>

<a href="{{ URL::to('admin/users?withTrashed=true') }}">Include Deleted</a>

{{ $users->links() }}

<table class="table table-bordered table-striped table-hover">
	<thead>
		<tr>
			<th class="span2">@lang('admin/users/table.first_name')</th>
			<th class="span2">@lang('admin/users/table.last_name')</th>
			<th class="span3">@lang('admin/users/table.email')</th>
			<th class="span3">@lang('admin/users/table.groups')</th>
			<th class="span2">@lang('admin/users/table.activated')</th>
			<th class="span2">@lang('admin/users/table.created_at')</th>
			<th class="span2">@lang('table.actions')</th>
		</tr>
	</thead>
	<tbody>
		@foreach ($users as $user)
		<tr>
			<td>{{ $user->first_name }}</td>
			<td>{{ $user->last_name }}</td>
			<td>{{ $user->email }}</td>
			<td>{{ implode(', ', array_map(function($group) { return $group->name; }, $user->groups->all())) }}</td>
			<td>@lang('general.' . ($user->isActivated() ? 'yes' : 'no'))</td>
			<td>{{ $user->created_at->diffForHumans() }}</td>
			<td>
				<a href="{{ route('update/user', $user->id) }}" class="btn btn-mini">@lang('button.edit')</a>

				@if ( ! is_null($user->deleted_at))
				<a href="{{ route('restore/user', $user->id) }}" class="btn btn-mini btn-warning">@lang('button.restore')</a>
				@else
				@if (Sentry::getId() !== $user->id)
				<a href="{{ route('delete/user', $user->id) }}" class="btn btn-mini btn-danger">@lang('button.delete')</a>
				@endif
				@endif
			</td>
		</tr>
		@endforeach
	</tbody>
</table>

{{ $users->links() }}
@stop
