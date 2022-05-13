<div class="row">
	
	<ul class="breadcrumb breadcrumb-separatorless col-12">
		<!--begin::Item-->
		<li class="breadcrumb-item text-muted">
			<a href="{{route('admin.dashboard')}}" class="text-muted text-hover-primary">Home</a>
		</li>
		@foreach ($breadcrumbs as $breadcrumb)
		<li class="breadcrumb-item">
			<span class="bullet  w-5px h-2px"></span>
		</li>
			
				@isset($breadcrumb['route'])
					<a href="{{ $breadcrumb['route'] }}" class="text-muted text-hover-primary">
                    
				@endisset
                
					{{ $breadcrumb['title'] }}

				@isset($breadcrumb['route'])
					</a>
                    <li class="breadcrumb-item {{ $loop->last ? 'active' : '' }}">
                        <span class="bullet  w-5px h-2px"></span>
                    </li>
				@endisset
			</li>

				
		</li>
		
		@endforeach
		
	</ul>
	<!--end::Breadcrumb-->
</div>