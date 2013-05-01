@extends('backend/layouts/default')

{{-- Page title --}}
@section('title')
Create a New Blog Post ::
@parent
@stop

{{-- Page content --}}
@section('content')
<div class="page-header">
	<h3>
		Create a New Blog Post

		<div class="pull-right">
			<a href="{{ URL::to('admin/blogs') }}" class="btn btn-small btn-inverse"><i class="icon-circle-arrow-left icon-white"></i> Back</a>
		</div>
	</h3>
</div>

<!-- Tabs -->
<ul class="nav nav-tabs">
	<li class="active"><a href="#tab-general" data-toggle="tab">General</a></li>
	<li><a href="#tab-meta-data" data-toggle="tab">Meta Data</a></li>
</ul>

<form class="form-horizontal" method="post" action="" autocomplete="off">
	<!-- CSRF Token -->
	<input type="hidden" name="_token" value="{{ csrf_token() }}" />

	<!-- Tabs Content -->
	<div class="tab-content">
		<!-- Tab General -->
		<div class="tab-pane active" id="tab-general">
			<!-- Post Title -->
			<div class="control-group {{ $errors->has('title') ? 'error' : '' }}">
				<label class="control-label" for="title">Post Title</label>
				<div class="controls">
					<input type="text" name="title" id="title" value="{{ Input::old('title') }}" />
					{{ $errors->first('title', '<span class="help-inline">:message</span>') }}
				</div>
			</div>

			<!-- Content -->
			<div class="control-group {{ $errors->has('content') ? 'error' : '' }}">
				<label class="control-label" for="content">Content</label>
				<div class="controls">
					<textarea class="full-width span10" name="content" value="content" rows="10">{{ Input::old('content') }}</textarea>
					{{ $errors->first('content', '<span class="help-inline">:message</span>') }}
				</div>
			</div>
		</div>

		<!-- Meta Data tab -->
		<div class="tab-pane" id="tab-meta-data">
			<!-- Meta Title -->
			<div class="control-group {{ $errors->has('meta-title') ? 'error' : '' }}">
				<label class="control-label" for="meta-title">Meta Title</label>
				<div class="controls">
					<input type="text" name="meta-title" id="meta-title" value="{{ Input::old('meta-title') }}" />
					{{ $errors->first('meta-title', '<span class="help-inline">:message</span>') }}
				</div>
			</div>

			<!-- Meta Description -->
			<div class="control-group {{ $errors->has('meta-description') ? 'error' : '' }}">
				<label class="control-label" for="meta-description">Meta Description</label>
				<div class="controls">
					<input type="text" name="meta-description" id="meta-description" value="{{ Input::old('meta-description') }}" />
					{{ $errors->first('meta-description', '<span class="help-inline">:message</span>') }}
				</div>
			</div>

			<!-- Meta Keywords -->
			<div class="control-group {{ $errors->has('meta-keywords') ? 'error' : '' }}">
				<label class="control-label" for="meta-keywords">Meta Keywords</label>
				<div class="controls">
					<input type="text" name="meta-keywords" id="meta-keywords" value="{{ Input::old('meta-keywords') }}" />
					{{ $errors->first('meta-keywords', '<span class="help-inline">:message</span>') }}
				</div>
			</div>
		</div>
	</div>

	<!-- Form actions -->
	<div class="control-group">
		<div class="controls">
			<a class="btn btn-link" href="{{ URL::to('admin/blogs') }}">Cancel</a>

			<button type="reset" class="btn">Reset</button>

			<button type="submit" class="btn btn-success">Publish</button>
		</div>
	</div>
</form>
@stop
