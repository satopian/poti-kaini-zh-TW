{{-- メインとカタログのページング --}}
<nav>
	<div class="pagelink">
	<div class="pagelink_prev">@if ($prev)<a href="{{$prev}}">≪上一頁</a>@endif
	</div>
	<div class="pagelink_top"><a href="{{$self2}}">留言板頂部</a></div>
	<div class="pagelink_next">@if ($next)<a href="{{$next}}">下一頁≫</a>@endif</div>
	</div>
</nav>
	